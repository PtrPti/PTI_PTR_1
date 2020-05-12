@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <div class="" id="tab1" onclick="ShowHome()"><img src="{{ asset('images/home_icon.png') }}"> Home </div>
    <div class="" id="tab2" onclick="ShowProjetos()"><img src="{{ asset('images/disciplinas_icon.png') }}"> Disciplinas </div>
    <div class="" id="tab2" onclick="ShowProjetos()"><img src="{{ asset('images/projetos_icon.png') }}"> Projetos </div>
</div>

<div class="homeDocente">
    @include('docente.disciplinasDocente')
    @include('docente.projetosDocente')
<div>

@endsection

