@extends('homeAdmin')

@section('tables')

<div class="row-title">
    <h2>{{$user->nome}}</h2>
</div>

<div class="main-container">
    <form method="post" action="{{ route ('editUserPost') }}" id="" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="user_id" id="user_id" value="{{$user->userId}}">                    
        <input type="hidden" name="form" id="form" value="form">
        <div class="row group">
            <div class="col-md-10">
                <input type="text" name="nome" class="display-input input-form" id="nome" value="{{$user->nome}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="nome" class="labelTextModal">Nome</label>
            </div>
            <div class="col-md-2">
                <input type="text" name="numero" class="display-input input-form" id="numero" value="{{$user->numero}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="numero" class="labelTextModal">Número</label>
            </div>
        </div>
        <div class="row group">
            <div class="col-md-12">
                <input type="email" name="email" class="display-input input-form" id="email" value="{{$user->email}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="email" class="labelTextModal">Email</label>
            </div>
        </div>
        <div class="row group">
            <div class="col-md-6">
                <select name="departamento" id="departamento" class="select-input input-form" onchange="changeDropdown('/getCursos', 'departamento', 'curso')">
                    <option value="" id="">--Selecionar departamento--</option>
                    @foreach ($departamentos as $key => $value)
                        <option value="{{$key}}" id="d_{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="departamento" class="labelTextModal">Departamento</label>
            </div>
            <div class="col-md-6">
                <select name="curso" id="curso" class="select-input input-form">
                    <option value="" id="">--Selecionar curso--</option>
                    @foreach ($cursos as $key => $value)
                        <option value="{{$key}}" id="c_{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="curso" class="labelTextModal">Curso</label>
            </div>
            <script>
                $(document).ready(function () {
                    $("#d_<?php echo $user->departamento_id ?>").prop('selected', true);
                    $("#departamento").addClass('used');
                    $("#c_<?php echo $user->curso_id ?>").prop('selected', true);
                    $("#curso").addClass('used');
                });
            </script>
        </div>
        <div class="row group">
            <div class="col-md-6">
                <input type="date" name="data_nascimento" class="display-input input-form" id="data_nascimento" value="{{ date('Y-m-d', strtotime($user->data_nascimento)) }}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="data_nascimento" class="labelTextModal">Data de nascimento</label>
            </div>
            <div class="col-md-6">
                <input type="text" name="perfil" class="display-input input-form" id="perfil" value="{{$user->perfil}}">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="perfil" class="labelTextModal">Perfil</label>
            </div>
            <script>
                $(document).ready(function () {
                    $("#perfil").prop('disabled', true);
                });
            </script>
        </div>
        <div class="row-btn">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{route ('getUtilizadores')}}"><button type="button" id="cancel">Voltar</button></a>
        </div>
    </form>
</div>

<div class="row-title  title-admin" style="margin-top: 10px;">
    <h2>Matrículas</h2>
</div>

<table class="subGrid">
    <thead>
        <tr>
            <th>Disciplina</th>
            <th>Ano letivo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($matriculas as $m)
            <tr>
                <td>{{$m->nome}}</td>
                <td>{{$m->ano}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection