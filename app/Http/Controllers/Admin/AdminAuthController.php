<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    protected array $allowedAdmins = [
        'admin@business.com' => ['name' => 'Doctor Admin', 'password' => 'admin123'],
    ];

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            if (session('admin_logged_in')) {
                return redirect()->route('admin.dashboard');
            }

            return view('admin.auth.login');
        }
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = $this->allowedAdmins[$credentials['email']] ?? null;

        if ($admin && $admin['password'] === $credentials['password']) {
            session([
                'admin_logged_in' => true,
                'admin_user' => $admin['name'],
                'admin_email' => $credentials['email'],
                'admin_role' => 'super_admin',
                'admin_permissions' => ['manage_profile', 'manage_sections', 'manage_services', 'manage_education', 'manage_blogs', 'manage_clinics', 'manage_schedules', 'manage_reviews', 'manage_appointments', 'manage_prescriptions', 'manage_roles', 'view_profile', 'view_appointments'],
            ]);

            return redirect()->route('admin.dashboard');
        }

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            
        $role = $user->role()->first();
        $permissions = $role?->permissions ?? [];
                session([
                    'admin_logged_in' => true,
                    'admin_user' => $user->name,
                    'admin_email' => $user->email,
                    'admin_role' => $role?->name,
                    'admin_permissions' => $permissions,
                ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.'])->onlyInput('email');
    }

    public function showSecretSignup()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.signup');
    }

    public function secretSignup(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.login')->with('status', 'User registered successfully. You can now log in.');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email', 'admin_role', 'admin_permissions']);

        return redirect()->route('admin.login');
    }
}
