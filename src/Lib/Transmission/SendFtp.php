<?php

namespace Bgies\EdiLaravel\Lib\Transmission;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Bgies\EdiLaravel\Models\Ediincoming;
use Bgies\EdiLaravel\Functions\FileFunctions;
use Carbon\Carbon;
use Bgies\EdiLaravel\Models\Edifile;



class SendFtp 
{
     
   
   public function __construct()
   {
      //parent::__construct();
      
      
     // str_replace('\\', '/', $filepath);.
      
   }
      
   public function execute() : string
   {
      \Log::info('Bgies\EdiLaravel\X12JohnsonFTP  execute START');   
      
      // Send the files that need to be sent
      //      $JohnsonDirectories = Storage::disk('ediJohnsonFTP')->directories();
//      $ediFiles = new EdiFile();
//      $ediFiles->select('CALL proc_Johnson_FTP');
      
      // collect puts the result into 
      $filesToSend = collect( \DB::select('CALL proc_Johnson_FTP'));
      if (count($filesToSend) > 0) {
         $ftpDir = 'docs_out';
         foreach ($filesToSend as $fileToSend) {
            $newCarbon = Carbon::now();
            $fileName = FileFunctions::getClientFileName('faks_yyyymmdd_hhnnss.edi', 'faks', $newCarbon);
                        
            $fileContents = Storage::disk('edi')->get(env('EDI_TOP_DIRECTORY') . "/" .  $fileToSend->edf_filename);
            
            Storage::disk('ediJohnsonFTP')->put($ftpDir . "/" .  $fileName, $fileContents);
            
            $ediFile = EdiFile::find($fileToSend->id);
            $ediFile->edf_client_filename = $fileName;
            $ediFile->edf_state = 2;
            $ediFile->edf_transmission_date = Carbon::now();
            
            $ediFile->save();
         }         
         
      }
      
      
      
      // get the 997 Reply files
      $replyFiles = Storage::disk('ediJohnsonFTP')->allFiles('/in_docs');
      if ($replyFiles) {
         $DirectoryDateString = FileFunctions::getDirectoryDateString();
         $storageDir = env('EDI_TOP_DIRECTORY') . "/" . "Johnson210Replies/" . $DirectoryDateString;
         $retVal = Storage::disk('edi')->makeDirectory($storageDir);
         
         foreach ($replyFiles as $replyFile) {
            $fileContents = Storage::disk('ediJohnsonFTP')->get($replyFile);
            
            if (strpos($replyFile, "wa_faks/") == 0) {
               $replyFileName = substr($replyFile, 8);
            }
            
            $storedSuccessfully = Storage::disk('edi')->put($storageDir . "/" .  $replyFileName, $fileContents);
            if ($storedSuccessfully) {
               $incomingModel = new Ediincoming();
               $incomingModel->einResponseNumber = 0;
               $incomingModel->einFileName = 'Johnson210Replies' . "/" . $DirectoryDateString . "/" . $replyFileName;
               $incomingModel->einDateTime = now();
               $incomingModel->einReadAttempts = 0;
            
               $incomingModel->save();

               Storage::disk('ediJohnsonFTP')->delete($replyFile);
            }
         }
      }
      
      
      return true;
   }
   
   
   
   
   
   
   
}