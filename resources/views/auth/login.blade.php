@extends('layouts.app')

@section('content')
    <div id="connect">
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
    @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Adresse Email</label>
            <input type="email" id="email" class="form-control" id="exampleInputPassword1" name="email" :value="old('email')" required autofocus>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
        </div>
        <div class="form-group form-check">
            <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
            <label class="form-check-label" for="exampleCheck1">Rester connecter</label>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
    </div>


@endsection
