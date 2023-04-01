@extends('layout')

@section('page-title', 'Авторизация')

@section('page-content')
    <div class="main">
        <div class="signup">
            <form action="{{ route('login.perform') }}" method="post">
                <label for="chk" aria-hidden="true">Вход</label>
                <input type="email" name="email" placeholder="Почта" required="">
                <input type="password" name="password" placeholder="Пароль" required="">
                <button>Войти</button>
                @csrf
            </form>
        </div>
    </div>
@endsection
