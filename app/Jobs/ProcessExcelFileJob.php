<?php


namespace App\Jobs;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\FileHandlingModule_model;
use Illuminate\Support\Facades\DB; // For debugging


// use App\Events\ExcelImportProgress;

class ProcessExcelFileJob implements ShouldQueue
{
      use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

      protected $filePath;


    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        //
          $this->filePath = $filePath;

          // Log::info('Job File path ' . $this->filePath);

    }

    /**
     * Execute the job.
     */
     public function handle()
        {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($this->filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $isFirstRow = true;

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];

                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Skip the first row (header row)
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }

                // Validate row data
                if (count($rowData) < 6) {
                    Log::warning('Incomplete row data: ', $rowData);
                    continue;
                }

                $unique_id = mt_rand(100000000000, 999999999999);

                // Prepare data for insertion
                $insertData = [
                    'unique_id' => $unique_id,
                    'date_of_installation' => $rowData[0],
                    'seal_name' => $rowData[1],
                    'installed_at' => $rowData[2],
                    'type' => $rowData[3],
                    'use' => $rowData[4],
                    'client' => $rowData[5],
                ];
                unset($insertData[0]);

                Log::info('Inserting data: ', $insertData);

                try {
                    $result = FileHandlingModule_model::create($insertData);
                    Log::info('Insert result: ', ['result' => $result]);
                } catch (\Exception $e) {
                    Log::error('Error inserting data: ' . $e->getMessage());
                }
            }

            Log::info('Excel file processing completed: ' . $this->filePath);
        }




}
