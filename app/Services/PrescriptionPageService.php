<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PrescriptionPageService
{
    public function splitMedicines(Collection $medicines, int $perPage = 17): array
    {
        $pages = [];
        $chunked = $medicines->chunk($perPage);

        foreach ($chunked as $chunk) {
            $pages[] = $chunk->values();
        }

        return $pages;
    }
}
