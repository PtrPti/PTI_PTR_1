@extends('layouts.app_docente')

@section('content')


<div class="nav_icons">
    <a  > <img src="{{ asset('images/home_icon.png') }}" width=23px> Home </a>
    <a> <img src="{{ asset('images/disciplinas_icon.png') }}" width=23px> Disciplinas </a>
    <a href="{{ url('/projetosDocente') }}" > <img src="{{ asset('images/projetos_icon.png') }}" width=23px> Projetos </a>
</div>

@endsection

