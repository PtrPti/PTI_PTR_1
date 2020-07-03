@extends('layouts.app_novo')

@section('content')

<div class="row-title breadcrums">
    
    
    <img class="img_profile" src="/images/{{ $user_info->avatar }}" width=10% style="position:fixed;  left:350px; border-radius: 50%;">
    <h2 class="nome_profile">{{Auth::user()->getUserName()}}</h2>
    <!-- <button class="btn btn-primary btn_perfil">{{ __('change.mudarImagemPerfil') }}</button> -->

    <form enctype="multipart/form-data" method="post" action="{{route('profile_update')}}" >
        
        <input type="file" name="avatar" class=" btn_update " >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-primary btn_update1" value="{{ __('change.mudarImagemPerfil') }}">
    </form>
</div>

<div class="informacao">
        @if (Auth::user()->isProfessor())
            <h5 class="t1">{{ __('change.estatuto') }}: {{ __('change.professor') }} </h5>
            <h5 class="tnum">{{ __('change.numDocente') }}: {{$user_info->numero}} </h5>

        @else
            <h5 class="t1">{{ __('change.estatuto') }}: {{ __('change.aluno') }} </h5>
            <h5 class="tnum">{{ __('change.numeroAluno') }}: {{$user_info->numero}} </h5>
                
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
                <td class="primeira_coluna_perfil">{{ __('change.nome') }}</td>
                <td>{{$user_info->nome}}</td>
                <td><button id="editNome"><img src="{{ asset('images/edit_perfil.png') }}" width=18px></button></td>
            </tr>
            <tr>
                <td class="primeira_coluna_perfil">E-mail</td>
                <td>{{$user_info->email}}</td>
                <td><button id="editEmail"><img src="{{ asset('images/edit_perfil.png') }}" width=18px></button></td>
            </tr>
            <tr>
                <td class="primeira_coluna_perfil">Password</td>
                <td>************</td>
                <td><button id="editPassword"><img src="{{ asset('images/edit_perfil.png') }}" width=18px></button></td>
            </tr>
        </table>

        <!-- Modal verde -->

        
        <div id="Nome" class="modal">
            <div  class="modal-content" id="changeUser">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('change.altereNome') }}</h6>
                    <span class="closeNome" style="margin-top: 5px;margin-right: 15px; cursor:pointer;">&times;</span>
                </div> 
               
                <div class="modal-body">
                    <form method="post" action="{{route('changeNome')}}">
                    {{csrf_field()}}
                    <div class="row group">
                        <div class="col-md-12">
                            <div>
                                <label for="nome" style="padding: 0px;margin-top: 5px;">{{ __('change.nome') }}</label><br>
                            </div>
                            <div>
                                <input type="text" id="novoNome" name="nome" style="width: 90%;" placeholder="{{$user_info->nome}}"><br>
                            </div>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type='submit' class="btn btn-primary "> {{ __('change.alterar') }}</button>
                           
                        </div>
                    </div>
            
                    </form>
                </div>
            </div>
        </div> 


        <div id="Email" class="modal">
            <div  class="modal-content" id="changeEmail">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('change.altereEmail') }}</h6>
                    <span class="closeEmail" style="margin-top: 5px;margin-right: 15px; cursor:pointer;">&times;</span>
                </div> 
               
                <div class="modal-body">
                    <form method="post" action="{{route('changeEmail')}}">
                    {{csrf_field()}}
                    <div class="row group">
                        <div class="col-md-12">
                            <div>
                                <label for="email" style="padding: 0px;margin-top: 5px;">Email</label><br>
                            </div>
                            <div>
                                <input type="email" name="email" id="novoEmail" style="width: 90%;" placeholder="{{$user_info->email}}"><br>
                            </div>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type='submit' class="btn btn-primary "> {{ __('change.alterar') }}</button>
                           
                        </div>
                    </div>
            
                    </form>
                </div>
            </div>
        </div> 


        <div id="Password" class="modal">
            <div  class="modal-content" id="changePass">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('change.altereSuaPalavraPasse') }}</h6>
                    <span class="closePass" style="margin-top: 5px;margin-right: 15px; cursor:pointer;">&times;</span>
                </div> 
               
                <div class="modal-body">
                    <form method="post" action="{{route('changePass')}}">
                    {{csrf_field()}}
                    <div class="row group">
                        <div class="col-md-12">
                            <div>
                                <label for="pass" style="padding: 0px;margin-top: 5px;" >{{ __('change.novaPalavraPasse') }}</label><br>
                            </div>
                            <div>
                                <input type="password" name="nova_pass" id="novaPass" style="width: 90%;" placeholder="************"><br>
                            </div>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <button type='submit' class="btn btn-primary "> {{ __('change.alterar') }}</button>
                           
                        </div>
                    </div>
            
                    </form>
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
   /*  function checkPass(pass){
        
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
    } */
</script>


@endsection