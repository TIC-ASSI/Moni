<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pid extends Model
{
  /**
    *
    *
    *@var array
    */
    public $fillable = [
      'number'
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
