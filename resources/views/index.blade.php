@extends('layout')

@section('page-title', 'Главная страница')

@section('page-content')
    <div class="main">
        <a href="{{ route('auth') }}">Авторизоваться через AmoCRM</a>
        <h1>Сделки AmoCRM</h1>
        @forelse($deals as $deal)
            <p>{{ $reply->body }}</p>
        @empty
            <p>Нет сделок</p>
        @endforelse
    </div>
@endsection
