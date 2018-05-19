<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
  /**
    *
    *
    *@var array
    */
    public $fillable = [
      //
    ];

    public function pid()
    {
      return $this->hasMany(Pid::class);
    }
    public function net()
    {
      return $this->hasMany(Net::class);
    }
    public function mem()
    {
      return $this->hasMany(Mem::class);
    }
    public function cpu()
    {
      return $this->hasMany(Cpu::class);
    }
    public function disc()
    {
      return $this->hasMany(Disc::class);
    }
}
