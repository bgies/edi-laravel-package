<?php

namespace Bgies\EdiLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdiUser extends Model
{
  use HasFactory;
  
  protected $table = 'users';

  // Disable Laravel's mass assignment protection
  protected $guarded = [];
  
  protected static function newFactory()
  {
     return \Bgies\EdiLaravel\Database\Factories\EdiUsersFactory::new();
  }
}
