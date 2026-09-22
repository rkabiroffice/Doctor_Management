<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PrescriptionPageService
{
    public function splitMedicines(Collection $medicines, int $perPage = 6): array
    {
        $pages = [];
        $chunked = $medicines->chunk($perPage);

        foreach ($chunked as $chunk) {
            $pages[] = $chunk->values();
        }

        if ($pages === []) {
            $pages[] = collect();
        }

        return $pages;
    }
}
