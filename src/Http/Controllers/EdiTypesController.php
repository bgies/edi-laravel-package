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
   
   public function showObject() 
   {
      
      
   }
   
   
   
   public function edit(Request $request, $ediTypeId)
   {
      \Log::info('EdiTypesController edi ediTypeId: ' . $ediTypeId);
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
   
   public function store()
   {
      // Let's assume we need to be authenticated
      // to create a new post
      if (! auth()->check()) {
         abort (403, 'Only authenticated users can update EDI Types');
      }
      
      request()->validate([
         'title' => 'required',
         'body'  => 'required',
      ]);
      
      // Assume the authenticated user is the post's author
      $author = auth()->user();
      
      $post = $author->posts()->create([
         'title'     => request('title'),
         'body'      => request('body'),
      ]);
      
      return redirect(route('posts.show', $post));
   }
   
   
    
    
}
