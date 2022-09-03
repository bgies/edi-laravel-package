<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiUsers;
use Bgies\EdiLaravel\Models\EdiTypes;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;


class EdiUsersController extends Controller 
{
   public $navPage = "users";
   
   public function dashboard()
   {

      $ediUsers = EdiUsers::paginate();

      return view('edilaravel::users.dashboard')
         ->with('ediUsers', $ediUsers)
         ->with('navPage', $this->navPage);
      
   }
   
   
   
   
   
   
   
   
   
   
}