<?php

namespace App\Imports;

use App\Models\FileHandlingModule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Illuminate\Support\Facades\Log;
// use App\Events\ExcelImportProgress;

class YourExcelImportClass implements ToModel, WithChunkReading, WithProgressBar
{
    private $totalRows;
    private $currentRow = 0;

    public function __construct($totalRows)
    {
        $this->totalRows = $totalRows;
    }

    public function model(array $row)
    {
        $this->currentRow++;

        // Broadcast progress
        $progress = ($this->currentRow / $this->totalRows) * 100;
        // broadcast(new ExcelImportProgress($progress));

        // Process and save the row
        $unique_id = mt_rand(100000000000, 999999999999);

        return new FileHandlingModule([
            'unique_id' => $unique_id,
            'date_of_installation' => $row[0],
            'seal_name' => $row[1],
            'installed_at' => $row[2],
            'type' => $row[3],
            'use' => $row[4],
            'client' => $row[5],
            // Add other columns as needed
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
