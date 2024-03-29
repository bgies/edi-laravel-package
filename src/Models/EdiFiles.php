<?php

namespace Bgies\EdiLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Bgies\EdiLaravel\Models\EdiType;

class EdiFiles extends Model
{
   use HasFactory;
   protected $table = 'edi_files';
   
   // Disable Laravel's mass assignment protection
   protected $guarded = [];
   
   protected static function newFactory()
   {
      return \Bgies\EdiLaravel\Database\Factories\EdiFileFactory::new();
   }
   
   
   public function ediType(): HasOne
   {
      return $this->hasOne(EdiType::class, 'id', 'edf_edi_type_id');
   }
   
   /**
    * Scope a query to only include prod files.
    */
   public function scopeProd(Builder $query): void
   {
      $query->where('edf_test_file', 0);
   }

   /**
    * Scope a query to only include active files.
    */
   public function scopeActive(Builder $query): void
   {
      $query->where('edf_cancelled', 0);
   }
   
}
