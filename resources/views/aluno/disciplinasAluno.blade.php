@extends('layouts.app_aluno')

@section('content')

<h3 class="disciplinaNome">{{$cadeira[0]->nome}}</h3>

<div class="pagDisciplina">
    <div class="navDisciplina">
        <button onclick="show_pagInicial()" class="pagInicial_btn"> Página inicial </button>
        <button onclick="show_avaliacao()" class="avaliacao_btn"> Avaliação </button>
        <button onclick="show_horarios()" class="horarios_btn"> Horários </button>
        <button onclick="show_trabalho()" class="trabalho_btn"> Trabalhos </buttons>
    </div>

    <div class="disciplinasAluno">
        <div class="pagInicial" id="outer">
            <div class="infDisciplina">
                    <h4 style="color:#e6e16c;"><b>Docentes</b></h4>
                    @foreach($docentes as $docente)
                    <div class="infDocentes">
                        <b>{{$docente->nome}}</b>
                        <p>{{$docente->email}}</p>
                    @endforeach
                </div>
                <a onclick="showForum({{$cadeira[0]->id}})" class="forumDuvidas_btn" ><img src="{{ asset('images/forum_icon.png') }}" width=15px style="margin-top: -4px;"> Fórum de dúvidas </a>
            </div>

            <div class="forumDuvidas">
            </div>
            
            <div class="divMensagens"> 
            </div>

            <div class="addMensagem">
                <div id="novaMensagem" class="modal">
                    <form action="/addMensagem" method="post"> 
                        {{csrf_field()}}
                        <!-- <input type="hidden" name="duvida_id" value="<?php/* echo $duvida*/ ?>"> -->
                        <input type="hidden" name="duvida_id">
                        <div class="novo_topico">
                            <span class="close">&times;</span>
                            <h4> Nova mensagem </h5><br>
                            <div class="row">
                                <div class="col-75">
                                    <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." style="height:200px"></textarea>
                                </div>
                            </div>
                            <div class="row">
                            <input class="novaMensagem" type="submit" value="Responder">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="avalDisciplina" id="outer">
            <a>Critérios de Avaliação</a>
        </div>

        <div class="horariosDisciplinas" id="outer">
            <a>Imagem com os horarios</a>
        </div>
        
        <div class="pagTrabalhos" id="outer">
            <div class="projetosDisciplina">
                @foreach ($cadeiraProjetos as $projeto)
                <div class="projeto">
                    <a style="text-transform: capitalize; font-size:16px" onclick="ShowGruposA({{$projeto->id}})">{{$projeto->nome}}</a><br>
                    <!-- <h4 style="text-transform: capitalize;">{{$projeto->nome}}</h4>           -->
                    <b>Data de entrega: </b>{{$projeto->data_fim}}  
                    <!-- <br>                
                    <button type="button" class="showGrupos" onclick="ShowGruposA({{$projeto->id}})"> Ver projeto </button> -->
                </div> 
                @endforeach 
            </div>

            <div class="infProjeto">
                <div class="inforcao_projeto">

                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
