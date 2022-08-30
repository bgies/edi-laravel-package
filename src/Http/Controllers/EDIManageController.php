<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiFiles;
use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 
use Bgies\EdiLaravel\Functions\UpdateFunctions;


class EdiManageController extends Controller 
{
   
   public function index()
   {
      $navPage = "manage";
      $ediFiles = EdiFiles::paginate();
      $ediTypes = EdiTypes::all();

      return view('edilaravel::manage.dashboard')
         ->with('ediFiles', $ediFiles)
         ->with('ediTypes', $ediTypes)
         ->with('navPage', $navPage);
      
//      return view('edilaravel::manage.dashboard', [
//            'ediTypes' => compact('ediTypes'), 
//            'navPage' => $navPage
//      ]);
   }
   
   
   
   
   
   
   
   
   
   
}