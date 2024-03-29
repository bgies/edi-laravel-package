<?php

namespace Bgies\EdiLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdiType extends Model
{
  use HasFactory;

  // Disable Laravel's mass assignment protection
  protected $guarded = [];
  
  protected static function newFactory()
  {
     return \Bgies\EdiLaravel\Database\Factories\EdiTypeFactory::new();
  }
  
  
  
}
