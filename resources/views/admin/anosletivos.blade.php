@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Anos letivos</h2>
</div>

<div class="row-add admin">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#edit">Adicionar registo</button>
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#addCsvFile">Importar ficheiro</button>
</div>

<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Ano letivo</th>
            <th>Data início</th>
            <th>Data fim</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anosLetivos as $ano) 
            <tr>
                <td><i class="fas fa-edit" onclick="EditModal({{$ano->id}}, 'AnoLetivo', 'Editar ano letivo')" role="button" data-toggle="modal" data-target="#edit"></i></td>
                <td>{{$ano->ano}}</td>
                <td>{{$ano->getFullDate($ano->dia_inicio, $ano->mes_inicio, $ano->ano_inicio, 'd-m-Y')}}</td>
                <td>{{$ano->getFullDate($ano->dia_fim, $ano->mes_fim, $ano->ano_fim, 'd-m-Y ')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel"><span id="titleAdd">Adicionar ano letivo</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="editForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="ano_letivo_id" id="ano_letivo_id" value="">
                    
                    <div class="row group">
                        <div class="col-md-2">
                            <input type="text" name="ano" class="display-input" id="ano">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="ano" class="labelTextModal">Ano</label>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="data_inicio" class="display-input" id="data_inicio">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="data_inicio" class="labelTextModal">Data de início</label>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="data_fim" class="display-input" id="data_fim">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="data_fim" class="labelTextModal">Data de fim</label>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="Save('editForm', '/editAnoLetivoPost')" style="display: inline-block !important">Guardar</button>
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

{{$anosLetivos->links()}}

@endsection