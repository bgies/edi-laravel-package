<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Bgies\EdiLaravel\Models\EdiTypes;

class EdiTypesController extends Controller
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public function index()
   {
      $ediTypes = EdiTypes::all();
      
      return view('edilaravel::ediTypes.editypes', compact('ediTypes'));
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
