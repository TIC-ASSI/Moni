<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pid extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    public $fillable = [
        'number'
    ];

    /**
     * Return the PID server.
     *
     * @return App\Server
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Return the server time.
     *
     * @return App\Time
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
