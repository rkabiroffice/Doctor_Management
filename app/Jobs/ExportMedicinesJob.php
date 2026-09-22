<?php

namespace App\Jobs;

use App\Exports\MedicineExport;
use App\Models\Medicine;
use App\Models\MedicineTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ExportMedicinesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1800;
    public int $tries = 1;

    public function __construct(public int $transferId)
    {
    }

    public function handle(): void
    {
        $transfer = MedicineTransfer::findOrFail($this->transferId);
        $transfer->update(['status' => 'processing']);

        try {
            $extension = $this->extension($transfer->format);
            $path = 'medicine-exports/medicines_'.$transfer->id.'_'.now()->format('Ymd_His').'.'.$extension;
            Storage::disk('local')->makeDirectory('medicine-exports');

            if ($transfer->format === 'csv') {
                $this->writeCsv($path);
            } elseif (in_array($transfer->format, ['excel', 'xls', 'xlsx'], true)) {
                ExcelFacade::store(new MedicineExport, $path, 'local', $transfer->format === 'xls' ? Excel::XLS : Excel::XLSX);
            } else {
                Storage::disk('local')->put($path, PDF::loadHTML($this->htmlReport())->output());
            }

            $transfer->update([
                'status' => 'completed',
                'file_path' => $path,
            ]);
        } catch (\Throwable $exception) {
            $transfer->update([
                'status' => 'failed',
                'error' => mb_substr($exception->getMessage(), 0, 4000),
            ]);

            throw $exception;
        }
    }

    private function writeCsv(string $path): void
    {
        $handle = fopen(Storage::disk('local')->path($path), 'w');
        fputcsv($handle, (new MedicineExport)->headings());

        Medicine::query()->orderBy('name')->orderBy('id')->chunk(500, function ($medicines) use ($handle) {
            foreach ($medicines as $medicine) {
                fputcsv($handle, (new MedicineExport)->map($medicine));
            }
        });

        fclose($handle);
    }

    private function htmlReport(): string
    {
        $html = '<html><head><meta charset="UTF-8"><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background:#f4f4f4;}</style></head><body><h1>Medicines Report</h1><table><thead><tr><th>Name</th><th>Generic</th><th>Strength</th><th>Form</th><th>Manufacturer</th></tr></thead><tbody>';

        Medicine::query()->orderBy('name')->orderBy('id')->chunk(500, function ($medicines) use (&$html) {
            foreach ($medicines as $medicine) {
                $html .= '<tr><td>'.e($medicine->name).'</td><td>'.e($medicine->generic_name ?? '').'</td><td>'.e($medicine->strength ?? '').'</td><td>'.e($medicine->dosage_form ?? '').'</td><td>'.e($medicine->manufacturer ?? '').'</td></tr>';
            }
        });

        return $html.'</tbody></table></body></html>';
    }

    private function extension(string $format): string
    {
        return match ($format) {
            'csv' => 'csv',
            'excel', 'xlsx' => 'xlsx',
            'xls' => 'xls',
            default => 'pdf',
        };
    }
}
