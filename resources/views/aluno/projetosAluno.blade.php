@extends('layouts.app_aluno')

@section('content')

<div class=pagProjeto>
    <h1>{{$projeto->nome}}  |  Grupo Nº{{$grupo->numero}}  <small>  {{$disciplina->nome}}</small></h1>
    @foreach ($nomesUsers as $nome)
        <h2>{{$nome->nome}}</h2>
    @endforeach  
    
</div>

<div id='esqdrt'>
    <div id="esq">

        <div id="divAdd">
			<button id="btnAdd" ><img src="{{ asset('images/plus.png') }}" width="23"><span>Adicionar</span></button>
			<div id="dropAdd">

                <a class="pastaadd" ><img src="{{ asset('images/addpasta.png') }}" width="40"><span>Pasta</span></a>
				
                <hr>
                <a class="uploadFile" ><img src="{{ asset('images/uploadficheiro.png') }}" width="40"><span>Carregar Ficheiro</span></a>
				
				<label class="addLabel"><img src="{{ asset('images/uploadpasta.png') }}" width="40">Carregar Pasta
					<input type="file">
				</label>
				<hr>

				<a class="siteadd"><img src="{{ asset('images/link.png') }}" width="37"><span>Site</span></a>
				<a class="siteadd"><img src="{{ asset('images/drive.png') }}" width="37"><span>Google Drive</span></a>
				<a class="siteadd"><img src="{{ asset('images/github.png') }}" width="37"><span>Github</span></a>
				<hr>
                <a class="taskadd"><img src="{{ asset('images/addtarefa.png') }}"width="40"><span>Tarefa</span></a>
                <a class="taskSubadd"><img src="{{ asset('images/addtarefa.png') }}"width="40"><span>Subtarefa</span></a>
				<hr>
				<a class="notaAdd"><img src="{{ asset('images/nota.png') }}" width="40"><span>Nota</span></a>
				<a><span>Evento</span></a>
			</div>
		</div>

        <!-- Popup Adicionar site/link -->
        <div id="all1" class="popUpBack">
			<div id="addSite" class='popupDiv'>
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <h4>Adicione um Link</h4>
                <form id="formAddLink">
                    <label for="p">Pasta</label>
                    <select name='Pasta' id='p'>
                        <option value=''>Nenhuma</option>
                        @foreach ($ficheiros as $ficheiro)
                            @if ($ficheiro->is_folder)
                                <option value="{{$ficheiro->id}}">{{$ficheiro->nome}}</option>
                            @endif
                        @endforeach  
                    </select><br>
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="url" name='url' placeholder="URL..."><br>
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}"><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Tarefa -->
		<div id="all2" class="popUpBack">
			<div id="addTarefa" class='popupDiv'>
            <img class='closebtn' src="{{ asset('images/cancel.png') }}">
            <h4>Adicione uma Tarefa</h4>
                <form id='formAddTarefa'>
                    <label for='nT'>Nome: </label>
                    <input type="text" name='nome' id='nT' placeholder="tarefa..."><br>
                    <label for="tarefaPrincipal">Adicionar:</label>
                    <select name='ordem' id='tarefaPrincipal' require>
                        <option value="0" >Inicio</option>
                        @foreach ($tarefas as $tarefa)
                            @if (is_null($tarefa->tarefa_id))
                                <option value="{{$tarefa->ordem}}">Depois de: {{$tarefa->nome}}</option>
                            @endif
                        @endforeach  
                    </select><br>
                    <label for='dtT'>Prazo: </label>
                    <input type="date" name='prazo' id='dtT' ><br>
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}">
                    <input type="hidden" name='projetoId' value="{{$projeto->id}}">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
        </div>

        <!-- Popup Adicionar Subtarefa -->
        <div id="all5" class="popUpBack">
			<div id="addSubTarefa" class='popupDiv'>
            <img class='closebtn' src="{{ asset('images/cancel.png') }}">
            <h4>Adicione uma Subtarefa</h4>
                <form id='formAddSubTarefa'>
                    <label for='nT'>Nome: </label>
                    <input type="text" name='nome' id='nT' placeholder="tarefa..."><br>
        
                    <label for="slc">Tarefa principal:</label>
                    <select name='tarefaId' id='slc' require>
                        @foreach ($tarefas as $tarefa)
                            @if (is_null($tarefa->tarefa_id))
                                <option value="{{$tarefa->id}}">{{$tarefa->nome}}</option>
                            @endif
                        @endforeach
                    </select><br>

                    <label for="oT2">Adicionar: </label>
                    <select name='ordem' id='subtarefasId' require>
                        <option value="0" >Inicio</option>
                    </select><br>

                    <label for='dtT2'>Prazo: </label>
                    <input type="date" name='prazo' id='dtT2' ><br>

                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}">
                    <input type="hidden" name='projetoId' value="{{$projeto->id}}">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Pasta -->
        <div id="all3" class="popUpBack" >
			<div id="addPasta" class='popupDiv'>
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <h4>Adicione uma Pasta</h4>
                <form id="formAddPasta">
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
        </div>
        
        <!-- Popup Adicionar Ficheiro -->
        <div id="all4" class="popUpBack">
			<div id="addPasta" class='popupDiv'>
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <h4>Adicione um Ficheiro</h4>
                
                <form id="formUploadFicheiro" action="{{route ('uploadFicheiro')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label for="pasta">Pasta</label>
                    <select name='Pasta' id="pasta">
                        <option value=''>Nenhuma</option>
                        @foreach ($ficheiros as $ficheiro)
                            @if ($ficheiro->is_folder)
                                <option value="{{$ficheiro->id}}">{{$ficheiro->nome}}</option>
                            @endif
                        @endforeach  
                    </select><br>
                    <input type="file" name='ficheiro' placeholder="ficheiro...">
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Nota -->
        <div id="all6" class="popUpBack">
            <div id="addNota" class='popupDiv'>
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <h4>Adicione uma Nota</h4>
                <form id="formAddNotaGrupo">
                    <label for="pastaaa">Pasta</label>
                    <select name='Pasta' id='pastaaa'>
                        <option value=''>Nenhuma</option>
                        @foreach ($ficheiros as $ficheiro)
                            @if ($ficheiro->is_folder)
                                <option value="{{$ficheiro->id}}">{{$ficheiro->nome}}</option>
                            @endif
                        @endforeach  
                    </select><br>
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}"><br>
				    <input type="submit" value='Adicionar'>
                </form>
            </div>
        </div>

        <!-- Lado esquerdo - pastas e ficheiros -->
        <div id="esqcontainer">
        @foreach ($ficheiros as $ficheiro)
            @if ($ficheiro->is_folder)
                <div class="folder1">
                    <a class="item1"><img src="{{ asset('images/folder.png') }}" width="25"><span>{{$ficheiro->nome}}</span></a>
                    @foreach ($ficheiros as $subficheiro)
                        @if ($subficheiro->pasta_id === $ficheiro->id)
                            <div class="folder2">
                                @if ( $subficheiro->link != "" and is_null($subficheiro->notas))
                                    <a class="item2" href="{{$subficheiro->link}}">
                                        @if (str_contains($subficheiro->link, 'drive.google.com'))
                                            <img src="{{ asset('images/drive.png') }}" width="23">
                                        @elseif (str_contains($subficheiro->link, 'github.com'))
                                            <img src="{{ asset('images/github.png') }}" width="23">
                                        @else 
                                            <img src="{{ asset('images/link.png') }}" width="21">
                                        @endif
                                        <span>{{$subficheiro->nome}}</span> 
                                    </a>
                                @elseif ( ! is_null($subficheiro->notas) )
                                    <a class="item2" href="#" onclick="infoNota('grupo',{{$subficheiro->id}})">
                                        <img src="{{ asset('images/nota.png') }}" width="23">
                                        <span>{{$subficheiro->nome}}</span>
                                    </a> 
                                @else
                                    <a class="item2" href="{{ url('/downloadF', $subficheiro->id.'.'.explode('.', $subficheiro->nome, 2)[1]) }}">
                                        <img src="{{ asset('images/file.png') }}" width="25">
                                        <span>{{$subficheiro->nome}}</span>
                                    </a> 
                                @endif
                            </div>
                        @endif
                    @endforeach      
                </div>
            @elseif ( $ficheiro->is_folder == false and is_null($ficheiro->pasta_id))
                @if ( ! is_null($ficheiro->link) and is_null($ficheiro->notas))
                    <a class="item1" href="{{$subficheiro->link}}">
                        @if (str_contains($ficheiro->link, 'drive.google.com'))
                            <img src="{{ asset('images/drive.png') }}" width="23">
                        @elseif (str_contains($ficheiro->link, 'github.com'))
                            <img src="{{ asset('images/github.png') }}"  width="23">
                        @else 
                            <img src="{{ asset('images/link.png') }}"  width="21">
                        @endif
                        <span>{{$ficheiro->nome}}</span>
                    </a>
                @elseif ( ! is_null($ficheiro->notas) )
                    <a class="item1" href="#"  onclick="infoNota('grupo',{{$ficheiro->id}})">
                        <img src="{{ asset('images/nota.png') }}" width="23">
                        <span>{{$ficheiro->nome}}</span>
                    </a> 
                @else
                    <a class="item1">
                        <img src="{{ asset('images/file.png') }}" width="25">>
                        <span>{{$ficheiro->nome}}</span>
                    </a>
                @endif
            @endif
        @endforeach  	
                    
    </div>
    </div>
    
    <!-- Lado direito - Tarefas -->
	<div id="drt">
		<div id="tarefas">

            <!-- view tarefasAluno -->
            @include('aluno.tarefasAluno')
            
        </div>
    </div>
