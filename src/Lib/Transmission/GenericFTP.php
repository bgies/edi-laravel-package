<?php

namespace Bgies\EdiLaravel\Lib\Transmission;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Bgies\EdiLaravel\Models\Ediincoming;
use Bgies\EdiLaravel\Functions\FileFunctions;
use Carbon\Carbon;
use Bgies\EdiLaravel\Models\EdiFiles;



class GenericFTP 
{
   
   
   
   
   public function __construct()
   {
      //parent::__construct();
      
      
     // str_replace('\\', '/', $filepath);.
      
   }
      
   public function execute() : string
   {
      \Log::info('Bgies\EdiLaravel\X12WilliamsFTP  execute START');   
      
      // Send the files that need to be sent
//      $williamsDirectories = Storage::disk('ediWilliamsFTP')->directories();
//      $ediFiles = new Edifiles();
//      $ediFiles->select('CALL proc_williams_FTP');
      
      // collect puts the result into 
      $filesToSend = collect( \DB::select('CALL proc_williams_FTP'));
      if (count($filesToSend) > 0) {
         $ftpDir = 'faks_wa';
         foreach ($filesToSend as $fileToSend) {
            $newCarbon = Carbon::now();
            $fileName = FileFunctions::getClientFileName('faks_yyyymmdd_hhnnss.edi', 'faks', $newCarbon);
                        
            $fileContents = Storage::disk('edi')->get(env('EDI_TOP_DIRECTORY') . "/" .  $fileToSend->edf_filename);
            
            Storage::disk('ediWilliamsFTP')->put($ftpDir . "/" .  $fileName, $fileContents);
            
            $ediFile = EdiFiles::find($fileToSend->id);
            $ediFile->edf_client_filename = $fileName;
            $ediFile->edf_state = 2;
            $ediFile->edf_transmission_date = Carbon::now();
            
            $ediFile->save();
         }         
         
      }
      
      
      
      // get the 997 Reply files
      $replyFiles = Storage::disk('ediWilliamsFTP')->allFiles('/wa_faks');
      if ($replyFiles) {
         $DirectoryDateString = FileFunctions::getDirectoryDateString();
         $storageDir = env('EDI_TOP_DIRECTORY') . "/" . "Williams210Replies/" . $DirectoryDateString;
         $retVal = Storage::disk('edi')->makeDirectory($storageDir);
         
         foreach ($replyFiles as $replyFile) {
            $fileContents = Storage::disk('ediWilliamsFTP')->get($replyFile);
            
            if (strpos($replyFile, "wa_faks/") == 0) {
               $replyFileName = substr($replyFile, 8);
            }
            
            $storedSuccessfully = Storage::disk('edi')->put($storageDir . "/" .  $replyFileName, $fileContents);
            if ($storedSuccessfully) {
               $incomingModel = new Ediincoming();
               $incomingModel->einResponseNumber = 0;
               $incomingModel->einFileName = 'Williams210Replies' . "/" . $DirectoryDateString . "/" . $replyFileName;
               $incomingModel->einDateTime = now();
               $incomingModel->einReadAttempts = 0;
            
               $incomingModel->save();

               Storage::disk('ediWilliamsFTP')->delete($replyFile);
            }
         }
      }
      
      
      return true;
   }
   
   
   
   
   
   
   
}