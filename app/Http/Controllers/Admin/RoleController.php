<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class RoleController extends Controller
{
    private array $permissionOptions = [
        'manage_profile',
        'manage_sections',
        'manage_services',
        'manage_education',
        'manage_blogs',
        'manage_clinics',
        'manage_schedules',
        'manage_reviews',
        'manage_appointments',
        'manage_prescriptions',
        'manage_roles',
        'view_profile',
        'view_appointments',
    ];

    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $roles = Role::when($search, fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();
        $users = User::orderBy('name')->get();

        return view('admin.roles.index', compact('roles', 'search', 'users'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $permissionOptions = $this->permissionOptions;

        return view('admin.roles.create', compact('permissionOptions'));
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'string'],
        ]);

        Role::create($validated);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $permissionOptions = $this->permissionOptions;

        return view('admin.roles.edit', compact('role', 'permissionOptions'));
    }

    public function update(Request $request, Role $role)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'string'],
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    public function assignUser(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->update(['role_id' => $validated['role_id']]);

        return redirect()->route('admin.roles.index')->with('success', 'User role assigned successfully.');
    }

    public function export(string $format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if (! in_array($format, ['csv', 'excel', 'pdf'], true)) {
            return redirect()->route('admin.roles.index')->with('error', 'Unsupported export format.');
        }

        $filename = 'roles_'.now()->format('Y-m-d_His');
        $roles = Role::orderBy('name')->get();

        if ($format === 'pdf') {
            $html = view('admin.roles.export', compact('roles'))->render();

            return PDF::loadHTML($html)->download($filename.'.pdf');
        }

        return response()->streamDownload(function () use ($roles, $format) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Description', 'Permissions']);

            foreach ($roles as $role) {
                fputcsv($handle, [
                    $role->name,
                    $role->description,
                    implode(', ', $role->permissions ?? []),
                ]);
            }

            fclose($handle);
        }, $filename.'.'.($format === 'excel' ? 'xls' : 'csv'), [
            'Content-Type' => $format === 'excel' ? 'application/vnd.ms-excel' : 'text/csv',
        ]);
    }

    public function downloadSample(string $format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if (! in_array($format, ['csv', 'excel'], true)) {
            return redirect()->route('admin.roles.index')->with('error', 'Unsupported sample format.');
        }

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Description', 'Permissions']);
            fputcsv($handle, ['Doctor', 'Doctor permissions', 'manage_appointments, manage_prescriptions']);
            fclose($handle);
        }, 'roles_sample.'.($format === 'excel' ? 'xls' : 'csv'));
    }

    public function import(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx', 'max:10240'],
        ]);

        $importFile = app(\App\Services\SpreadsheetImportService::class)->open($validated['file']);
        $handle = $importFile['handle'];
        $header = fgetcsv($handle);
        $imported = 0;
        $errors = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (blank($row[0] ?? null)) {
                continue;
            }

            try {
                Role::create([
                    'name' => trim($row[0]),
                    'description' => $row[1] ?? null,
                    'permissions' => collect(explode(',', $row[2] ?? ''))->map(fn ($permission) => trim($permission))->filter()->values()->all(),
                ]);
                $imported++;
            } catch (\Throwable) {
                $errors++;
            }
        }

        app(\App\Services\SpreadsheetImportService::class)->close($importFile);

        if ($imported === 0) {
            return redirect()->route('admin.roles.index')->with('error', 'No valid roles were imported.');
        }

        $message = "Successfully imported {$imported} roles.";
        if ($errors > 0) {
            $message .= " {$errors} rows failed.";
        }

        return redirect()->route('admin.roles.index')->with('success', $message);
    }
}
