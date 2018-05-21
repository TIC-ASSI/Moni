<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Server;
use Illuminate\Http\Request;

class AppController extends Controller
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

        $server->current = [
            'cpu' => $server->cpus()->where('time_id', null)->first(),
            'net' => $server->nets()->where('time_id', null)->with('addresses')->first(),
            'disks' => $server->disks()->where('time_id', null)->get(),
            'mem' => $server->mems()->where('time_id', null)->first(),
            'pid' => $server->pids()->where('time_id', null)->first()
        ];

        return $server;
    }
}
