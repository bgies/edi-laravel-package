<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\FileFunctions as FileFunctions;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 
use Bgies\EdiLaravel\Functions\UpdateFunctions;
use Bgies\EdiLaravel\Models\EdiIncomingFiles;
use Bgies\EdiLaravel\Models\EdiOutgoingFiles;


class EdiTypesController extends Controller
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public $navPage = 'editypes';
   
   
   public function index()
   {
      $ediTypes = EdiTypes::all();
      
      return view('edilaravel::ediTypes.editypes')
               ->with('ediTypes', $ediTypes)
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
      $ediType = EdiTypes::find($ediTypeId);
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
   
   
   public function show()
   {
      
      
   }
   
   
   public function fieldEdit(Request $request, $ediTypeId, $fieldName)
   {
      $ediType = EdiTypes::find($ediTypeId);
      
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
      
      $ediType = EdiTypes::find($ediTypeId);
      
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
      $ediTypes = EdiTypes::all();
      
      return view('edilaravel::ediTypes.chooseeditype')
      ->with('ediTypes', $ediTypes)
      ->with('edi_test_file', 'T')
      ->with('navPage', $this->navPage);
   }
   
   // POST only creates a new file and return the files view
   public function createNewFiles(Request $request) {
      \Log::info(' ');
      
      $input = $request->all();
      \Log::info('EdiTypesController createNewFiles input: ' . print_r($input, true));
      
      $validated = request()->validate([
         'modal-ediTypeId' => 'required',
         'edi_test_file'  => 'required'
      ]);
   
      \Log::info('EdiTypesController createNewFiles validated: ' . print_r($validated, true));
      \Log::info('EdiTypesController createNewFiles input: ' . print_r($input, true));
      
      $ediTypeId = $input['modal-ediTypeId'];
      $ediType = EdiTypes::find($ediTypeId);
      if (!$ediType) {
         throw new NoSuchEdiTypeException('EDI Type ' . $ediTypeId . ' not found');
      }
   
      $errorList = [];
      $transactionSetName = "Bgies\EdiLaravel\Lib\\";

      switch ($ediType->edt_edi_standard) {

         case ($ediType->edt_edi_standard == 'X12') : 
            if ($ediType->edt_is_incoming == 1) {
               $transactionSetName .= 'X12\TransactionSets\Read\X12Read';
            } else {
               $transactionSetName .= 'X12\TransactionSets\Send\X12Send';
            }
            $transactionSetName .= $ediType->edt_transaction_set_name;
            break;
         case ($ediType->edt_edi_standard == 'EDIFACT') : 
            if ($ediType->edt_is_incoming == 1) {
               $transactionSetsName .= 'Edifact\TransactionSets\Read\EdifactRead' . $ediType->edt_transaction_set_name;
            } else {
               $transactionSetName .= 'Edifact\TransactionSets\Send\EdifactSend' . $ediType->edt_transaction_set_name;
            }
            $transactionSetName .= $ediType->edt_transaction_set_name;
            break;   

         default: {
            break;
         }
      }
      \Log::info('EdiTypesController createNewFiles transactionSetName: ' . $transactionSetName);

      // NOTE - this method relies on having the class name to call plus the edi Type Id
      $ObjectToRun = new $transactionSetName($ediTypeId);
      \Log::info('EdiTypesController createNewFiles before $retVal = $edi->execute()');
      
      
      $retVal = $ObjectToRun->execute();
      \Log::info('EdiTypesController createNewFiles $edi->execute returned: ' . $retVal);
      
      
      $ediIncomingFiles = EdiIncomingFiles::paginate();
      $ediOutgoingFiles = EdiOutgoingFiles::paginate();
      //\Log::info('ediManageController index ediFiles: ' . print_r($ediFiles, true));
      $ediTypes = EdiTypes::simplePaginate(25);
      
      return view('edilaravel::manage.dashboard')
      ->with('ediIncomingFiles', $ediIncomingFiles)
      ->with('ediOutgoingFiles', $ediOutgoingFiles)
      ->with('ediTypes', $ediTypes)
      ->with('navPage', 'manage');


      
   }

}
