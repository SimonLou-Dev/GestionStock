@extends('layouts.app')
@section('content')

    <div id="register">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" :value="old('name')" required autofocus autocomplete="name" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="email" name="email" :value="old('email')" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </form>
    </div>


@endsection
