<?php

namespace App\Imports;

use App\Models\Medicine;
use App\Models\MedicineTransfer;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicineImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    private int $processed = 0;

    private array $medicineKeys = [];

    public function __construct(private readonly int $transferId)
    {
        $columns = [
            'name',
            'generic_name',
            'strength',
            'dosage_form',
            'manufacturer',
        ];

        if (Schema::hasColumn('medicines', 'notes')) {
            $columns[] = 'notes';
        }

        Medicine::query()
            ->get($columns)
            ->each(function (Medicine $medicine) use ($columns): void {
                $this->medicineKeys[$this->medicineKey($medicine->only($columns))] = true;
            });
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

        $data = [
            'name' => $row['name'],
            'generic_name' => $row['generic_name'] ?? null,
            'strength' => $row['strength'] ?? null,
            'dosage_form' => $row['dosage_form'] ?? null,
            'manufacturer' => $row['manufacturer'] ?? null,
        ];

        if (Schema::hasColumn('medicines', 'notes')) {
            $data['notes'] = $row['notes'] ?? null;
        }

        $medicineKey = $this->medicineKey($data);
        if (isset($this->medicineKeys[$medicineKey])) {
            return null;
        }

        $this->medicineKeys[$medicineKey] = true;

        return new Medicine($data);
    }

    private function medicineKey(array $data): string
    {
        return sha1(json_encode(array_values($data), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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
