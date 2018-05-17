<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    /**
      * Erik deixa de fliparte
      *
      *@var array
      */
      public $fillable = [
        'server','data'
      ];

      public function user()
      {
        return $this->belongsTo(User::class);
      }
}
