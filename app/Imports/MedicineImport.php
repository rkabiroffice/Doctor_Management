<?php

namespace App\Imports;

use App\Models\Medicine;
use App\Models\MedicineTransfer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicineImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    private int $processed = 0;

    public function __construct(private readonly int $transferId)
    {
    }

    public function model(array $row): ?Medicine
    {
        if (blank($row['name'] ?? null)) {
            return null;
        }

        $this->processed++;

        if ($this->processed % 500 === 0) {
            MedicineTransfer::whereKey($this->transferId)->update([
                'processed' => $this->processed,
            ]);
        }

        return new Medicine([
            'name' => $row['name'],
            'generic_name' => $row['generic_name'] ?? null,
            'strength' => $row['strength'] ?? null,
            'dosage_form' => $row['dosage_form'] ?? null,
            'manufacturer' => $row['manufacturer'] ?? null,
            'notes' => $row['notes'] ?? null,
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function finish(): void
    {
        MedicineTransfer::whereKey($this->transferId)->update([
            'processed' => $this->processed,
        ]);
    }
}
