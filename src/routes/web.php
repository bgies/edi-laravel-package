<?php

use Illuminate\Support\Facades\Route;
use Bgies\EdiLaravel\Http\Controllers\EdiLaravelObjectController;

/*
Route::get('/posts', [EdiLaravelObjectController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [EdiLaravelObjectController::class, 'show'])->name('posts.show');
Route::post('/posts', [EdiLaravelObjectController::class, 'store'])->name('posts.store');
*/




Route::prefix('edilaravel')->group(function () {
   
   Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiLaravelController@dashboard');
   Route::get('/editype/index', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@index');
   Route::get('/editype/{ediTypeId}/edit', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@edit');
   Route::get('/field/{ediTypeId}/{fieldName}/edit', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@fieldEdit');
   Route::post('/updatefield', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@fieldUpdate');
   
   Route::get('/manage/index', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@index');
   
   
   Route::get('/admin', function () {
      
      // Matches The "/admin/users" URL
   });
   
   
   Route::prefix('reports')->group(function () {
      Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiReportsController@dashboard');
      Route::get('/index', '\Bgies\EdiLaravel\Http\Controllers\EdiReportsController@dashboard');
   });
      
   Route::prefix('users')->group(function () {
         Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiUsersController@dashboard');
         Route::get('/index', '\Bgies\EdiLaravel\Http\Controllers\EdiUsersController@dashboard');
   });
         
});

