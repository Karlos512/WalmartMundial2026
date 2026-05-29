@extends('layouts.provider')
@section('content')
    @livewire('user.nuevo-password', ['token' => $token, 'email' => $email])
@endsection