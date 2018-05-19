<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
    /**
     * Stores the CPU table.
     *
     * @var string
     */
    public $table = 'cpu';

    /**
     * Mass assignable attributes.
     *
     *@var array
    */
    public $fillable = [
        'cores', 'percent', 'frequency', 'min_frequency', 'max_frequency'
    ];

    /**
     * Returns the CPU server.
     *
     * @return void
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Returns the CPU time.
     *
     * @return void
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
