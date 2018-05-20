<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Net extends Model
{
    /**
     * Stores the CPU table.
     *
     * @var string
     */
    public $table = 'net';

    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    public $fillable = [
        'total', 'stable', 'listen'
    ];

    /**
     * Returns the net server.
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

    /**
     * Return the server address.
     *
     * @return App\Address
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
