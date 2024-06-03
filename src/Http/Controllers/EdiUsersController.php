<?php

namespace Bgies\EdiLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bgies\EdiLaravel\Models\EdiUser;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException;


class EdiUsersController extends Controller 
{
   public $navPage = "users";
   
   public function dashboard()
   {

      $ediUsers = EdiUser::paginate(25);

      return view('edilaravel::users.dashboard')
         ->with('ediUsers', $ediUsers)
         ->with('navPage', $this->navPage);
      
   }
   
   
   
   
   
   
   
   
   
   
}