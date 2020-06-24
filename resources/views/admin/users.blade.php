@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Utilizadores</h2>
</div>

<div class="row-add admin">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#addCsvFile">Importar ficheiro</button>
</div>

<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>Número</th>
            <th>Email</th>
            <th>Data de nascimento</th>
            <th>Departamento</th>
            <th>Curso</th>
            <th>Perfil</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user) 
            <tr>
                <td><i class="fas fa-edit" onclick="EditModal({{$user->userId}}, 'User', 'Editar utilizador')" role="button" data-toggle="modal" data-target="#edit"></i></td>
                <td>{{$user->nome}}</td>
                <td>{{$user->numero}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->data_nascimento}}</td>
                <td>{{$user->departamento}}</td>
                <td>{{$user->curso}}</td>
                <td>{{$user->perfil}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

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
                    
                    <div class="row group">
                        <div class="col-md-6">
                            <input type="text" name="nome" class="display-input" id="nome">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="nome" class="labelTextModal">Nome</label>
                        </div>
                        <div class="col-md-6">
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
                            <select name="departamento" id="departamento" class="select-input">
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
    <div class="modal-dialog" role="document">
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
                            <label for="csvfile" class="labelTextModal">Ficheiro</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <p>Nota: Só são permitidos ficheiros .csv. O ficheiro tem de ter o formato: Nome,Número,Email,DataNascimento,Departamento,Curso,Perfil</p>
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

{{$users->links()}}

@endsection