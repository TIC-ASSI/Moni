<?php

namespace App\Http\Controllers;

use Hash;
use Pusher;
use App\User;
use App\Server;
use Illuminate\Http\Request;

class MoniController extends Controller
{
    /**
     * Returns the application SPA.
     *
     * @return Response
     */
    public function index()
    {
        return view('app');
    }

    /**
     * Register a user to the application.
     *
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $attributes['api_token'] = str_random(60);

        $user = User::create($attributes);

        return [
            'message' => 'Welcome back, ' . $user->name,
            'user' => $user
        ];
    }

    /**
     * Login the user to the application
     *
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $attributes['email'])->first();

        if (!$user || !Hash::check($attributes['password'], $user->password)) {
            return response([
                'message' => 'Wrong credentials',
                'errors' => [
                    'email' => [''],
                    'password' => [''],
                ]
            ], 403);
        }

        return [
            'message' => 'Welcome back, ' . $user->name,
            'user' => $user
        ];
    }

    /**
     * Returns the user servers.
     *
     * @param Request $request
     * @return Collection
     */
    public function servers(Request $request)
    {
        return auth('api')->user()->servers;
    }

    /**
     * Returns the server.
     *
     * @param Server $server
     * @return Server
     */
    public function server(Server $server)
    {
        if (!in_array($server->id, auth('api')->user()->servers->map->id->toArray())) {
            return response([
                'message' => 'You are not authorized to see this server.',
                'errors' => [],
            ], 403);
        }

        // Aixo es tot de tot
        // $server->load(['cpus', 'nets', 'nets.addresses', 'disks', 'mems', 'pids']);

        $server->touch();
        
        $server['current'] = [
            'cpu' => $server->cpus()->where('time_id', null)->first(),
            'net' => $server->nets()->where('time_id', null)->with('addresses')->first(),
            'disks' => $server->disks()->where('time_id', null)->get(),
            'mem' => $server->mems()->where('time_id', null)->first(),
            'pid' => $server->pids()->where('time_id', null)->first()
        ];

        return $server;
    }

    /**
     * Stores the server information.
     *
     * @param Request $request
     * @return array
     */
    public function data(Request $request)
    {
        $user = auth('api')->user();

        if ($user->servers()->where('name', $request->get('server'))->count() > 1) {
            $user->servers()->where('name', $request->get('server'))->delete();
        }

        $server = $user->servers()->where('name', $request->get('server'))->firstOrCreate([
            'name'      => $request->get('server'),
            'os'        => $request->get('os'),
            'version'   => $request->get('version'),
            'node'      => $request->get('node'),
            'processor' => $request->get('processor'),
            'platform'  => $request->get('platform'),
        ]);

        $server->update([
            'os'        => $request->get('os'),
            'version'   => $request->get('version'),
            'node'      => $request->get('node'),
            'processor' => $request->get('processor'),
            'platform'   => $request->get('platform'),
        ]);

        $data = $request->get('data');

        // CPU
        $server->cpus()->updateOrcreate([
            'time_id' => null
        ], [
            'cores'         => $data['cpu']['cores'],
            'percent'       => $data['cpu']['percent'],
            'frequency'     => $data['cpu']['frequency'],
            'min_frequency' => $data['cpu']['min_frequency'],
            'max_frequency' => $data['cpu']['max_frequency']
        ]);

        // Disks
        $server->disks()->where('time_id', null)->delete();

        foreach ($data['disks'] as $key => $disk) {
            $server->disks()->create([
                'device'       => $key,
                'mount_point'   => $disk['mount_point'],
                'file_system'   => $disk['file_system'],
                'total'         => $disk['total'] * 9.31e-10,
                'used'          => $disk['used'] * 9.31e-10,
                'free'          => $disk['free'] * 9.31e-10,
                'percent'       => $disk['percent']
            ]);
        }

        // Mem
        $server->mems()->updateOrcreate([
            'time_id' => null
        ], [
            'total'     => $data['mem']['total'] * 9.31e-10,
            'available' => $data['mem']['available'] * 9.31e-10,
            'used'      => $data['mem']['used'] * 9.31e-10,
            'percent'   => $data['mem']['percent'],
            'free'      => $data['mem']['free'] * 9.31e-10
        ]);

        // Net
        $net = $server->nets()->updateOrcreate([
            'time_id' => null
        ], [
            'total' => $data['net']['total'],
            'stable' => $data['net']['stable'],
            'listen' => $data['net']['listen']
        ]);

        $net->addresses()->delete();
        foreach ($data['addresses'] as $key => $address) {
            $net->addresses()->create([
                'name'  => $key,
                'ip'    => $address
            ]);
        }

        // Pid
        $server->pids()->updateOrcreate([
            'time_id' => null
        ],[
            'number' => $data['pids']
        ]);

        Pusher::trigger('server_' . $server->id, 'update', 'ok');
        Pusher::trigger('servers_' . $user->id, 'update', 'ok');

        return [
            'response' => 'ok'
        ];
    }
}
