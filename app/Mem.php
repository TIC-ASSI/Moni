<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mem extends Model
{
  /**
    *
    *
    *@var array
    */
    public $fillable = [
      'total', 'avaiable', 'used', 'percent', 'free'
    ];
    public function server()
    {
      return $this->belongsTo(Server::class);
    }
    public function time()
    {
      return $this->belongsTo(Time::class);
    }
}
