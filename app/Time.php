<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    public $fillable = [
        //
    ];

    /**
     * Return the time PID.
     *
     * @return App\Pid
     */
    public function pid()
    {
        return $this->hasMany(Pid::class);
    }

    /**
     * Return the time net.
     *
     * @return App\Net
     */
    public function net()
    {
        return $this->hasMany(Net::class);
    }

    /**
     * Return the time Memory.
     *
     * @return App\Mem
     */
    public function mem()
    {
        return $this->hasMany(Mem::class);
    }

    /**
     * Return the time CPU.
     *
     * @return App\Cpu
     */
    public function cpu()
    {
        return $this->hasMany(Cpu::class);
    }

    /**
     * Returns the time disk.
     *
     * @return App\Disk
     */
    public function disk()
    {
        return $this->hasMany(Disk::class);
    }
}
