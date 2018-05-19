<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Net extends Model
{
  /**
    *
    *
    *@var array
    */
    public $fillable = [
      'total', 'stable', 'listen'
    ];
    public function server()
    {
      return $this->belongsTo(Server::class);
    }
    public function time()
    {
      return $this->belongsTo(Time::class);
    }
    public function address()
    {
      return $this->hasMany(Address::class);
    }
}
