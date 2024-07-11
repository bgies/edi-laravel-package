<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\ClassFunctions;
use Bgies\EdiLaravel\Functions\FileFunctions as FileFunctions;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 
use Bgies\EdiLaravel\Functions\UpdateFunctions;
use Bgies\EdiLaravel\Models\EdiFile;
use Bgies\EdiLaravel\Lib\RunEdiType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Bgies\EdiLaravel\Functions\CreateFromStub;
use function Opis\Closure\serialize;
use Illuminate\Support\Facades\Storage;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EdiReadOptions;
use Bgies\EdiLaravel\Functions\ReadEdiFileFunctions;
use Bgies\EdiLaravel\Lib\ReturnValues;

class EdiTypesController extends Controller
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public $navPage = 'editypes';
   
   
   public function index()
   {
      $ediTypes = EdiType::all();
      $sharedTypes = new SharedTypes();
      
      return view('edilaravel::ediTypes.editypes')
               ->with('ediTypes', $ediTypes)
               ->with('ediVersions', $sharedTypes->Versions)
               ->with('navPage', $this->navPage);
   }
   
/*   
   return view('edilaravel::manage.dashboard')
   ->with('ediFiles', $ediFiles)
   ->with('ediTypes', $ediTypes)
   ->with('navPage', $navPage);
*/   
   
   
   
   public function edit(Request $request, $ediTypeId)
   {
      \Log::info('EdiTypesController edit ediTypeId: ' . $ediTypeId);
      
      $ediType = EdiType::find($ediTypeId);
      if (!$ediType) {
         throw new NoSuchEdiTypeException('EDI Type ' . $ediTypeId . ' not found');
      }
      
      $beforeProcessObjectProperties = [];
      if ($ediType) {
         $beforeProcessObjectProperties = ObjectFunctions::getObjectProperties($ediType);
         $fields = $ediType->getAttributes();
      }
      \Log::info('EdiTypesController edit $fieldNames: ' . print_r($fields, true));
      
      return view('edilaravel::ediTypes.editype')
               ->with('ediType', $ediType) 
               ->with('fields', $fields)
               ->with('navPage', $this->navPage)
//               ->with('FileFunctions', FileFunctions)
               ->with('beforeProcessObjectProperties', $beforeProcessObjectProperties);

   }
   
   
   public function createObject(Request $request, $ediTypeId)
   {
      \Log::info('EdiTypesController createObject: ' . $ediTypeId);
      $ediType = EdiType::find($ediTypeId);
      if (!$ediType) {
         throw new NoSuchEdiTypeException('EDI Type ' . $ediTypeId . ' not found');
      }
      
      $input = $request->all();
      \Log::info('EdiTypesController createObject REQUEST: ' . print_r($input, true));
      request()->validate([
         'modal-fieldName' => 'required',
         'new-object-select'  => 'required',
      ]);
      
      
      
      $fields = $ediType->getAttributes();
      
      return view('edilaravel::ediTypes.editype')
      ->with('ediType', $ediType)
      ->with('fields', $fields)
      ->with('navPage', $this->navPage);
      //               ->with('FileFunctions', FileFunctions)
      //->with('beforeProcessObjectProperties', $beforeProcessObjectProperties);
   }
   
   
   
   public function fieldEdit(Request $request, $ediTypeId, $fieldName)
   {
      $ediType = EdiType::find($ediTypeId);
      
      $fieldObject = unserialize($ediType->$fieldName);
      $ObjectProperties = ObjectFunctions::getVars($fieldObject);

      if (!$fieldObject) {
         $fieldObject = '';
      }
      
      
      $objectTypes = [];
      if (!$fieldObject) {
         switch ($fieldName) {
            case 'edt_before_process_object': 
            
            break;
            case 'edt_edi_object':
               
               
            break;
            case 'edt_before_process_object':
               
            break;
            case 'edt_after_process_object':
               
            break;
            case 'edt_alert_object':
               $objectTypes[0] = 'email';
               $objectTypes[1] = 'SMS';
               
            break;
            case 'edt_transmission_object':
               
            break;               
            case 'edt_file_drop':
               
            break;
               
            default : 
               
            break;            
         }
         
      }
      
      return view('edilaravel::ediTypes.field')
               ->with('ediType', $ediType)
               ->with('fieldName', $fieldName)
               ->with('fieldObject', $fieldObject)
               ->with('navPage', $this->navPage)
               ->with('objectProperties', $ObjectProperties) 
               ->with('objectTypes', $objectTypes);
   }

   public function fieldUpdate(Request $request)
   {
      // Let's assume we need to be authenticated
      // to update an EDI type
//      if (! auth()->check()) {
//         abort (401, 'Only authenticated users can update EDI Types');
//      }
      
      \Log::info(' ');
      \Log::info(' ');  
      $input = $request->all();
      \Log::info('EdiTypesController fieldUpdate START REQUEST: ' . print_r($input, true));
      request()->validate([
         'ediTypeId' => 'required',
         'ediTypeFieldName'  => 'required',
      ]);
      
      // Assume the authenticated user is the post's author
//      $author = auth()->user();
      //\Log::info('EdiTypesController fieldUpdate Validated');
      $ediTypeId = $input['ediTypeId'];
      $fieldName = $input['ediTypeFieldName'];
      $errorList = [];
      
      $ediType = EdiType::find($ediTypeId);
      
      if (! $ediType) {
         \Log::info('EdiTypesController fieldUpdate EDI Type does not exist');
         abort (401, 'EDI Type (' . $ediTypeId . ') does not exist');
      }
      
      $fieldObject = unserialize($ediType->$fieldName);
      if (!$fieldObject) {
         abort (401, 'EDI Type (' . $ediTypeId . ' - ' . $ediTypeName . ') does not exist');
      }
      // we can remove the ediTypeId and ediTypeFieldName from the input array here
      unset( $input['ediTypeId'] );
      unset( $input['ediTypeFieldName'] );
      
      
      $objectTypes = [];
      $ObjectPropertyTypes = $fieldObject->getPropertyTypes();
      //\Log::info('EdiTypesController fieldUpdate ' . $fieldName . ' objectPropertyTypes: ' . print_r($ObjectPropertyTypes, true));
      $ObjectProperties = ObjectFunctions::getVars($fieldObject);
      \Log::info('EdiTypesController fieldUpdate ' . $fieldName . ' objectProperties: ' . print_r($ObjectProperties, true));

      $updatesMade = false;
      foreach ($input as $curName => $curValue) {
      //foreach ($ObjectProperties as $curName => $curValue) {
         
         $fieldType = gettype($curValue);   
         \Log::info('curName: ' . $curName . '  fieldType: ' . $fieldType . '  curValue: ' . print_r($curValue, true));
         if (is_null($curValue)) {
            $curValue = '';
         }
           
         $wasUpdated = UpdateFunctions::updateObjectProperty($fieldObject, $curName, $curValue, $ObjectPropertyTypes, $errorList);
           
         if ($wasUpdated) {
            $updatesMade = true;
         }           
         
      }
         
      if ($updatesMade) {
         $ediType->$fieldName = serialize($fieldObject);
         $ediType->save();
         \Log::info('EdiTypesController fieldUpdate SAVED: ');
      }
      
      return redirect('/edilaravel/editype/field/' . $ediTypeId . '/' . $fieldName . '/edit');
      //return redirect(route('posts.show', $post));
   }

   // GET only, shows the createFiles view
   public function createfiles()
   {
      \Log::info('EdiTypesController createfiles ');
      $ediTypes = EdiType::all();
      
      return view('edilaravel::ediTypes.chooseeditype')
      ->with('ediTypes', $ediTypes)
      ->with('edi_test_file', 'T')
      ->with('navPage', $this->navPage);
   }
   
   // POST only creates a new file and return the files view
   public function createNewFiles(Request $request) {
      LoggingFunctions::logThis('info', 5, '', '');
      
      $input = $request->all();
      LoggingFunctions::logThis('info', 3, 'EdiTypesController createNewFiles', 'input: ' . print_r($input, true));
      
      $validated = request()->validate([
         'modal-ediTypeId' => 'required',
         'edi_test_file'  => 'required'
      ]);
   
      \Log::info('EdiTypesController createNewFiles validated: ' . print_r($validated, true));
      \Log::info('EdiTypesController createNewFiles input: ' . print_r($input, true));
      
      $ediTypeId = $input['modal-ediTypeId'];
//      $ediType = EdiTypes::find($ediTypeId);
                  
      try {
         $runEdiType = new RunEdiType($ediTypeId);
      } catch (Exception $e) {
         LoggingFunctions::logThis('error', 10, 'EdiTypesController createNewFiles Exception creating RunEdiType: ', $e->message);
      }
           
      try {
         $retVals = $runEdiType->runTransactionSet($ediTypeId);
      } catch (Exception $e) {
         LoggingFunctions::logThis('error', 10, 'EdiTypesController createNewFiles Exception in runTransactionSet: ', $e->message);
      }
      
      LoggingFunctions::logThis('info', 5, 'EdiTypesController createNewFiles retVals: ', print_r($retVals, true));
            
      $ediFiles = EdiFile::orderBy('id', 'DESC')->paginate();

      $ediTypes = EdiType::simplePaginate(25);
      
      return view('edilaravel::manage.dashboard')
      ->with('ediFiles', $ediFiles)
      ->with('ediTypes', $ediTypes)
      ->with('navPage', $this->navPage);
      
   }
   
   public function chooseObject(Request $request) {
      \Log::info(' ');
      
      $input = $request->all();
      LoggingFunctions::logThis('info', 5, 'EdiTypesController chooseObjec input: ', print_r($input, true));
      
            
      return view('edilaravel::ediTypes.chooseobject')
      ->with('ediFiles', $ediFiles)
      ->with('ediTypes', $ediTypes)
      ->with('navPage', $this->navPage);
      
   }
   
   public function readFile(Request $request) {
      \Log::info(' ');
      
      $input = $request->all();
      LoggingFunctions::logThis('info', 3, 'EdiTypesController readFile', 'input: ' . print_r($input, true));
      
      // get a list of all files in the Storage/edifiles/To_Read directory
      // if the directory doesn't exist, create it
      $retVal = Storage::disk('edi')->makeDirectory('To_Read');
      $fileList = Storage::disk('edi')->files('To_Read');
      $fileArray = [];
      foreach ($fileList as $singleFile) {
         $fileName = substr($singleFile,  strrpos($singleFile, '/') + 1);
         $fileArray [] = $fileName;
      }
      
      return view('edilaravel::ediTypes.readfile')
      ->with('fileList', $fileArray)
      ->with('navPage', $this->navPage);   
   }
   
   
   public function readfileManuallyUpload(Request $request) {
      \Log::info(' ');
      
      $input = $request->all();
      $inputFile = $request->file('fileChosen')[0];
      $filePath = $inputFile->getRealPath();
      $fileContents = file_get_contents($filePath);
     
      $filePath = \Storage::disk('edi')->path("/To_Read/");
      $filename = tempnam($filePath, '');
      
      file_put_contents($filename, $fileContents);
      $justFileName = substr($filename, strrpos($filename, '/') + 1);
      
      $ret = $this->readfileManually($request, $justFileName);
      
      \Storage::disk('edi')->delete("/To_Read/" . $justFileName);
//      unlink($filename);
      
      return $ret;
   }
   
   
   public function readfileManually(Request $request, string $file) {
      \Log::info(' ');
      
      $input = $request->all();
      LoggingFunctions::logThis('info', 3, 'EdiTypesController readFile', 'input: ' . print_r($input, true));
      
      $EDIObj = new EdiReadOptions();
      $filePath = "/To_Read/" . $file;
      $sharedTypes = new SharedTypes();
      $retVals = new ReturnValues();
      /*
       * this procedure reads the ISA, GS, and ST segments to set delimiters, dates
       * and sender/receiver id's
       *
       * NOTE we are using a default EDIObj here because we can't find the
       * correct one until we know what's in the file, and we will
       * use the Sender/Receiver ids plus the transaction set.
       */
      $fileArray = EdiFileFunctions::ReadX12FileIntoStrings($filePath, $EDIObj, false, $sharedTypes);
      
      /*
       * We can't read a file without an Edi Type
       * If we find an EDI type, we can use an EDI Options object with the 
       * correct settings for this EDI Type. If not, we can only use the default 
       * EDI Options Object we created above.
       * NOTE - in an automated file read, we would already have aborted
       */
      $retValues = ReadEdiFileFunctions::getEdiTypeFromEdiObject($EDIObj);
      $ediType = $retValues->ediType;
      
      if (!$ediType) {
         $retValues->addToErrorList('An EDI Type was not found. ABORTING. If you are trying to test this file, create an EDI Type for it first, and set enabled to false ');
         
      } else {
         // we need to make an EDI Files entry for this file.                   
         $ediFile = new EdiFile();
         $ediFile->edf_edi_type_id = $ediType->id;
         $ediFile->edf_filename = $file;
         $ediFile->edf_transaction_control_number = $EDIObj->transactionSetControlNumber;
         $ediFile->interchange_sender_id = $EDIObj->interchangeSenderID;
         $ediFile->interchange_receiver_id = $EDIObj->interchangeReceiverID ;
         $ediFile->application_receiver_code = $EDIObj->applicationReceiverCode;
         $ediFile->application_sender_code = $EDIObj->applicationSenderCode;
         $ediFile->edf_cancelled = 1;
         $ediFile->edf_test_file = 1;
         $ediFile->save();
         
         $shortFileName =  EdiFileFunctions::getShortFileName($ediType->edt_name, $ediFile->id);
         $ediFile->edf_filename = $shortFileName;
         $ediFile->edf_original_filename = $file;
         
         $ediFile->save();
         // also save the file to it's final destination. 
         $fileNameOnDisk = ENV('EDI_TOP_DIRECTORY') . "/" . $shortFileName;
         
         \Storage::disk('edi')->put($fileNameOnDisk, implode($EDIObj->delimiters->SegmentTerminator, $fileArray));
         
            //now replace the temporary EDI Options Object with the real one. 
            $EDIObj = unserialize($ediType['edt_edi_object']);
         

            /*
             * Find the correct Transaction Set. If we don't have one, 
             * we can't read this file. 
             * Bgies\EdiLaravel\Lib\X12\TransactionSets\Read
             */
            $transactionSetClass = ClassFunctions::getTransactionSetClassName($EDIObj->ediStandard, $EDIObj->fileDirection, $EDIObj->transactionSetIdentifier);
            $classExists = ClassFunctions::doesClassExist($transactionSetClass);
         
            if ($classExists) {
               $transactionSet = new $transactionSetClass($ediType, $ediFile);
               $transactionSet->setFileContents(print_r($fileArray, true));
               $transactionSet->setFileArray($fileArray);
               $transactionSet->setEdiFile($ediFile);
               $transactionSet->setEdiType($ediType);
                        
               $retVals = $transactionSet->execute();
               
               $retData = $transactionSet->dataset;
               //Bgies\EdiLaravel\Lib\X12\TransactionSets\Read
            
            } else {
               $retValues->addToErrorList('Transaction Set ' . $transactionSetClass . ' does not exist');
         
               $transactionSet = new $transactionSetClass($ediType->id);
            }        
               
         
      }
      
      $data = json_encode($retData, JSON_PRETTY_PRINT, 12);
      
      return view('edilaravel::ediTypes.readfilemessages')
      ->with('fileArray', $fileArray)
      ->with('ediType', $ediType)
      ->with('data', $data)
      ->with('retValues', $retVals)
      ->with('ediObj', $EDIObj)
      ->with('navPage', $this->navPage);
   }
   

   public function createNewType(Request $request) {
      \Log::info(' ');
      
      $input = $request->all();
      LoggingFunctions::logThis('info', 3, 'EdiTypesController createNewType', 'input: ' . print_r($input, true));
      $messagesArray = [];
      
      // enter a few default values
      $input['edt_file_directory'] = '';
      // this came with trailing spaces, make sure they don't go in the DB. 
      $input['edt_name'] = trim($input['edt_name']);
      // remove the property that isn't in the database
      $ediVersion = $input['edi_version'];
      unset($input['edi_version']); 
      $transactionSetName = $input['edt_transaction_set_name'];
      
      $errorMessage = '';
      try {
         $ediType = EdiType::create($input);
      } catch (Exception $e) {
         LoggingFunctions::logThis('error', 3, 'EdiTypesController createNewType', 'Exception: ' . $e->getMessage());
         $errorMessage = 'Exception: ' . $e->getMessage();
      }
      
      /*
       * Now we need to figure out if we have both a Transaction Set Object 
       * available plus an Options Object. If either is not available, they 
       * must be created, inheriting from their ancestors (this is mainly 
       * for developers to be able to create new objects to work with)
       */
//      $topDirectory =  __DIR__ ;
      // top directory gives us this directory Http/Controllers
      // so go up 2 directories to get the package src directory, and add the /Stubs.
//      $srcDir = dirname($topDirectory, 2);
      
//      $stubsDir = $srcDir . '/Stubs';
      
      $createFromStub = new CreateFromStub($input['edt_edi_standard'], 
         $input['edt_transaction_set_name'], $input['edt_is_incoming']);
      
      $optionsObject = $createFromStub->CreateOptionObject($input, $ediType);
      if ($optionsObject) {
         $ediType->edt_edi_object = serialize($optionsObject);
         $ediType->save();
      }
            
      $retValues = $createFromStub->CreateTransactionSetObject($input, $ediType);
         
      
      $fields = $ediType->getAttributes();
      
      return view('edilaravel::ediTypes.editype')
      ->with('ediType', $ediType)
      ->with('error', $errorMessage)
      ->with('messages', $retValues->getMessages())
      ->with('fields', $fields)
      ->with('navPage', $this->navPage);
      //               ->with('FileFunctions', FileFunctions)
//      ->with('beforeProcessObjectProperties', $beforeProcessObjectProperties);
            
   }
   
   public function createFromFile(Request $request) {
      LoggingFunctions::logThis('info', 3, 'EdiTypesController createFromFile', '', true);
      
      // make a copy of the file, and put it where our normal file functions
      // can find it. 
      $input = $request->all();
      $inputFile = $request->file('fileChosen')[0];
      $filePath = $inputFile->getRealPath();
      $fileContents = file_get_contents($filePath);
      $originalFileName = $inputFile->getClientOriginalName();
      $newFilePath = 'tmp/' . $originalFileName;      
      \Storage::disk('edi')->put($newFilePath, $fileContents);
            
      LoggingFunctions::logThis('info', 3, 'EdiTypesController createFromFile', 'input: ' . print_r($input, true));
      $messagesArray = [];
      
      $EDIObj = new EdiReadOptions();
      $sharedTypes = new SharedTypes();
      $retVals = new ReturnValues();
      /*
       * this procedure reads the ISA, GS, and ST segments to set delimiters, dates
       * and sender/receiver id's
       *
       * NOTE we are using a default EDIObj here because we can't find the
       * correct one until we know what's in the file, and we will
       * use the Sender/Receiver ids plus the transaction set.
       */
      $fileArray = EdiFileFunctions::ReadX12FileIntoStrings($newFilePath, $EDIObj, false, $sharedTypes);
      
      $retVals = ReadEdiFileFunctions::getEdiTypeFromEdiObject($EDIObj);
      $ediType = $retVals->ediType;
      if ($ediType) {
         $retVals->addToMessages('EDI Type already exists for this file. ID: ' . $ediType->id);
      }
      
      if (!$retVals->getResult()) {
         
        $ediType = new EdiType();
        $ediType->edt_name = 'Read_' . $EDIObj->ediStandard . '_' . $EDIObj->transactionSetIdentifier . '_' . $EDIObj->interchangeSenderID;
        $ediType->edt_transaction_set_name = $EDIObj->transactionSetIdentifier;
        $ediType->edt_is_incoming = 1;
        $ediType->edt_control_number = 0;
        $ediType->edt_manual_create = 1;
        $ediType->edt_file_directory = '';
        $ediType->edt_edi_standard = $EDIObj->ediStandard;
        $ediType->interchange_sender_id = $EDIObj->interchangeSenderID;
        $ediType->interchange_receiver_id = $EDIObj->interchangeReceiverID;
        $ediType->application_sender_code = $EDIObj->applicationSenderCode;
        $ediType->application_receiver_code = $EDIObj->applicationReceiverCode;
         
        try {
           $ediType->save();
           LoggingFunctions::logThis('info', 6, 'EdiTypesController createFromFile', 'created EDI Type: ' . $ediType->id . '-' . $ediType->edt_name);
           
           $createFromStub = new CreateFromStub($ediType->edt_edi_standard,
              $ediType->edt_transaction_set_name, $ediType->edt_is_incoming);
        
           $optionsObject = $createFromStub->CreateOptionObject($input, $ediType);
           if ($optionsObject) {
              $ediType->edt_edi_object = serialize($optionsObject);
              $ediType->save();
           }
        
           $retValues = $createFromStub->CreateTransactionSetObject($input, $ediType);
        
        } catch (Exception $e) {
           $retValues->addToErrorList('Exception: ' . $e->getMessage());
        }
        
      }
      
      $fields = $ediType->getAttributes();
      // Delete the file we created before we leave
      \Storage::disk('edi')->delete($newFilePath);
      
      return view('edilaravel::ediTypes.editype')
      ->with('ediType', $ediType)
      ->with('error', $retVals->getErrorList())
      ->with('messages', $retVals->getMessages())
      ->with('fields', $fields)
      ->with('navPage', $this->navPage);
      
   }
      
}
