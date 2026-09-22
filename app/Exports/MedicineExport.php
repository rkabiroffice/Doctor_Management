<?php

namespace App\Exports;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicineExport implements FromQuery, WithHeadings, WithMapping
{
    public function query(): Builder
    {
        return Medicine::query()->orderBy('name')->orderBy('id');
    }

    public function headings(): array
    {
        return ['Name', 'Generic Name', 'Strength', 'Dosage Form', 'Manufacturer', 'Notes'];
    }

    public function map($medicine): array
    {
        return [
            $medicine->name,
            $medicine->generic_name,
            $medicine->strength,
            $medicine->dosage_form,
            $medicine->manufacturer,
            $medicine->notes,
        ];
    }
}
