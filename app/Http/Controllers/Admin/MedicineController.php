<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ExportMedicinesJob;
use App\Jobs\ImportMedicinesJob;
use App\Models\Medicine;
use App\Models\MedicineTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $medicines = Medicine::when($search, fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.medicines.index', compact('medicines', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:100'],
            'dosage_form' => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:100'],
            'dosage_form' => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $medicine->delete();

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }

    public function search(Request $request)
    {
        if (! session('admin_logged_in')) {
            return response()->json(['medicines' => []]);
        }

        $search = $request->string('q')->trim();
        if ($search === '' || mb_strlen($search) < 2) {
            return response()->json(['medicines' => []]);
        }

        $medicines = Medicine::where('name', 'like', '%'.$search.'%')
            ->orWhere(function ($query) use ($search) {
                $query->whereNull('name')
                    ->where('generic_name', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {
                $query->whereNull('name')
                    ->whereNull('generic_name')
                    ->where('strength', 'like', '%'.$search.'%');
            })
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'generic_name', 'strength', 'manufacturer']);

        return response()->json(['medicines' => $medicines]);
    }

    public function export(Request $request, string $format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if (! in_array($format, ['csv', 'excel', 'pdf'], true)) {
            return redirect()->route('admin.medicines.index')->with('error', 'Unsupported export format.');
        }

        $transfer = MedicineTransfer::create([
            'type' => 'export',
            'format' => $format,
            'status' => 'queued',
        ]);

        ExportMedicinesJob::dispatch($transfer->id);

        session()->flash('success', 'Export queued. Keep the queue worker running to generate the file.');

        return $this->index($request);
    }

    public function downloadTransfer(MedicineTransfer $transfer)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($transfer->type !== 'export' || $transfer->status !== 'completed' || ! $transfer->file_path || ! Storage::disk('local')->exists($transfer->file_path)) {
            return redirect()->route('admin.medicines.index')->with('error', 'This export is not ready.');
        }

        return response()->download(
            Storage::disk('local')->path($transfer->file_path),
            basename($transfer->file_path)
        );
    }

    public function downloadSample(string $format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'medicines_sample_template.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Name', 'Generic Name', 'Strength', 'Dosage Form', 'Manufacturer', 'Notes']);
            fputcsv($handle, ['Paracetamol', 'Acetaminophen', '500mg', 'Tablet', 'Square Pharmaceuticals', 'Common pain reliever']);
            fputcsv($handle, ['Amoxicillin', 'Amoxicillin', '250mg', 'Capsule', 'Beximco Pharmaceuticals', 'Antibiotic']);
            fputcsv($handle, ['Omeprazole', 'Omeprazole', '20mg', 'Capsule', 'Incepta Pharmaceuticals', 'Proton pump inhibitor']);
            fputcsv($handle, ['Metformin', 'Metformin HCL', '500mg', 'Tablet', 'Renata Limited', 'Diabetes medication']);
            fputcsv($handle, ['Aspirin', 'Acetylsalicylic Acid', '75mg', 'Tablet', 'ACI Limited', 'Blood thinner']);
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'medicines_sample_template.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Generic Name</th><th>Strength</th><th>Dosage Form</th><th>Manufacturer</th><th>Notes</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Paracetamol</td><td>Acetaminophen</td><td>500mg</td><td>Tablet</td><td>Square Pharmaceuticals</td><td>Common pain reliever</td></tr>';
            echo '<tr><td>Amoxicillin</td><td>Amoxicillin</td><td>250mg</td><td>Capsule</td><td>Beximco Pharmaceuticals</td><td>Antibiotic</td></tr>';
            echo '<tr><td>Omeprazole</td><td>Omeprazole</td><td>20mg</td><td>Capsule</td><td>Incepta Pharmaceuticals</td><td>Proton pump inhibitor</td></tr>';
            echo '<tr><td>Metformin</td><td>Metformin HCL</td><td>500mg</td><td>Tablet</td><td>Renata Limited</td><td>Diabetes medication</td></tr>';
            echo '<tr><td>Aspirin</td><td>Acetylsalicylic Acid</td><td>75mg</td><td>Tablet</td><td>ACI Limited</td><td>Blood thinner</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.medicines.index');
    }

    public function import(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx', 'max:102400'],
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $path = $file->store('medicine-imports', 'local');
        $transfer = MedicineTransfer::create([
            'type' => 'import',
            'format' => strtolower($extension),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'status' => 'queued',
        ]);

        ImportMedicinesJob::dispatch($transfer->id);

        session()->flash('success', 'Import queued. The medicines will appear after the queue worker finishes.');

        return $this->index($request);
    }
}