</div>
</div>

<!-- Nota -->

<div id="notaa">

    <!-- view nota -->
    @include('aluno.notaAluno')

<div>


<script>
    $(document).ready(function(){
        if(<?php echo $tarefaId ?> > 0){
            infoTarefa(<?php echo $tarefaId ?>);
            $('#allEditT').show();
        }
    });
    
    $("#dropAdd").hide();
    $('div',".folder1").hide();
    $(".popUpBack").hide();
    $('#mydiv').hide();

    $(".siteadd").click(function(){
        $("#all1").show();
    }); 

    $(".taskadd").click(function(){
        $("#all2").show();
    });

    $(".pastaadd").click(function(){
        $("#all3").show();
    }); 
    
    $(".uploadFile").click(function(){
        $("#all4").show();
    }); 

    $(".notaAdd").click(function(){
        $("#all6").show();
    }); 

    $(".taskSubadd").click(function(){
        $("#all5").show();
    });

    $(".closebtn").click(function(){
        ($($(this).parent()).parent()).hide();
    });

    $(document).mouseup(function(e){
        var container = $("#dropAdd");
        if (!container.is(e.target) && container.has(e.target).length === 0){
            container.hide();
        }
    });

    $("#btnAdd").click(function(){
        $("#dropAdd").show();
    }); 

    $('.folder1 .item1').click(function() {
        if ($('a img', $(this).parent()).attr("src") == "{{ asset('images/folder.png') }}") {
            $('img:first',$(this).parent()).attr("src","{{ asset('images/openfolder.png') }}");
            $('div',$(this).parent()).show();  
        } else  {
            $('img:first',$(this).parent()).attr("src","{{ asset('images/folder.png') }}");
            $('div',$(this).parent()).hide();
        }
    });

    jQuery(function($) {
        $('#slc').on('change', function() {
            var id = this.value
            $.ajax({
                url: '/subTarefas',
                type: 'GET',
                dataType: 'json',
                success: 'success',
                data: {'tarefaId': id},
                success: function(data){
                    $('#subtarefasId').html(data)
                }
            });
        }).change();
    });

    $("#formAddPasta").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addPasta',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    $("#formAddNotaGrupo").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addNotaGrupo',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    $("#formAddSubTarefa").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addSubTarefa',
            type: 'GET',
            data : form_data
        }).done(function(response){
            location.reload();
        });
    });
    
     $("#formAddLink").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/addLink',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    $("#formAddTarefa").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/addTarefa',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    function infoNota(tipo,id){
        $.ajax({
            url: '/infoNota',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data : {'tipo': tipo, 'id':id},
            success: function(data){
                $('#notaa').html(data.html);
                $('#notaa').show();
            }
        })
    }

</script>

@endsection