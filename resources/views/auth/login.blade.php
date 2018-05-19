@extends('layouts.auth')

@section('content')
<div class="w-full lg:w-1/2 bg-white p-6 shadow-lg rounded">
    <div class="mb-6 text-4xl">
        Login
        <center>
            <img src="{{ asset('img/key.svg') }}" height="150" alt="Credentials">
        </center>
    </div>
    <div>
        <input type="text" name="email" class="w-full border-l-4 border-primary px-6 py-4 text-lg rounded bg-primary-lightest" placeholder="Email">
        <input type="password" name="password" class="w-full border-l-4 border-primary my-4 px-6 py-4 text-lg rounded bg-primary-lightest" placeholder="Password">
        <center>
            <button class="bg-primary text-white uppercase py-3 px-6 rounded" type="submit">Login</button>
        </center>
    </div>
</div>
@endsection
