@extends('layouts.app_aluno')

@section('content')

<div class="layout_extra">

    <div class='barraLateral'>
        <div class="nav_icons">

            <a href="{{ route('alunoHome') }}" style="padding: 8px;"> <img src="{{ asset('images/home_icon.png') }}" width=23px> Home </a>
            <button class="dropdown-btn disc" style="padding: 8px;">
                <img src="{{ asset('images/disciplinas_icon.png') }}" width=23px> Disciplinas 
                <i id="i-disciplina" class="caret-icon fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                @foreach ($cadeiras as $disciplina)
                    <a href="{{ route('pagDisciplina', ['cadeira_id' => $disciplina->id]) }}"> {{$disciplina->nome}} </a>
                @endforeach
            </div>
            <button class="dropdown-btn proj" style="padding: 8px;">
                <img src="{{ asset('images/projetos_icon.png') }}" width=23px> Projetos
                <i id="i-projeto" class="caret-icon fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container ">
                @foreach ($projetos as $proj)
                    <a href="{{ route('pagProjeto', ['id' => $proj->id]) }}"> {{$proj->projeto}} | Grupo Nº{{$proj->numero}}</a>
                @endforeach
            </div>            
        </div>                       
    </div>
    <div class="infPerfil">
        <h3>Gerir conta</h3>

        <table class="tablePerfil">
            <tr>
                <td class="primeira_coluna" >Foto</td>
                <td>foto</td>
                <td><img src="{{ asset('images/pessoa.png') }}" width=60px> </td>
            </tr>
            <tr>
                <td class="primeira_coluna">Nome</td>
                <td>{{$user->nome}}</td>
                <td><button id="editNome"><img src="{{ asset('images/edit(1).png') }}" width=23px></button></td>
            </tr>
            <tr>
                <td class="primeira_coluna">E-mail</td>
                <td>{{$user->email}}</td>
                <td><button id="editEmail"><img src="{{ asset('images/edit(1).png') }}" width=23px></button></td>
            </tr>
            <tr>
                <td class="primeira_coluna">Palavra-Pass</td>
                <td>************</td>
                <td><button id="editPassword"><img src="{{ asset('images/edit(1).png') }}" width=23px></button></td>
            </tr>
        </table>

        <div id="Nome" class="modal">
            <div class="modal-content" id="changeUser">
                <span class="closeNome" style="margin-top: 5px;margin-right: 15px;">&times;</span>
                <h3>Altere o seu nome</h3>
                <div style="display: grid;grid-template-columns: 20% 80%;margin-top: 18px;">
                    <div>
                        <label for="nome" style="padding: 0px;margin-top: 5px;">Nome</label><br>
                    </div>
                    <div>
                        <input type="text" id="novoNome" style="width: 90%;" value="{{$user->nome}}"><br>
                    </div>
                    <button type='button' onclick="changeNome($user->password)">Alterar</button>
                </div>
            </div>
        </div> 

        <div id="Email" class="modal">
            <div class="modal-content" id="changeEmail">
                <span class="closeEmail" style="margin-top: 5px;margin-right: 15px;">&times;</span>
                <h3>Altere o seu email</h3>
                <div style="display: grid;grid-template-columns: 20% 80%;margin-top: 18px;">
                    <div>
                        <label for="email" style="padding: 0px;margin-top: 5px;">Email</label><br>
                    </div>
                    <div>
                        <input type="email" id="novoEmail" style="width: 90%;" value="{{$user->email}}"><br>
                    </div>
                    <button type='button' onclick="changeEmail()">Alterar</button>
                </div>
            </div>
        </div> 

        <div id="Password" class="modal">
            <div class="modal-content" id="changePass">
                <span class="closePass" style="margin-top: 5px;margin-right: 15px;">&times;</span>
                <h3>Altere a sua palavra-passe</h3>
                <div style="display: grid;grid-template-columns: 40% 60%;margin-top: 18px;">
                    <div>
                        <label for="pass" style="padding: 0px;margin-top: 5px;">Palavra-pass atual:</label><br>
                    </div>
                    <div>
                        <input type="password" id="atualPass" style="width: 90%;" value="************"><br>
                    </div>
                    <div>
                        <label for="pass" style="padding: 0px;margin-top: 5px;" >Nova palavra-pass:</label><br>
                    </div>
                    <div>
                        <input type="password" id="novaPass" style="width: 90%;" value="************"><br>
                    </div>
                    <div>
                        <label for="pass" style="padding: 0px;margin-top: 5px;">Repita a nova palavra-pass:</label><br>
                    </div>
                    <div>
                        <input type="password" id="repNovaPass" style="width: 90%;" value="************"><br>
                    </div>
                    <button type='button' onclick="checkPass()">Alterar</button>
                    <div class="pass">
                        
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<script>
    $(document).ready(function () {

        // Mudar nome
        var modal_nome = document.getElementById("Nome");
        var btn_nome = document.getElementById("editNome");
        var span_nome = document.getElementsByClassName("closeNome")[0];

        btn_nome.onclick = function() {
            modal_nome.style.display = "block";
        }

        span_nome.onclick = function() {
            modal_nome.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal_nome) {
                modal_nome.style.display = "none";
            }
        }

        // Mudar email
        var modal_email = document.getElementById("Email");
        var btn_email = document.getElementById("editEmail");
        var span_email = document.getElementsByClassName("closeEmail")[0];

        btn_email.onclick = function() {
            modal_email.style.display = "block";
        }

        span_email.onclick = function() {
            modal_email.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal_email) {
                modal_email.style.display = "none";
            }
        }

        // Mudar password
        var modal_pass = document.getElementById("Password");
        var btn_pass = document.getElementById("editPassword");
        var span_pass = document.getElementsByClassName("closePass")[0];

        btn_pass.onclick = function() {
            modal_pass.style.display = "block";
        }

        span_pass.onclick = function() {
            modal_pass.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal_pass) {
                modal_pass.style.display = "none";
            }
        }
    });

    function changeNome(){
      $.ajax({
        url: '/changeNome',
        type: 'POST',
        dataType: 'json',
        success: 'success',
        data: {'nome': $('#novoNome').val(), '_token':'{{csrf_token()}}'},
        success: function(data){
            perfilAluno();
        }
      });
    }
    
    function changeEmail() {
        $.ajax({
            url: '/changeEmail',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'email': $('#novoEmail').val(), '_token':'{{csrf_token()}}'},
            success: function(data){
                perfilAluno();
            }
        });
    }

    function changePass() {
        $.ajax({
            url: '/changePass',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'novaPass': $('#novaPass').val(), '_token':'{{csrf_token()}}'},
            success: function(data){
                perfilAluno();
            }
        });
    }

    function checkPass(pass){
        var atualPass = bcrypt($('#atualPass').val());
        var novaPass = bcrypt($('#novaPass').val());
        var repNovaPass = bcrypt($('#repNovaPass').val());
        
        if(pass == atualPass){
            if(novaPass == repNovaPass){
                changePass();
            }else{
                var para = $(".pass").createElement("p");
                var node = document.createTextNode("Erro ao alterar a palavra passe.");
                para.appendChild(node);
                var element = document.getElementById("pass");
                element.appendChild(para);
            }
        } else{
            var para = $(".pass").createElement("p");
            var node = document.createTextNode("Erro ao alterar a palavra passe.");
            para.appendChild(node);
            var element = document.getElementById("pass");
            element.appendChild(para);
        }
        return aprovado;
    }
</script>
@endsection 