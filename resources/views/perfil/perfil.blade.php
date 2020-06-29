@extends('layouts.app_novo')

@section('content')

<div class="row-title breadcrums">
    
    
    <img class="img_profile" src="{{ asset('images/perfil_page.svg') }}" width=10% style="position:fixed; top:40px; left:350px;">
    <h2 class="nome_profile">{{Auth::user()->getUserName()}}</h2>
    <button class="btn btn-primary btn_perfil">{{ __('change.mudarImagemPerfil') }}</button>
</div>

<div class="informacao">
        @if (Auth::user()->isProfessor())
            <h5 class="t1">{{ __('change.estatuto') }}: {{ __('change.professor') }} </h5>
            
            <h5 class="tnum">{{ __('change.numDocente') }}: {{Auth::user()->numero}} </h5>

        @else
            <h5 class="t1">{{ __('change.estatuto') }}: {{ __('change.aluno') }} </h5>
            <h5 class="tnum">{{ __('change.numeroAluno') }}: {{Auth::user()->numero}} </h5>
        @endif

</div>



<div class="nav-tabs_perfil">
    @if (Auth::user()->isAluno())
        <div class="tab_perfil tab_perfil-active" id="tab_perfil1" onclick="changeTab_perfil(1)">{{ __('change.sobre') }}</div>
        <div class="tab_perfil" id="tab_perfil2" onclick="changeTab_perfil(2)"> {{ __('change.pontos') }} </div>
        <div class="tab_perfil" id="tab_perfil3" onclick="changeTab_perfil(3)"> {{ __('change.gerirConta') }} </div>

        @else 
        <div class="tab_perfil tab_perfil-active" id="tab_perfil1" onclick="changeTab_perfil(1)">{{ __('change.sobre') }}</div>
        <div class="tab_perfil" id="tab_perfil2" onclick="changeTab_perfil(3)"> {{ __('change.gerirConta') }} </div>
    @endif
    
</div>


<div class="tab-container_perfil" id="tab_perfil-1">
    <h5 class="t2">{{ __('change.disciplinas') }}: </h5>
        @foreach($disciplinas as $disciplina)
        <a href="{{route('disciplina', ['id' => $disciplina->id])}}" class="t3"><ul> {{$disciplina->nome}} </ul></a>
        @endforeach

</div>

<div class="tab-container_perfil" id="tab_perfil-2">
{{ __('change.pontos') }}
</div>

<div class="tab-container_perfil" id="tab_perfil-3">
<div class="infPerfil">
        <h3 style="text-align:center; color: #636b6f;padding: 0 35px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">
        {{ __('change.gerirConta') }}</h3>

        <table class="tablePerfil">
           
            <tr>
                <td class="primeira_coluna">{{ __('change.nome') }}</td>
                <td>{{$user->nome}}</td>
                <td><button id="editNome"><img src="{{ asset('images/edit_perfil.png') }}" width=18px></button></td>
            </tr>
            <tr>
                <td class="primeira_coluna">E-mail</td>
                <td>{{$user->email}}</td>
                <td><button id="editEmail"><img src="{{ asset('images/edit_perfil.png') }}" width=18px></button></td>
            </tr>
            <tr>
                <td class="primeira_coluna">Password</td>
                <td>************</td>
                <td><button id="editPassword"><img src="{{ asset('images/edit_perfil.png') }}" width=18px></button></td>
            </tr>
        </table>

        <!-- Modal verde -->

        <form method="post" action="{{route('changeNome')}}">
            {{csrf_field()}}
            <div id="Nome" class="modal">

                <div class="modal-content" id="changeUser">
                    <span class="closeNome" style="margin-top: 5px;margin-right: 15px;">&times;</span>
                    <h3>{{ __('change.altereNome') }}</h3>
                    <div style="display: grid;grid-template-columns: 20% 80%;margin-top: 18px;">
                        <div>
                            <label for="nome" style="padding: 0px;margin-top: 5px;">{{ __('change.nome') }}</label><br>
                        </div>
                        <div>
                            <input type="text" id="novoNome" name="nome" style="width: 90%;" placeholder="{{$user->nome}}"><br>
                        </div>
                        <button type='submit' > {{ __('change.alterar') }}</button>
                    </div>
                </div>
            </div>
        </form> 
        <form method="post" action="{{route('changeEmail')}}">
            {{csrf_field()}}
            <div id="Email" class="modal">
                <div class="modal-content" id="changeEmail">
                    <span class="closeEmail" style="margin-top: 5px;margin-right: 15px;">&times;</span>
                    <h3>{{ __('change.altereEmail') }}</h3>
                    <div style="display: grid;grid-template-columns: 20% 80%;margin-top: 18px;">
                        <div>
                            <label for="email" style="padding: 0px;margin-top: 5px;">Email</label><br>
                        </div>
                        <div>
                            <input type="email" name="email" id="novoEmail" style="width: 90%;" placeholder="{{$user->email}}"><br>
                        </div>
                        <button type='submit'>{{ __('change.alterar') }}</button>
                    </div>
                </div>
            </div>
        </form> 
            
        <div id="Password" class="modal">
            <form method="post" action="{{route('changePass')}}">
                {{csrf_field()}}
                <div class="modal-content" id="changePass">
                    <span class="closePass" style="margin-top: 5px;margin-right: 15px;">&times;</span>
                    <h3>{{ __('change.altereSuaPalavraPasse') }}</h3>
                    <div style="display: grid;grid-template-columns: 40% 60%;margin-top: 18px;">
                        <div>
                            <label for="pass" style="padding: 0px;margin-top: 5px;">{{ __('change.palavraPasseAtual') }}</label><br>
                        </div>
                        <div>
                            <input type="password" name="old_pass" id="atualPass" style="width: 90%;" placeholder="************"><br>
                        </div>
                        <div>
                            <label for="pass" style="padding: 0px;margin-top: 5px;" >{{ __('change.novaPalavraPasse') }}</label><br>
                        </div>
                        <div>
                            <input type="password" name="nova_pass" id="novaPass" style="width: 90%;" placeholder="************"><br>
                        </div>
                        <div>
                            <label for="pass" style="padding: 0px;margin-top: 5px;">{{ __('change.repetirPassword') }}</label><br>
                        </div>
                        <div>
                            <input type="password" id="repNovaPass" name="nova_pass2" style="width: 90%;" placeholder="************"><br>
                        </div>
                        <button type='submit'>{{ __('change.alterar') }}</button>
                        <div class="pass">
                            
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </div>
</div>
</div>



<script>

$(document).ready(function () {
        changeTab(<?php echo $active_tab ?>);
    });

    



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
            perfilDocente();
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
                perfilDocente();
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
                perfilDocente();
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