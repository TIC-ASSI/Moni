<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MoniController extends Controller
{
    /**
     * Stores the server information.
     *
     * @param Request $request
     * @return array
     */
    public function data(Request $request)
    {
        $user = User::where('token', $request->token)->firstOrFail();

        $server = $user->servers()->where('name', $request->server)->firstOrCreate([
            'name' => $request->server
        ]);

        $data = $request->data;

        // CPU
        $server->cpu()->where('time_id', null)->updateOrcreate([
            'cores'         => $data->cpu->cores,
            'percent'       => $data->cpu->percent,
            'frequency'     => $data->cpu->frequency,
            'min_frequency' => $data->cpu->min_frequency,
            'max_frequency' => $data->cpu->max_frequency
        ]);

        // Address
        $server->address()->where('time_id', null)->updateOrcreate([
            'name'  => $data->address->name,
            'ip'    => $data->address->ip
        ]);

        // Disc
        $server->disc()->where('time_id', null)->updateOrcreate([
            'devices'       => $data->disc->device,
            'mount_point'   => $data->disc->mount_point,
            'file_system'   => $data->disc->file_system,
            'total'         => $data->disc->total,
            'used'          => $data->disc->used,
            'free'          => $data->disc->free,
            'percent'       => $data->disc->percent
        ]);

        // Mem
        $server->mem()->where('time_id', null)->updateOrcreate([
            'total'     => $data->mem->total,
            'available' => $data->mem->available,
            'used'      => $data->mem->used,
            'percent'   => $data->mem->percent,
            'free'      => $data->mem->free
        ]);

        // Net
        $server->net()->where('time_id', null)->updateOrcreate([
            'total' => $data->net->total,
            'stable' => $data->net->stable,
            'listen' => $data->net->listen
        ]);

        // Pid
        $server->pid()->where('time_id', null)->updateOrcreate([
            'number' => $data->net->number
        ]);

        return [
            'response' => 'ok'
        ];
    }
}
