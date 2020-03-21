@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <div class="active" id="homeBtn" onclick="ShowHome()"><img src="{{ asset('images/home_icon.png') }}"> Home </div>
    <div id="projetosBtn" onclick="ShowProjetos()"><img src="{{ asset('images/projetos_icon.png') }}"> Projetos </div>
</div>

@include('docente.disciplinasDocente')
@include('docente.projetosDocente')

@endsection