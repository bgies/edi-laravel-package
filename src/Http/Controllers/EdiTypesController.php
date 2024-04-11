<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\FileFunctions as FileFunctions;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 
use Bgies\EdiLaravel\Functions\UpdateFunctions;
use Bgies\EdiLaravel\Models\EdiFiles;
use Bgies\EdiLaravel\Lib\RunEdiType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Bgies\EdiLaravel\Functions\CreateFromStub;
use function Opis\Closure\serialize;

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
      \Log::info(' ');
      
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
         $retVal = $runEdiType->runTransactionSet($ediTypeId);
      } catch (Exception $e) {
         LoggingFunctions::logThis('error', 10, 'EdiTypesController createNewFiles Exception in runTransactionSet: ', $e->message);
      }
      
      LoggingFunctions::logThis('info', 5, 'EdiTypesController createNewFiles retVal: ', print_r($retVal, true));
            
      $ediFiles = EdiFiles::orderBy('id', 'DESC')->paginate();

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
      
      return view('edilaravel::ediTypes.readfile')
      ->with('navPage', $this->navPage);
      
   
   }

   public function createNewType(Request $request) {
      \Log::info(' ');
      
      $input = $request->all();
      LoggingFunctions::logThis('info', 3, 'EdiTypesController createNewType', 'input: ' . print_r($input, true));
      $messagesArray = [];
      
      // enter a few default values
      $input['edt_file_directory'] = '';
      // remove the file that isn't in the database
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
      $topDirectory =  __DIR__ ;
      // top directory gives us this directory Http/Controllers
      // so go up 2 directories to get the package src directory, and add the /Stubs.
      $srcDir = dirname($topDirectory, 2);
      
      $stubsDir = $srcDir . '/Stubs';
      
      $createFromStub = new CreateFromStub($input['edt_edi_standard'], 
         $input['edt_transaction_set_name'], $input['edt_is_incoming']);
      
      $optionsObject = $createFromStub->CreateOptionObject($input, $ediType);
      if ($optionsObject) {
         $ediType->edt_edi_object = serialize($optionsObject);
         $ediType->save();
      }
            
      $transmissionObject = $createFromStub->CreateTransactionSetObject($input['edt_edi_standard'], $input['edt_transaction_set_name']);
         
      
      $fields = $ediType->getAttributes();
      
      return view('edilaravel::ediTypes.editype')
      ->with('ediType', $ediType)
      ->with('error', $errorMessage)
      ->with('fields', $fields)
      ->with('navPage', $this->navPage);
      //               ->with('FileFunctions', FileFunctions)
//      ->with('beforeProcessObjectProperties', $beforeProcessObjectProperties);
            
   }
   
   
   
   
}
