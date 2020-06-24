@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Cursos</h2>
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
            <th>Departamento</th>
            <th>Ativo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cursos as $curso) 
            <tr>
                <td><i class="fas fa-edit" onclick="EditModal({{$curso->id}}, 'Curso', 'Editar curso')" role="button" data-toggle="modal" data-target="#edit"></i></td>
                <td>{{$curso->nome}}</td>
                <td>{{$curso->codigo}}</td>
                <td>{{$curso->departamento}}</td>
                <td>{{$curso->active}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel"><span id="titleAdd">Adicionar curso</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="editForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="curso_id" id="curso_id" value="">
                    
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="text" name="nome" class="display-input" id="nome">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="nome" class="labelTextModal">Nome</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-6">
                            <input type="text" name="codigo" class="display-input" id="codigo">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="codigo" class="labelTextModal">Codigo</label>
                        </div>
                        <div class="col-md-6">
                            <select name="departamento" id="departamento" class="select-input">
                                <option value="" id="">--Selecionar departamento--</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="departamento" class="labelTextModal">Departamento</label>
                        </div>                        
                    </div>
                    <div class="row group">
                        <div class="col-md-12 checkbox-group">
                            <input type="checkbox" name="ativo" class="checkbox-input" id="ativo">
                            <span class="checkbox-custom"></span>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ativo" class="labelTextModal">Ativo</label>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="Save('editForm', '/editCursoPost')" style="display: inline-block !important">Guardar</button>
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
                <h5 class="modal-title" id="addCsvFileLabel">Importar cursos<span id="titleAdd"></span></h5>
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

{{$cursos->links()}}

@endsection