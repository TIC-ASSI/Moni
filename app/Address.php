<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
   /**
     *
     *
     *@var array
     */
     public $fillable = [
       'name', 'ip'
     ];
     
     public function user()
     {
       return $this->belongsTo(Net::class);
     }
}
