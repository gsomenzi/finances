@extends('_templates/auth')
@section('main')
    <h2 class="uk-heading">Cadastro</h2>
    <form method="POST" action="{{route('web.register.register')}}" class="uk-form">
        {{-- NOME --}}
        <div class="uk-margin">
            <label class="uk-form-label" for="name">Nome</label>
            <div class="uk-form-controls">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input class="uk-input {{$errors->first("name") ? "uk-form-danger" : ""}}" id="name" name='name' type="text" placeholder="Seu nome" value="{{old("name")}}">
                </div>
                @error('name')
                <span class="uk-text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        {{-- EMAIL --}}
        <div class="uk-margin">
            <label class="uk-form-label" for="email">E-mail</label>
            <div class="uk-form-controls">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: mail"></span>
                    <input class="uk-input {{$errors->first("email") ? "uk-form-danger" : ""}}" id="email" name='email' type="email" placeholder="exemplo@dominio.com" value="{{old("email")}}">
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
            <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                <div uk-spinner style="display: none"></div>
                Cadastrar
            </button>
        </div>
        @csrf
    </form>
    <a href="{{route("web.auth.view")}}" class="uk-link">Entre com o seu usuário</a>
@endsection