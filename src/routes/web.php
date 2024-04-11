<?php

use Illuminate\Support\Facades\Route;
use Bgies\EdiLaravel\Http\Controllers\EdiLaravelObjectController;

/*
Route::get('/posts', [EdiLaravelObjectController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [EdiLaravelObjectController::class, 'show'])->name('posts.show');
Route::post('/posts', [EdiLaravelObjectController::class, 'store'])->name('posts.store');
*/




Route::prefix('edilaravel')->group(function () {
   
   Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@index');
   
   Route::get('/phpinfo', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@phpinfo');

   Route::prefix('dashboard')->group(function () {
      Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiDashboardController@dashboard');
      Route::get('/dashboard', '\Bgies\EdiLaravel\Http\Controllers\EdiDashboardController@dashboard');
      
      
   });
   
   Route::prefix('manage')->group(function () {
      Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@index');
      Route::get('/index', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@index');
      Route::get('/files', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@files');
      
      Route::get('/file/view/{ediTypeId}', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@viewFile');
      Route::get('/readfile/{ediFileId}', '\Bgies\EdiLaravel\Http\Controllers\EdiManageController@readfile');
   });
   
   Route::prefix('editype')->group(function () {
      Route::get('/', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@index');
      Route::get('/index', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@index');
      
      Route::get('/{ediTypeId}/edit', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@edit');
      Route::post('/{ediTypeId}/edit', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@createObject');
      
      Route::get('/field/{ediTypeId}/{fieldName}/edit', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@fieldEdit');
      Route::post('/updatefield', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@fieldUpdate');
      Route::get('/createfiles', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@createfiles');
      Route::post('/createfiles', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@createNewFiles');
      
      Route::get('/readfile', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@readfile');
      
      Route::get('/chooseobject', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@chooseObject');
      Route::post('/createnewtype', '\Bgies\EdiLaravel\Http\Controllers\EdiTypesController@createNewType');
      
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

