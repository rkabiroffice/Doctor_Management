<?php

namespace App\Jobs;

use App\Imports\MedicineImport;
use App\Models\MedicineTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportMedicinesJob implements ShouldQueue
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
        $import = new MedicineImport($transfer->id);

        try {
            Excel::import($import, $transfer->file_path, 'local');
            call_user_func([$import, 'finish']);

            $transfer->update([
                'status' => 'completed',
                'processed' => MedicineTransfer::query()->whereKey($transfer->id)->value('processed'),
            ]);
        } catch (\Throwable $exception) {
            $transfer->update([
                'status' => 'failed',
                'error' => mb_substr($exception->getMessage(), 0, 4000),
            ]);

            throw $exception;
        } finally {
            if ($transfer->file_path) {
                Storage::disk('local')->delete($transfer->file_path);
            }
        }
    }
}
