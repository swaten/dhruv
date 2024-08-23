<?php


namespace App\Jobs;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
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
      protected $chunkSize = 500;
      // public $tries = 5;
      // public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        //
          $this->filePath = $filePath;

          // Log::info('Job File path ' . $this->filePath);

    }

    private function generateUniqueId()
    {
        do {
            $unique_id = mt_rand(100000000000, 999999999999);
        } while (FileHandlingModule_model::where('unique_id', $unique_id)->exists());

        return $unique_id;
    }

    /**
     * Execute the job.
     */
     public function handle()
    {
        try {
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($this->filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $totalRows = $worksheet->getHighestDataRow();

            for ($startRow = 2; $startRow <= $totalRows; $startRow += $this->chunkSize) {
                $endRow = min($startRow + $this->chunkSize - 1, $totalRows);

                $filter = new ChunkReadFilter($startRow, $endRow);
                $reader->setReadFilter($filter);

                $batchData = [];
                foreach ($worksheet->getRowIterator($startRow, $endRow) as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $rowData = [];
                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }

                    if (count($rowData) >= 6) {
                        $batchData[] = [
                            'unique_id' => $this->generateUniqueId(),
                            'date_of_installation' => $rowData[0],
                            'seal_name' => $rowData[1],
                            'installed_at' => $rowData[2],
                            'type' => $rowData[3],
                            'use' => $rowData[4],
                            'client' => $rowData[5],
                        ];
                    } else {
                        Log::warning('Incomplete row data: ', $rowData);
                    }
                }

                if (!empty($batchData)) {
                    try {
                        // Insert data into the database
                        DB::table('client_details')->insert($batchData);
                        Log::info('Batch insert completed for rows: ' . $startRow . ' to ' . $endRow);
                    } catch (\Exception $e) {
                        Log::error('Error inserting batch data: ' . $e->getMessage());
                        Log::error('Batch data: ', $batchData);
                    }
                }
            }

            Log::info('Excel file processing completed: ' . $this->filePath);
        } catch (\Exception $e) {
            Log::error('Job failed: ' . $e->getMessage());
            throw $e;
        }
    }

     public function handle_old_function()
        {
            // Load the spreadsheet
          try {
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = IOFactory::load($this->filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // $isFirstRow = true;
            $totalRows = $worksheet->getHighestDataRow();  // Lets get total number of rows to calculate how many records are there in our sheet


            for ($startRow = 2; $startRow <= $totalRows; $startRow += $this->chunkSize) {
                $endRow = min($startRow + $this->chunkSize - 1, $totalRows); // This will give us the minimum value from the total rows and end row which is also the current end row

                $filter = new ChunkReadFilter($startRow, $endRow); //Creating Chunk filter for our upcoming rows
                $reader->setReadFilter($filter);

                $batchData = [];
                foreach ($worksheet->getRowIterator() as $row) {
                    $rowIndex = $row->getRowIndex();
                    // if ($rowIndex < $startRow || $rowIndex > $endRow) {
                    //     continue; // Skip rows outside the current chunk ,it will stop the iteration if our rowindex is less than start row or greater than endrow
                    // }


                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $rowData = [];

                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }

                    // // Skip the first row (header row)
                    // if ($isFirstRow) {
                    //     $isFirstRow = false;
                    //     continue;
                    // }

                    // Validate row data
                    if (count($rowData) >= 6) {


                       $batchData[] = [
                           'unique_id' => $this->generateUniqueId(),
                           'date_of_installation' => $rowData[0],
                           'seal_name' => $rowData[1],
                           'installed_at' => $rowData[2],
                           'type' => $rowData[3],
                           'use' => $rowData[4],
                           'client' => $rowData[5],
                       ];
                   } else {
                       Log::warning('Incomplete row data: ', $rowData);
                   }

                    // $unique_id = mt_rand(100000000000, 999999999999);

                    // Prepare data for insertion
                    // $insertData = [
                    //     'unique_id' => $unique_id,
                    //     'date_of_installation' => $rowData[0],
                    //     'seal_name' => $rowData[1],
                    //     'installed_at' => $rowData[2],
                    //     'type' => $rowData[3],
                    //     'use' => $rowData[4],
                    //     'client' => $rowData[5],
                    // ];
                    // $batchData[] = [
                    //     'unique_id' => $unique_id,
                    //     'date_of_installation' => $rowData[0],
                    //     'seal_name' => $rowData[1],
                    //     'installed_at' => $rowData[2],
                    //     'type' => $rowData[3],
                    //     'use' => $rowData[4],
                    //     'client' => $rowData[5],
                    // ];
                    // unset($batchData[0]);

                    Log::info('Batch data: ', $batchData);

                    if (!empty($batchData)) {
                      try {
                          // FileHandlingModule_model::insert($batchData);
                          DB::table('client_details')->insert($batchData);
                          Log::info('Batch insert completed for rows: ' . $startRow . ' to ' . $endRow);
                      } catch (\Exception $e) {
                          Log::error('Error inserting batch data: ' . $e->getMessage());
                      }
                  }
                }
           }
            Log::info('Excel file processing completed: ' . $this->filePath);
          }
          catch (\Exception $e) {
              Log::error('Job failed: ' . $e->getMessage());
              throw $e;
          }

        }




}

class ChunkReadFilter implements IReadFilter
{
    private $startRow;
    private $endRow;

    public function __construct($startRow, $endRow)
    {
        $this->startRow = $startRow;
        $this->endRow = $endRow;
    }

    public function readCell(string $columnAddress, int $row, string $worksheetName = ''): bool
    {
        return $row >= $this->startRow && (!$this->endRow || $row <= $this->endRow);
    }
}
