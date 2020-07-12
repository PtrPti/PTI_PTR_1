@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Disciplinas</h2>
</div>

<div class="row-add admin">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#create">Adicionar registo</button>
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#addCsvFile">Importar ficheiro</button>
</div>

<div class="search-row">
    <select name="search_curso" id="search-curso" class="select-input search-select" onchange="SearchInput('/searchCadeiras')">
        <option value="" id="">--Selecionar curso--</option>
        @foreach($cursos as $c)
            <option value="{{$c->id}}">{{$c->nome}}</option>
        @endforeach
    </select>
    <select name="search_ano_letivo" id="search-ano_letivo" class="select-input search-select" onchange="SearchInput('/searchCadeiras')">
        <option value="" id="">--Selecionar ano letivo--</option>
        @foreach($anosLetivos as $a)
            <option value="{{$a->id}}">{{$a ->ano}}</option>
        @endforeach
    </select>
    <select name="search_semestre" id="search-semestre" class="select-input search-select" onchange="SearchInput('/searchCadeiras')">
        <option value="" id="">--Selecionar semestre--</option>
        @foreach($semestres as $s)
            <option value="{{$s->id}}">{{$s->semestre}}</option>
        @endforeach
    </select>
    <div class="search">
        <input type="search" class="search-input" placeholder="Pesquisar..." results="0" onsearch="SearchInput('/searchCadeiras', '', this)">
        <i class="fas fa-search search-icon" onclick="SearchInput('/searchCadeiras')"></i>
    </div>
</div>

<div class="resultsAdmin">
    @include('admin.Disciplina.table')
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="min-width:600px">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel"><span id="titleAdd">Adicionar disciplina</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="editForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="cadeira_id" id="cadeira_id" value="">
                    <input type="hidden" name="curso_id" id="curso_id" value="">
                    
                    <div class="row group">
                        <div class="col-md-8">
                            <input type="text" name="nome" class="display-input" id="nome">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="nome" class="labelTextModal">Nome</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="codigo" class="display-input" id="codigo">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="codigo" class="labelTextModal">Código</label>
                        </div>                        
                    </div>
                    <div class="row group">
                        <div class="col-md-4">
                            <input type="text" name="ano" class="display-input" id="ano">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ano" class="labelTextModal">Ano</label>
                        </div>
                        <div class="col-md-4">
                            <select name="ano_letivo" id="ano_letivo" class="select-input" onchange="changeDropdown('/getSemestres', 'ano_letivo', 'semestre', 'editForm')">
                                <option value="" id="">--Selecionar ano letivo--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ano_letivo" class="labelTextModal">Ano letivo</label>
                        </div>
                        <div class="col-md-4">
                            <select name="semestre" id="semestre" class="select-input">
                                <option value="" id="">--Selecionar semestre--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="semestre" class="labelTextModal">Semestre</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-10">
                            <select name="curso" id="curso" class="select-input">
                                <option value="" id="">--Selecionar curso--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="curso" class="labelTextModal">Curso</label>
                        </div>          
                        <div class="col-md-2 checkbox-group">
                            <input type="checkbox" name="ativo" class="checkbox-input" id="ativo">
                            <span class="checkbox-custom"></span>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ativo" class="labelTextModal">Ativo</label>
                        </div>             
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="Save('editForm', '/editCadeiraPost')" style="display: inline-block !important">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="min-width:600px">
            <div class="modal-header">
                <h5 class="modal-title" id="createLabel"><span id="titleAdd">Adicionar disciplina</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="createForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    
                    <div class="row group">
                        <div class="col-md-8">
                            <input type="text" name="nome" class="display-input" id="nome">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="nome" class="labelTextModal">Nome</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="codigo" class="display-input" id="codigo">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="codigo" class="labelTextModal">Código</label>
                        </div>                        
                    </div>
                    <div class="row group">
                        <div class="col-md-4">
                            <input type="text" name="ano" class="display-input" id="ano">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ano" class="labelTextModal">Ano</label>
                        </div>
                        <div class="col-md-4">
                            <select name="ano_letivo" id="ano_letivo" class="select-input" onchange="changeDropdown('/getSemestres', 'ano_letivo', 'semestre', 'createForm')">
                                <option value="" id="">--Selecionar ano letivo--</option>
                                @foreach($anosLetivos as $ano)
                                    <option value="{{$ano->id}}">{{$ano ->ano}}</option>
                                @endforeach
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ano_letivo" class="labelTextModal">Ano letivo</label>
                        </div>
                        <div class="col-md-4">
                            <select name="semestre" id="semestre" class="select-input">
                                <option value="" id="">--Selecionar semestre--</option>
                                @foreach($semestres as $semestre)
                                    <option value="{{$semestre->id}}">{{$semestre->semestre}}</option>
                                @endforeach
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="semestre" class="labelTextModal">Semestre</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-10">
                            <select name="curso" id="curso" class="select-input">
                                <option value="" id="">--Selecionar curso--</option>
                                @foreach($cursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso->nome}}</option>
                                @endforeach
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="curso" class="labelTextModal">Curso</label>
                        </div>          
                        <div class="col-md-2 checkbox-group">
                            <input type="checkbox" name="ativo" class="checkbox-input" id="ativo">
                            <span class="checkbox-custom"></span>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ativo" class="labelTextModal">Ativo</label>
                        </div>             
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="Save('createForm', '/addCadeiraPost')" style="display: inline-block !important">Criar</button>
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
                <h5 class="modal-title" id="addCsvFileLabel">Importar anos letivos<span id="titleAdd"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route ('addCadeirasCsv') }}" id="addCsvForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="file" id="csvfile" name="csvfile">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="csvfile" class="labelTextModal">Ficheiro</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <p>Nota: Só são permitidos ficheiros .csv. O ficheiro tem de ter o formato: Nome,Código,Ano,Semestre,Curso,Ano letivo,Ativo</p>
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