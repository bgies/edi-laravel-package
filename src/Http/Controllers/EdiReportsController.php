<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiType;


class EdiReportsController extends Controller
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public $navPage = 'reports';
   
   public function dashboard()
   {
      
      
      return view('edilaravel::reports.dashboard')
               ->with('ediReports', [])
               ->with('navPage', $this->navPage);
//      return view('view.dashboard');   
   }   
   
}