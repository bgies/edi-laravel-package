<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiTypes;


class EdiLaravelController extends Controller
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   public function dashboard()
   {
      return view('edilaravel::dashboard');
//      return view('view.dashboard');   
   }   
   
}