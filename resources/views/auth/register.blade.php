@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex-center position-ref full-height ">
            <div class="top-right links">
                <a href="{{ url('/login') }}">{{ __('change.iniciarSessao') }}</a>
            </div>  
        </div>
    
    <div class="row">
        

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading col-md-6" id="registoAluno" onclick="ShowRegistoAluno()">{{ __('change.aluno') }} </div>
                <div class="panel-heading col-md-6" id="registoProfessor" onclick="ShowRegistoProfessor()">{{ __('change.professor') }} </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route ('registarAluno') }}" id="formAluno">
                        {{ csrf_field() }}
                        <input type="hidden" name="perfil_id" id="perfil_id" value="1">
                        <input type="hidden" name="tab_active" id="tab_active" value="#registoAluno">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{ __('change.nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                            <label for="numero" class="col-md-4 control-label">{{ __('change.numeroAluno') }}</label>

                            <div class="col-md-6">
                                <input id="numero" type="text" class="form-control" name="numero" value="{{ old('numero') }}"  autofocus>

                                @if ($errors->has('numero'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numero') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('data_nascimento') ? ' has-error' : '' }}">
                            <label for="data_nascimento" class="col-md-4 control-label">{{ __('change.dataNascimento') }}</label>

                            <div class="col-md-6">
                                <input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}"  autofocus>

                                @if ($errors->has('data_nascimento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_nascimento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('departamento_id') ? ' has-error' : '' }}">
                            <label for="departamento_id" class="col-md-4 control-label">{{ __('change.departamento') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="departamento_id" id="departamento_id" >
                                    <option value="">-- {{ __('change.selecionar') }} --</option>
                                    @foreach($departamentos as $departamento)
                                        @if ($departamento->id == old('departamento_id'))
                                            <option value="{{$departamento->id}}" selected>{{$departamento->nome}}</option>
                                        @else
                                        <option value="{{$departamento->id}}">{{$departamento->nome}}</option>
                                        @endif
                                    @endForeach
                                </select>

                                @if ($errors->has('departamento_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departamento_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('curso_id') ? ' has-error' : '' }}">
                            <label for="curso_id" class="col-md-4 control-label">{{ __('change.curso') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="curso_id" id="curso_id" >
                                    <option value="">-- {{ __('change.escolherCurso') }}--</option>
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

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >

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
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">{{ __('change.confirmarPass') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cadeiras') ? ' has-error' : '' }}">
                            <label for="cadeiras" class="col-md-4 control-label">{{ __('change.disciplinas') }}</label>

                            <div class="col-md-6">
                                <select multiple="multiple" class="form-control" name="cadeiras[]" id="cadeirasAluno" >
                                    @if(sizeof($cadeiras) == 0)
                                        <option value="">-- {{ __('change.escolherCurso') }} --</option>
                                    @else
                                        @foreach($cadeiras as $cadeira)
                                            @if ($cadeira->id == old('cadeira_id'))
                                                <option value="{{$cadeira->id}}" selected>{{$cadeira->nome}}</option>
                                            @else
                                                <option value="{{$cadeira->id}}">{{$cadeira->nome}}</option>
                                            @endif
                                        @endForeach
                                    @endif
                                </select>

                                @if ($errors->has('cadeiras'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cadeiras') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                {{ __('change.registar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" method="POST" action="{{ route ('registarProfessor') }}" id="formProfessor">
                        {{ csrf_field() }}
                        <input type="hidden" name="perfil_id" id="perfil_id" value="2">
                        <input type="hidden" name="tab_active" id="tab_active" value="#registoProfessor">

                        <div class="form-group{{ $errors->has('nameProf') ? ' has-error' : '' }}">
                            <label for="nameProf" class="col-md-4 control-label">{{ __('change.nome') }}</label>

                            <div class="col-md-6">
                                <input id="name2" type="text" class="form-control" name="nameProf" value="{{ old('nameProf') }}"  autofocus>

                                @if ($errors->has('nameProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nameProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('numeroProf') ? ' has-error' : '' }}">
                            <label for="numeroProf" class="col-md-4 control-label">{{ __('change.numDocente') }}</label>

                            <div class="col-md-6">
                                <input id="numero2" type="text" class="form-control" name="numeroProf" value="{{ old('numeroProf') }}"  autofocus>

                                @if ($errors->has('numeroProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numeroProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('data_nascimentoProf') ? ' has-error' : '' }}">
                            <label for="data_nascimentoProf" class="col-md-4 control-label">{{ __('change.dataNascimento') }}</label>

                            <div class="col-md-6">
                                <input id="data_nascimento2" type="date" class="form-control" name="data_nascimentoProf" value="{{ old('data_nascimentoProf') }}"  autofocus>

                                @if ($errors->has('data_nascimentoProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_nascimentoProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('departamento_idProf') ? ' has-error' : '' }}">
                            <label for="departamento_idProf" class="col-md-4 control-label">{{ __('change.departamento') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="departamento_idProf" id="departamento_id2" >
                                    <option value="">-- {{ __('change.selecionar') }} --</option>
                                    @foreach($departamentos as $departamento)
                                        @if ($departamento->id == old('departamento_idProf'))
                                            <option value="{{$departamento->id}}" selected>{{$departamento->nome}}</option>
                                        @else
                                        <option value="{{$departamento->id}}">{{$departamento->nome}}</option>
                                        @endif
                                    @endForeach
                                </select>

                                @if ($errors->has('departamento_idProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departamento_idProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('emailProf') ? ' has-error' : '' }}">
                            <label for="emailProf" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email2" type="email" class="form-control" name="emailProf" value="{{ old('emailProf') }}" >

                                @if ($errors->has('emailProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                    
                        <div class="form-group{{ $errors->has('passwordProf') ? ' has-error' : '' }}">
                            <label for="passwordProf" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password2" type="password" class="form-control" name="passwordProf" >

                                @if ($errors->has('passwordProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('passwordProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="passwordProf-confirm" class="col-md-4 control-label">{{ __('change.confirmarPass') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm2" type="password" class="form-control" name="passwordProf_confirmation" >
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cadeirasProf') ? ' has-error' : '' }}">
                            <label for="cadeirasProf" class="col-md-4 control-label">{{ __('change.disciplinas') }}</label>

                            <div class="col-md-6">
                                <select multiple="multiple" class="form-control" name="cadeirasProf[]" id="cadeirasProfessor" >
                                    @if(sizeof($cadeirasProf) == 0)
                                        <option value="">-- {{ __('change.escolherDepartamento') }} --</option>
                                    @else
                                        @foreach($cadeirasProf as $cadeira)
                                            @if ($cadeira->id == old('cadeira_id'))
                                                <option value="{{$cadeira->id}}" selected>{{$cadeira->nome}}</option>
                                            @else
                                                <option value="{{$cadeira->id}}">{{$cadeira->nome}}</option>
                                            @endif
                                        @endForeach
                                    @endif
                                </select>

                                @if ($errors->has('cadeirasProf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cadeirasProf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                {{ __('change.registar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="register_Image">
            <img src="{{ asset('images/register_image.svg') }}" width=27% class="image_register"> 
    </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({
        dateFormat: "dd-mm-yy"
     });

    $("#departamento_id").change(function(){
        $.ajax({
            url: "{{ route('changeDepartamentoId') }}?departamento_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#curso_id').html(data.html);
            }
        });
    });

    $("#departamento_id2").change(function(){
        $.ajax({
            url: "{{ route('changeDepartamentoProfId') }}?departamento_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#cadeirasProfessor').html(data.html);
            }
        });
    });

    $("#curso_id").change(function(){
        $.ajax({
            url: "{{ route('changeCursoId') }}?curso_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#cadeirasAluno').html(data.html);
            }
        });
    });

    $(document).ready(function() {
        if('{{$tab_active}}' == "#registoAluno") {
            ShowRegistoAluno();
        }
        else {
            ShowRegistoProfessor();
        }
    });
</script>
@endsection