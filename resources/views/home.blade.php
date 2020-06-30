@extends('layouts.app_novo')

@section('content')

<div class="main-container">
    <h5>Disciplinas</h5>
    <div class="box-container">
        @foreach ($disciplinas as $disciplina)
            <div class="box">
                <a href="{{ route('disciplina', ['id' => $disciplina->id]) }}">{{$disciplina->nome}} </a>
            </div>
        @endforeach        
    </div>
</div>

<div class="main-container">
  @if (Auth::user()->isAluno())
    <h5>Projetos    
      <a id="dropdownMenu" role="button" data-toggle="dropdown" class="btn-filter" data-target="#" href="#" style="background-color: #eee9e9;">
        <i class="fas fa-filter"></i>
      </a>
      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="position: absolute;top: 24px;right: 10px;">
        <div id="filtroProjeto">
          <li class="dropdown-item">
            <input type="checkbox" id="favoritos" name="favoritos">
            <label for="favoritos">Favoritos</label>
          </li>
          <li class="dropdown-item">
            <input type="checkbox" id="em_curso" name="em_curso">
            <label for="em_curso">Em curso</label>
          </li>
          <li class="dropdown-item">
            <input type="checkbox" id="terminados" name="terminados">
            <label for="terminados">Terminados</label>
          </li>
          
          <button type='button' class="filtro_btn" onclick="filterProj()">Aplicar</button>
        </div>
      </ul>
    </h5>
  @else
    <h5>Projetos</h5>
  @endif
    <div class="search">
        <input type="search" class="search-input" placeholder="Pesquisar" results="0">
        <i class="fas fa-search search-icon"></i>
    </div> 
    <div class="box-container">
        @if (Auth::user()->isProfessor())
            @foreach ($projetos as $proj)
                <div class="box">
                    <a href="{{ route('disciplina', ['id' => $proj->cadeira_id, 'tab' => 1, 'proj' => $proj->id]) }}">
                        {{$proj->nome}}<br>
                        <small>{{$proj->cadeira}}</small>
                    </a>
                </div>
            @endforeach
        @else
            @include('filtroProjeto')
        @endif
    </div>
</div>

@endsection