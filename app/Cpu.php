<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
  /**
    *
    *
    *@var array
    */
    public $fillable = [
      'cores', 'percent', 'frequency', 'min_frequency', 'max_frequency'
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
