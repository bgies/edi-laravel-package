<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiFiles;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 
use Bgies\EdiLaravel\Functions\UpdateFunctions;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Bgies\EdiLaravel\Lib\ReadEdiFile;


class EdiManageController extends Controller 
{
   public $navPage = "manage";
   
   public function index()
   {
      LoggingFunctions::logThis('info', 3, 'EdiManageController index', '');
      $ediFiles = EdiFiles::orderBy('id', 'DESC')->paginate();
      $ediFiles = \DB::table('edi_files')
      ->select('edi_files.id', 'edi_files.edf_cancelled', 'edi_files.edf_datetime', 
         'edi_files.edf_acknowledged', 'edi_files.edf_transaction_control_number', 
         'edi_files.edf_filename', 'edi_files.interchange_sender_id', 'edi_files.interchange_receiver_id')
      ->join('edi_types', 'edi_types.id', '=', 'edi_files.edf_edi_type_id')
//      ->join('users', 'articles.user_id', '=', 'user.id')
      
      ->paginate();
      
      
      
      \Log::info('ediManageController index ediFiles: ' . print_r($ediFiles, true));
      $ediTypes = EdiType::orderBy('id', 'ASC')->paginate();;

      return view('edilaravel::manage.dashboard')
         ->with('ediFiles', $ediFiles)
         ->with('ediTypes', $ediTypes)
         ->with('navPage', $this->navPage);
      
   }
   
   
   public function files()
   {
      LoggingFunctions::logThis('info', 3, 'EdiManageController files', '');
      
//      $ediFiles = EdiFiles::orderBy('id', 'DESC')->paginate();
      $ediFiles = \DB::table('edi_files')
         ->select('edi_files.id', 'edi_files.edf_cancelled', 'edi_files.edf_datetime',
            'edi_files.edf_acknowledged', 'edi_files.edf_transaction_control_number',
            'edi_files.edf_filename', 'edi_files.edf_records_parsed', 
            'edi_files.edf_test_file', 'edi_types.edt_name')
         ->join('edi_types', 'edi_types.id', '=', 'edi_files.edf_edi_type_id')
         //      ->join('users', 'articles.user_id', '=', 'user.id')
         ->orderBy('id', 'DESC')
         ->paginate();
      
      $ediTypes = EdiType::all();
      
      return view('edilaravel::manage.files')
      ->with('ediFiles', $ediFiles)
      ->with('ediTypes', $ediTypes)
      ->with('navPage', $this->navPage);
      
   }
   
   public function viewFile(Request $request, int $ediFileId)
   {
      LoggingFunctions::logThis('info', 3, 'EdiManageController viewFile', '');
      LoggingFunctions::logThis('info', 3, 'EdiManageController viewFile', 'ediFileId: ' . $ediFileId);
      
      //$ediFile = EdiFiles::with('ediType')->find($ediFileId);
      $ediFile = \DB::table('edi_files')
      ->select('edi_files.id', 'edi_files.edf_cancelled', 'edi_files.edf_datetime',
         'edi_files.edf_acknowledged', 'edi_files.edf_transaction_control_number',
         'edi_files.edf_filename', 'edi_files.edf_records_parsed',
         'edi_files.edf_test_file', 'edi_types.edt_name', 'edi_types.edt_edi_standard',
         'edi_types.edt_edi_object')
         ->join('edi_types', 'edi_types.id', '=', 'edi_files.edf_edi_type_id')
      ->where('edi_files.id', '=', $ediFileId)
      ->first();

      $fileArray = '';
      if ($ediFile->edt_edi_standard == 'X12') {
         
         $fileContents = EdiFileFunctions::getFileContentsFromShortName('edi', $ediFile->edf_filename);
         
         $sharedTypes = new SharedTypes();
         $filePath = env('EDI_TOP_DIRECTORY') . "/" . $ediFile->edf_filename;
         $ediOptions = unserialize($ediFile->edt_edi_object);
         
         $fileArray = EdiFileFunctions::ReadX12FileIntoStrings($filePath,
                  $ediOptions, false, $sharedTypes);
         
         //$fileContents = EdiFileFunctions::ReadX12FileIntoStrings($ediFile->edf_filename, $EDIObj, $InProgram) : array
         
      } else {
         
      }
      
      
      return view('edilaravel::manage.viewfile')
      ->with('fileArray', $fileArray)
      ->with('ediFile', $ediFile)
      ->with('fileContents', $fileContents)
      ->with('navPage', $this->navPage);
      
   }
   
   
   /*
    * when reading a file, it should already have an entry in the edi_files 
    * table, but until it's read, we won't know which trading partner 
    * it belongs to, so we need to read the  
    * 
    */
   public function readfile(Request $request, int $ediFileId)
   {
      LoggingFunctions::logThis('info', 3, 'EdiManageController readfile', 'ediFileId: ' . $ediFileId);
      
      try {
         $readEdiFile = new ReadEdiFile($ediFileId);
      } catch (Exception $e) {
         
      }
      
      
      $retValues = $readEdiFile->readFile();
      $messages = '';
      if ($retValues->getErrorCount() > 0) {
         $messages .= 'Errors: ' . print_r($retValues->getErrorList(), true) . '  ';
      }
      if ($retValues->getMessageCount() > 0) {
         $messages .= 'Messages: ' . print_r($retValues->getMessages(), true) . '  ';
      }
      
      
      
      return view('edilaravel::manage.viewfile')
      ->with('fileArray', $fileArray)
      ->with('ediFile', $ediFile)
      ->with('fileContents', $fileContents)
      ->with('message', $messages)
      ->with('navPage', $this->navPage);
   }
      
   
   public function outgoing()
   {
      $ediFiles = EdiFiles::orderBy('id', 'DESC')->paginate();
      $ediTypes = EdiType::all();
      
      return view('edilaravel::manage.outgoing')
      ->with('ediFiles', $ediFiles)
      ->with('ediTypes', $ediTypes)
      ->with('navPage', $this->navPage);   
      
   }
   
   
   public function phpinfo() 
   {
      
      return view('edilaravel::manage.phpinfo')
               ->with('navPage', $this->navPage);   
   }
   
   
   
}