<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disc extends Model
{
  /**
    *
    *
    *@var array
    */
    public $fillable = [
      'device', 'mount_point', 'file_system', 'total', 'used', 'free', 'percent'
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
