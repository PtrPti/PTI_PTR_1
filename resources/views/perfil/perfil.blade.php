@extends('layouts.app_novo')

@section('content')

<div class="row-title breadcrums">
    
    
    <img src="{{ asset('images/perfil_page.svg') }}" width=10% style="position:fixed; top:40px; left:350px;">
    <h2 class="nome_profile">{{Auth::user()->getUserName()}}</h2>
    <button class="btn btn-primary btn_perfil">{{ __('change.mudarImagemPerfil') }}</button>
</div>

<div class="informacao">
    @if (Auth::user()->isProfessor())
       
        <h5 class="t1">{{ __('change.estatuto') }}: {{ __('change.professor') }} </h5>
        <h5 class="t2">{{ __('change.disciplinas') }}: </h5>
        @foreach($disciplinas as $disciplina)
        <a class="t3"><ul> {{$disciplina->nome}} </ul></a>
        @endforeach
    
    @else
        <h5>{{ __('change.estatuto') }}: {{ __('change.aluno') }} </h5>
    @endif


</div>




@endsection