@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Utilizadores</h2>
</div>

<div class="row-add admin">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#addCsvFile">Adicionar</button>
</div>

<div class="search-row">    
    <select name="search_departamento" id="search-departamento" class="select-input search-select" onchange="SearchInput('/searchUsers'); changeDropdown('/getCursos', 'search-departamento', 'search-curso', '')">
        <option value="" id="">--Selecionar departamento--</option>
        @foreach($departamentos as $d)
            <option value="{{$d->id}}">{{$d->nome}}</option>
        @endforeach
    </select>
    <select name="search_curso" id="search-curso" class="select-input search-select" onchange="SearchInput('/searchUsers')">
        <option value="" id="">--Selecionar curso--</option>
        @foreach($cursos as $c)
            <option value="{{$c->id}}">{{$c->nome}}</option>
        @endforeach
    </select>
    <select name="search_perfil" id="search-perfil" class="select-input search-select" onchange="SearchInput('/searchUsers')">
        <option value="" id="">--Selecionar perfil--</option>
        @foreach($perfis as $p)
            <option value="{{$p->id}}">{{$p->nome}}</option>
        @endforeach
    </select>
    <div class="search">
        <input type="search" class="search-input" placeholder="Pesquisar..." results="0" onsearch="SearchInput('/searchUsers', '', this)">
        <i class="fas fa-search search-icon" onclick="SearchInput('/searchUsers')"></i>
    </div>
</div>

<div class="resultsAdmin">
    @include('admin.Utilizador.table')
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog admin" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel"><span id="titleAdd">Adicionar utilizador</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="editForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="form" id="form" value="modal">
                    
                    <div class="row group">
                        <div class="col-md-10">
                            <input type="text" name="nome" class="display-input" id="nome">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="nome" class="labelTextModal">Nome</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="numero" class="display-input" id="numero">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="numero" class="labelTextModal">Número</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="email" name="email" class="display-input" id="email">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="email" class="labelTextModal">Email</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-6">
                            <select name="departamento" id="departamento" class="select-input" onchange="changeDropdown('/getCursos', 'departamento', 'curso', 'editForm')">
                                <option value="" id="">--Selecionar departamento--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="departamento" class="labelTextModal">Departamento</label>
                        </div>
                        <div class="col-md-6">
                            <select name="curso" id="curso" class="select-input">
                                <option value="" id="">--Selecionar curso--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="curso" class="labelTextModal">Curso</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-6">
                            <input type="date" name="data_nascimento" class="display-input" id="data_nascimento">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="data_nascimento" class="labelTextModal">Data de nascimento</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="perfil" class="display-input" id="perfil">
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
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="Save('editForm', '/editUserPost')" style="display: inline-block !important">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCsvFile" tabindex="-1" role="dialog" aria-labelledby="addCsvFileLabel" aria-hidden="true">
    <div class="modal-dialog admin" role="document" style="min-width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCsvFileLabel">Importar utilizadores<span id="titleAdd"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route ('addUserCsv') }}" id="addCsvForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="file" id="csvfile" name="csvfile">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="csvfile" class="labelTextModal">Ficheiro de utilizadores</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="file" id="csvfilecadeira" name="csvfilecadeira">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="csvfilecadeira" class="labelTextModal">Ficheiro de disciplinas</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <p>Nota: Só são permitidos ficheiros .csv. Tem de importar os ficheiros dos utilizadores e das disciplinas a que pertencem em simultâneo.</p>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="display: inline-block !important">Criar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <span class="closeAlert" onclick="CloseAlert()">X</span>  
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        function CloseAlert() {
            $('.alert').css('display', 'none');
        }
    </script>
@endif

@endsection