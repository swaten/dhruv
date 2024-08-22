<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessExcelFileJob;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Log;
use App\Models\FileHandlingModule_model;
use Yajra\DataTables\DataTables;
use ZipArchive;



class FileHandlingModule extends Controller
{
    public function upload_excel_file(Request $request){
         $request->validate([
             'task_import' => 'required|file|mimes:xlsx,csv,xls'
         ]);

         $file = $request->file('task_import');
         $destinationPath = base_path('dataupload');
         $fileName = time() . '_' . $file->getClientOriginalName();
         $file->move($destinationPath, $fileName);

         $fullPath = $destinationPath . '/' . $fileName;

          ProcessExcelFileJob::dispatch($fullPath);
          return response()->json(
            ['status'=>'200',
              'message' => 'File uploaded successfully. Processing will begin shortly.',
              'file_name'=>$fileName,
              'file_path'=>$fullPath,
              'destinationPath'=>$destinationPath],
          200);

    }
    public function upload_excel_file_old(Request $request){
       $request->validate([
           'task_import' => 'required|file|mimes:xlsx,csv,xls'
       ]);

       $file = $request->file('task_import');

       // $destinationPath = storage_path('app/dataupload');
       // $destinationPath = env('APP_DATAUPLOAD');
       // $destinationPath = 'C:/xampp/htdocs/dhruv/storage/app/dataupload';
       $destinationPath = base_path('dataupload');


       $fileName = $file->getClientOriginalName();

       $file->move($destinationPath, $fileName);

       // Dispatch the job to process the Excel file
       $file_path = $destinationPath . '/' . $fileName;
        // ProcessExcelFileJob::dispatch($file_path);

      // Excel::import(new YourExcelImportClass, $file_path, null, \Maatwebsite\Excel\Excel::XLSX);

      $spreadsheet = IOFactory::load($file_path);
      $worksheet = $spreadsheet->getActiveSheet();

      // Iterate over the rows and process data
      foreach ($worksheet->getRowIterator() as $row) {

          $cellIterator = $row->getCellIterator();
          $cellIterator->setIterateOnlyExistingCells(false);

          $rowData = [];
          foreach ($cellIterator as $cell) {

              $rowData[] = $cell->getValue();
          }

            $unique_id = mt_rand(100000000000, 999999999999);
          FileHandlingModule_model::create([
            'unique_id' => $unique_id,
            'date_of_installation' => $rowData[0],
            'seal_name' => $rowData[1],
            'installed_at' => $rowData[2],
            'type' => $rowData[3],
            'use' => $rowData[4],
            'client' => $rowData[5],
              // Map other columns as needed
          ]);

        }

        return response()->json(['status'=>'200','message' => 'File uploaded successfully. Processing will begin shortly.','file_name'=>$fileName,'file_path'=>$file_path,'destinationPath'=>$destinationPath], 200);

    }

    public function getData()
      {
          $client_details = FileHandlingModule_model::query();
          return DataTables::of($client_details)->make(true);
      }

    public function download_zip(){
      $zip = new ZipArchive;
      $zipFileName = 'dataupload.zip';
      $zipFilePath = public_path($zipFileName); // Save the zip in the public directory

      if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
          // Path to your dataupload directory in the root folder
          $datauploadPath = base_path('dataupload');

          // Add files to the zip
          $files = scandir($datauploadPath);

          foreach ($files as $file) {
              if (is_file($datauploadPath . '/' . $file)) {
                  $zip->addFile($datauploadPath . '/' . $file, $file);
              }
          }

          $zip->close();

          // Return the zip file for download
          return response()->download($zipFilePath)->deleteFileAfterSend(true);
      }

      return response()->json(['error' => 'Failed to create zip file'], 500);
    }

    public function details($id){
        $client_details = FileHandlingModule_model::findOrFail($id);
        if (!$client_details) {
            abort(404, 'Details not found');
        }

        return view('details', ['client_details' => $client_details]);
    }
}
