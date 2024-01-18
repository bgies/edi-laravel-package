<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiIncomingFiles;
use Bgies\EdiLaravel\Models\EdiOutgoingFiles;
use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;
use Bgies\EdiLaravel\Functions\ObjectFunctions; 
use Bgies\EdiLaravel\Functions\UpdateFunctions;


class EdiManageController extends Controller 
{
   public $navPage = "manage";
   
   public function index()
   {

      $ediIncomingFiles = EdiIncomingFiles::paginate();
      $ediOutgoingFiles = EdiOutgoingFiles::paginate();
//      \Log::info('ediManageController index ediFiles: ' . print_r($ediFiles, true));
      $ediTypes = EdiTypes::all();

      return view('edilaravel::manage.dashboard')
         ->with('ediIncomingFiles', $ediIncomingFiles)
         ->with('ediOutgoingFiles', $ediOutgoingFiles)
         ->with('ediTypes', $ediTypes)
         ->with('navPage', $this->navPage);
      
   }
   
   public function phpinfo()
   {
      return view('edilaravel::manage.phpinfo')
         ->with('navPage', $this->navPage);
//      \Log::info('ediManageController index ediFiles: ' . print_r($ediFiles, true));
//      phpinfo();
      
   }
   
   
   
   
   
   
   
   
}