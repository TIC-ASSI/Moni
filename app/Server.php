<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    public $fillable = [
        'name'
    ];

    /**
     * Returns the server user.
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the server PID.
     *
     * @return App\Pid
     */
    public function pid()
    {
        return $this->hasMany(Pid::class);
    }

    /**
     * Returns the server NET.
     *
     * @return App\Net
     */
    public function net()
    {
        return $this->hasMany(Net::class);
    }

    /**
     * Returns the server memory.
     *
     * @return App\Mem
     */
    public function mem()
    {
        return $this->hasMany(Mem::class);
    }

    /**
     * Returns the server CPU.
     *
     * @return App\Cpu
     */
    public function cpu()
    {
        return $this->hasMany(Cpu::class);
    }

    /**
     * Returns the server DISK.
     *
     * @return App\Disk
     */
    public function disk()
    {
        return $this->hasMany(Disk::class);
    }
}
