<?php

namespace Bgies\EdiLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdiFiles extends Model
{
   use HasFactory;
   protected $table = 'edi_files';
   
   // Disable Laravel's mass assignment protection
   protected $guarded = [];
   
   protected static function newFactory()
   {
      return \Bgies\EdiLaravel\Database\Factories\EdiTypesFactory::new();
   }
}
