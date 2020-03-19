@extends('layouts.app')

@section('content')

<div id="apps">
    <div class="nav_icons">
        <a > <img src="{{ asset('images/home_icon.png') }}" width=23px> Home </a>
        <a> <img src="{{ asset('images/disciplinas_icon.png') }}" width=23px> Disciplinas </a>
        <a> <img src="{{ asset('images/projetos_icon.png') }}" width=23px> Projetos </a>
        <a> <img src="{{ asset('images/calendario_icon.png') }}" width=23px> Calendário </a>                
    </div>

    <div class="chat_icon">
        <img src="{{ asset('images/chat_icon.png') }}" width=40px>
    </div>

    <div class=chat>        
    </div>
</div>
@endsection
