<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 


class EdiTypesController extends Controller
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public function index()
   {
      $ediTypes = EdiTypes::all();
      
      return view('edilaravel::ediTypes.editypes', compact('ediTypes'));
   }
   
   
   public function edit(Request $request, $ediTypeId)
   {
      \Log::info('EdiTypesController edit ediTypeId: ' . $ediTypeId);
      $ediType = EdiTypes::find($ediTypeId);
      if (!$ediType) {
         throw new NoSuchEdiTypeException('Division by zero.');
      }
      
      $beforeProcessObjectProperties = [];
      if ($ediType) {
         $beforeProcessObjectProperties = ObjectFunctions::getObjectProperties($ediType);
         $fields = $ediType->getAttributes();
      }
      \Log::info('EdiTypesController edit $fieldNames: ' . print_r($fields, true));
           
      
      return view('edilaravel::ediTypes.editype', ['ediType' => $ediType, 
         'fields' => $fields,
         'beforeProcessObjectProperties' => $beforeProcessObjectProperties
      ]);
   }
   
   
   public function show()
   {
      
      
   }
   
   
   public function fieldEdit(Request $request, $ediTypeId, $fieldName)
   {
      $ediType = EdiTypes::find($ediTypeId);
      
      $fieldObject = unserialize($ediType->$fieldName);
      $ObjectProperties = ObjectFunctions::getVars($fieldObject);
      
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
      
      return view('edilaravel::ediTypes.field', ['ediType' => $ediType,
         'fieldName' => $fieldName,
         'fieldObject' => $fieldObject,
         'objectProperties' => $ObjectProperties, 
         'objectTypes' => $objectTypes
      ]);
      
      
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
      \Log::info('EdiTypesController fieldUpdate START REQUEST: ' . print_r($request->all(), true));
      request()->validate([
         'ediTypeId' => 'required',
         'ediTypeFieldName'  => 'required',
      ]);
      
      // Assume the authenticated user is the post's author
//      $author = auth()->user();
      //\Log::info('EdiTypesController fieldUpdate Validated');
      $input = $request->all();
      $ediTypeId = $input['ediTypeId'];
      $fieldName = $input['ediTypeFieldName'];
            
      $ediType = EdiTypes::find($ediTypeId);
      
      
      if (! $ediType) {
         \Log::info('EdiTypesController fieldUpdate EDI Type does not exist');
         abort (401, 'EDI Type (' . $ediTypeId . ' does not exist');
      }
      
      $fieldObject = unserialize($ediType->$fieldName);
      if (!$fieldObject) {
         abort (401, 'EDI Type (' . $ediTypeId . ' - ' . $ediTypeName . ' does not exist');
      }
      
      $objectTypes = [];
      $ObjectPropertyTypes = $fieldObject->getPropertyTypes();
      //\Log::info('EdiTypesController fieldUpdate ' . $fieldName . ' objectPropertyTypes: ' . print_r($ObjectPropertyTypes, true));
      $ObjectProperties = ObjectFunctions::getVars($fieldObject);
      \Log::info('EdiTypesController fieldUpdate ' . $fieldName . ' objectProperties: ' . print_r($ObjectProperties, true));
      
      foreach ($ObjectProperties as $curName => $curValue) {
         
         $fieldType = gettype($curValue);   
         \Log::info('EdiTypesController fieldUpdate ' . $fieldName . ' objectProperties: ' . $curName . '  fieldType: ' . $fieldType . '  ' . print_r($curValue, true));
         
         
         switch ($fieldType) {
            case('object'):
               \Log::info('EdiTypesController OBJECT curName: ' . $curName . '  fieldType: ' . $fieldType . '  ' . print_r($curValue, true));
               //\Log::info('EdiTypesController OBJECT innerObject: ' . print_r($innerObject, true));
               
               $innerObjectProperties = ObjectFunctions::getVars($curValue);
               $innerObjectPropertyTypes = $curValue->getPropertyTypes();
               \Log::info('EdiTypesController OBJECT innerObjectPropertyTypes: ' . print_r($innerObjectPropertyTypes, true));
               
               foreach ($innerObjectProperties as $curInnerProperty) {
                  \Log::info('EdiTypesController curInnerProperty: ' . print_r($curInnerProperty, true));
                  //$propertyInfo = $innerObjectPropertyTypes[];
                  //UpdateFunctions::updateObjectProperty($innerObject, $curInnerProperty, $requestProperyName, $propertyInfo)
                  
                  
               }
            break;
            
            case('string'):

            break;
            
            default:

            
         }
            
         
      }
      
      
      
      
/*      
      $post = $author->posts()->create([
         'title'     => request('title'),
         'body'      => request('body'),
      ]);
*/      
      return redirect('/edilaravel/field/' . $ediTypeId . '/' . $fieldName . '/edit');
      //return redirect(route('posts.show', $post));
   }
   
    
}
