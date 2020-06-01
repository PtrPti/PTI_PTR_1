@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <div class="" id="tab1"><img src="{{ asset('images/home_icon.png') }}"> Home </div>
    <div class="has-dropdown" id="tab2"><img src="{{ asset('images/disciplinas_icon.png') }}"> Disciplinas 
        <ul class="dropdown">
            @foreach($disciplinas as $d)
            <li class="dropdown-item">
                <a href="{{ route('indexDisciplinaDocente', ['id' => $d->id]) }}" class="item-link">{{$d->nome}}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="has-dropdown" id="tab3"><img src="{{ asset('images/projetos_icon.png') }}"> Projetos 
        <ul class="dropdown">
            @foreach($projetos as $p)
            <li class="dropdown-item">
                <a href="{{ route('id_projeto', ['id' => $p->id]) }}" class="item-link">{{$p->nome}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="homeDocente">
    @include('docente.disciplinasDocente')
    @include('docente.projetosDocente')    
<div>

@endsection