<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SpreadsheetImportService
{
    /**
     * @return array{handle: resource, temporary_path: string|null}
     */
    public function open(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, ['csv', 'txt'], true)) {
            $handle = fopen($file->getRealPath(), 'r');

            if ($handle === false) {
                throw new \RuntimeException('The uploaded file could not be opened.');
            }

            return ['handle' => $handle, 'temporary_path' => null];
        }

        $temporaryPath = tempnam(sys_get_temp_dir(), 'doctor-import-');
        $output = fopen($temporaryPath, 'w');

        if ($output === false) {
            throw new \RuntimeException('A temporary import file could not be created.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

            foreach ($rows as $row) {
                fputcsv($output, $row);
            }
        } catch (\Throwable $exception) {
            fclose($output);
            @unlink($temporaryPath);
            throw new \RuntimeException('The spreadsheet could not be read: '.$exception->getMessage(), 0, $exception);
        }

        fclose($output);
        $handle = fopen($temporaryPath, 'r');

        if ($handle === false) {
            @unlink($temporaryPath);
            throw new \RuntimeException('The converted spreadsheet could not be opened.');
        }

        return ['handle' => $handle, 'temporary_path' => $temporaryPath];
    }

    /** @param array{handle: resource, temporary_path: string|null} $importFile */
    public function close(array $importFile): void
    {
        if (is_resource($importFile['handle'])) {
            fclose($importFile['handle']);
        }

        if ($importFile['temporary_path']) {
            @unlink($importFile['temporary_path']);
        }
    }
}
