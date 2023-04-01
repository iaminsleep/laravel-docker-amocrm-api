@extends('layout')

@section('page-title', 'Регистрация')

@section('page-content')
    <div class="main">
        {{-- <input type="checkbox" id="chk" aria-hidden="true"> --}}

        <div class="signup">
            <form action="{{ route('register.perform') }}" method="post">
                <label for="chk" aria-hidden="true">Регистрация</label>
                <input type="text" name="name" placeholder="Имя" required="">
                <input type="email" name="email" placeholder="Почта" required="">
                <input type="password" name="password" placeholder="Пароль" required="">
                <button>Создать аккаунт</button>
                @csrf
            </form>
        </div>
    </div>
@endsection
