<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mem extends Model
{
    /**
     * Stores the CPU table.
     *
     * @var string
     */
    public $table = 'mem';

    /**
     * Mass assignable attributes
     *
     *@var array
    */
    public $fillable = [
        'total', 'available', 'used', 'percent', 'free'
    ];

    /**
     * Returns the memory server.
     *
     * @return void
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Returns the server time.
     *
     * @return void
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
