@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Disciplinas</h2>
</div>

<div class="row-add admin">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#edit">Adicionar registo</button>
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#addCsvFile">Importar ficheiro</button>
</div>

<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>Código</th>
            <th>Ano</th>
            <th>Semestre</th>
            <th>Curso</th>
            <th>Ano letivo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cadeiras as $cadeira) 
            <tr>
                <td><i class="fas fa-edit" onclick="EditModal({{$cadeira->id}}, 'Cadeira', 'Editar disciplina')" role="button" data-toggle="modal" data-target="#edit"></i></td>
                <td>{{$cadeira->nome}}</td>
                <td>{{$cadeira->cod_cadeiras}}</td>
                <td>{{$cadeira->ano}}</td>
                <td>{{$cadeira->semestre}}</td>
                <td>{{$cadeira->curso}}</td>
                <td>{{$cadeira->ano_letivo}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
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
                    
                    <div class="row group">
                        <div class="col-md-6">
                            <input type="text" name="semestre" class="display-input" id="semestre">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="semestre" class="labelTextModal">Semestre</label>
                        </div>
                        <div class="col-md-6">
                            <select name="ano_letivo" id="ano_letivo" class="select-input">
                                <option value="" id="">--Selecionar ano--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ano_letivo" class="labelTextModal">Ano</label>
                        </div>
                        
                    </div>
                    <div class="row group">
                        <div class="col-md-6">
                            <input type="date" name="data_inicio" class="display-input" id="data_inicio">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="data_inicio" class="labelTextModal">Data de início</label>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="data_fim" class="display-input" id="data_fim">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="data_fim" class="labelTextModal">Data de fim</label>
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
                <form method="post" action="{{ route ('addDepartamentoCsv') }}" id="addCsvForm" enctype="multipart/form-data">
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
                            <p>Nota: Só são permitidos ficheiros .csv. O ficheiro tem de ter o formato: Ano,DataInicio,DataFim</p>
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

{{$cadeiras->links()}}

@endsection