@extends('_templates/auth')
@section('main')
    <h2 class="uk-heading">Login</h2>
    <form method="POST" action="{{route('api.auth.authenticate')}}" class="uk-form">
        {{-- EMAIL --}}
        <div class="uk-margin">
            <label class="uk-form-label" for="email">E-mail</label>
            <div class="uk-form-controls">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input class="uk-input {{$errors->first("email") ? "uk-form-danger" : ""}}" id="email" name='email' type="email" placeholder="exemplo@gmail.som" value="{{old("email")}}">
                </div>
                @error('email')
                <span class="uk-text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        {{-- SENHA --}}
        <div class="uk-margin">
            <label class="uk-form-label" for="password">Senha</label>
            <div class="uk-form-controls">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input class="uk-input {{$errors->first("password") ? "uk-form-danger" : ""}}"" id="password" name="password" type="password" placeholder="* * * * * *">
                </div>
                @error('password')
                <span class="uk-text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="uk-margin">
            <button class="uk-button uk-button-primary uk-width-1-1">Login</button>
        </div>
        @csrf
    </form>
@endsection