@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registar </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route ('registarPost') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('n_aluno') ? ' has-error' : '' }}">
                            <label for="n_aluno" class="col-md-4 control-label">Nº Aluno</label>

                            <div class="col-md-6">
                                <input id="n_aluno" type="text" class="form-control" name="n_aluno" value="{{ old('n_aluno') }}" required autofocus>

                                @if ($errors->has('n_aluno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_aluno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('data_nascimento') ? ' has-error' : '' }}">
                            <label for="data_nascimento" class="col-md-4 control-label">Data de nascimento</label>

                            <div class="col-md-6">
                                <input id="data_nascimento" type="text" class="date form-control" name="data_nascimento" value="{{ old('data_nascimento') }}" required autofocus>

                                @if ($errors->has('data_nascimento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_nascimento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('curso_id') ? ' has-error' : '' }}">
                            <label for="curso_id" class="col-md-4 control-label">Curso</label>

                            <div class="col-md-6">
                                <select class="form-control" name="curso_id" id="curso_id" required>
                                    <option value="">-- Selecionar --</option>
                                    @foreach($cursos as $curso)
                                        @if ($curso->id == old('curso_id'))
                                            <option value="{{$curso->id}}" selected>{{$curso->nome}}</option>
                                        @else
                                        <option value="{{$curso->id}}">{{$curso->nome}}</option>
                                        @endif
                                    @endForeach
                                </select>

                                @if ($errors->has('curso_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('curso_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('grau_academico_id') ? ' has-error' : '' }}">
                            <label for="grau_academico_id" class="col-md-4 control-label">Grau académico</label>

                            <div class="col-md-6">
                                <select class="form-control" name="grau_academico_id" id="grau_academico_id" required>
                                    <option value="">-- Selecionar --</option>
                                    @foreach($graus_academicos as $grau_academico)
                                        @if ($grau_academico->id == old('grau_academico_id'))
                                            <option value="{{$grau_academico->id}}" selected>{{$grau_academico->nome}}</option>
                                        @else
                                            <option value="{{$grau_academico->id}}">{{$grau_academico->nome}}</option>
                                        @endif
                                    @endForeach
                                </select>

                                @if ($errors->has('grau_academico_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('grau_academico_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                    
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({
        dateFormat: "dd-mm-yy"
     });
</script>  
@endsection
