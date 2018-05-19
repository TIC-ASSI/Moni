<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Adrress;
use App\Cpu;
use App\Disc;
use App\Mem;
use App\Net;
use App\Pid;
use App\Server;
use App\Time;
use App\User;

class MoniController extends Controller
{
    public function return_things(Request $request)
    {
      $user = User::where('token', $request->token -> first());
      if (!$user) {
        return ['error' => 'No funciona Paco'];
      }
      $server = $user->servers() ->where('name', $request->server -> firstOrCreate(
        ['name' => $request->server]
      ));
      $data = $request->data;
      $cpu = $data->cpu;
      $server->cpu()->where('time_id', null)->updateOrcreate([
        'cores' => $cpu->cores,
        'percent' => $cpu->percent,
        'frequency' => $cpu->frequency,
        'min_frequency' => $cpu->min_frequency,
        'max_frequency' => $cpu->max_frequency
      ])
    }
}
