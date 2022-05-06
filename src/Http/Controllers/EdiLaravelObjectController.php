<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Bgies\EdiLaravel\Http\Controllers\Controller;

class EdiLaravelObjectController extends Controller
{
       public function index()
       {
          \Log::info('EdiLaravelObjectController index');
       }
       
       public function show()
       {
          \Log::info('EdiLaravelObjectController show');
       }
       
       public function store()
       {
          \Log::info('EdiLaravelObjectController store');
          // Let's assume we need to be authenticated
          // to create a new post
          if (! auth()->check()) {
             abort (403, 'Only authenticated users can create new posts.');
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
