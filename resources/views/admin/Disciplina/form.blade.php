@extends('homeAdmin')

@section('tables')

<div class="row-title">
    <h2>{{$cadeira->nome}}</h2>
</div>

<div class="main-container">
    <form method="post" action="{{ route ('editCadeiraPost') }}" id="" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="cadeira_id" id="cadeira_id" value="{{$cadeira->id}}">
        <input type="hidden" name="curso" id="curso" value="0">
        <input type="hidden" name="ano_letivo" id="ano_letivo" value="0">
        <input type="hidden" name="semestre" id="semestre" value="0">
        <input type="hidden" name="curso_id" id="curso_id" value="">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="nome" class="display-input input-form" id="nome" value="{{$cadeira->nome}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="nome" class="labelTextModal">Nome</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="codigo" class="display-input input-form" id="codigo" value="{{$cadeira->codigo}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="codigo" class="labelTextModal">Código</label>
            </div>
            <div class="col-md-1">
                <input type="text" name="ano" class="display-input input-form" id="codigo" value="{{$cadeira->ano}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="ano" class="labelTextModal">Ano</label>
            </div>
            <div class="col-md-1">
                <input type="checkbox" name="ativo" class="checkbox-input checkbox-form" id="ativo" <?php if($cadeira->ativo) echo 'checked'?>>
                <span class="checkbox-custom"></span>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="codigo" class="labelTextModal checkLabel">Ativo</label>
            </div>
        </div>  
        <div class="row-btn">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{route ('getCadeiras')}}"><button type="button" id="cancel">Voltar</button></a>
        </div>
    </form>
</div>

<div class="row-title  title-admin" style="margin-top: 10px;">
    <h2>Disciplinas a que pertence</h2>
</div>

<table class="subGrid">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Código</th>
            <th>Semestre</th>
            <th>Ano letivo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cursos as $curso)
            <tr>
                <td>{{$curso->nome}}</td>
                <td>{{$curso->codigo}}</td>
                <td>{{$curso->semestre}}</td>
                <td>{{$curso->ano}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection