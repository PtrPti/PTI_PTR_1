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
                <a class="taskadd"><img src="{{ asset('images/addtarefa.png') }}"width="40"><span>Adicionar Tarefa</span></a>
                <a class="taskSubadd"><img src="{{ asset('images/addtarefa.png') }}"width="40"><span>Adicionar Subtarefa</span></a>
				<a class="taskadd"><img src="{{ asset('images/edittarefa.png') }}"width="40"><span>Editar Tarefa</span></a>
				<hr>
				<a><img src="{{ asset('images/nota.png') }}" width="40"><span>Nota</span></a>
				<a><span>Evento</span></a>
			</div>
		</div>

        <!-- Popup Adicionar site/link -->
        <div id="all1" class="popUpBack">
			<div id="addSite">
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
                    </select>
                    <input type="text" name='nome' placeholder="nome...">
                    <input type="url" name='url' placeholder="URL...">
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}"><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Tarefa -->
		<div id="all2" class="popUpBack">
			<div id="addTarefa">
            <img class='closebtn' src="{{ asset('images/cancel.png') }}">
            <h4>Adicione uma Tarefa</h4>
                <form id='formAddTarefa'>
                    <label for='nT'>Nome: </label>
                    <input type="text" name='nome' id='nT' placeholder="tarefa..."><br>
                    <label for="tarefaPrincipal">Adicionar depois de:</label>
                    <select name='ordem' id='tarefaPrincipal' require>
                        <option disable >tarefas..</option>
                        @foreach ($tarefas as $tarefa)
                            @if (is_null($tarefa->tarefa_id))
                                <option value="{{$tarefa->ordem}}">{{$tarefa->nome}}</option>
                            @endif
                        @endforeach  
                    </select>
                    <label for='dtT'>Prazo: </label>
                    <input type="date" name='prazo' id='dtT' ><br>
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}"><br>
                    <input type="hidden" name='projetoId' value="{{$projeto->id}}"><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
        </div>

        <!-- Popup Adicionar Subtarefa -->
        <div id="all5" class="popUpBack">
			<div id="addSubTarefa">
            <img class='closebtn' src="{{ asset('images/cancel.png') }}">
            <h4>Adicione uma Subtarefa</h4>
                <form id='formAddSubTarefa'>
                    <label for='nT'>Nome: </label>
                    <input type="text" name='nome' id='nT' placeholder="tarefa..."><br>
        
                    <label for="slc">Tarefa principal:</label>
                    <select name='tarefaId' id='slc' require>
                        <option disable >tarefas</option>
                        @foreach ($tarefas as $tarefa)
                            @if (is_null($tarefa->tarefa_id))
                                <option value="{{$tarefa->id}}">{{$tarefa->nome}}</option>
                            @endif
                        @endforeach
                    </select><br>

                    <label for="oT2">Adicionar depois de:</label>
                    <select name='ordem' id='subtarefasId' require>
                        <option disable >subtarefas</option>
                    </select><br>

                    <label for='dtT2'>Prazo: </label>
                    <input type="date" name='prazo' id='dtT2' ><br>

                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}"><br>
                    <input type="hidden" name='projetoId' value="{{$projeto->id}}"><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Pasta -->
        <div id="all3" class="popUpBack">
			<div id="addPasta">
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <p>Adicione uma Pasta</p>
                <form id="formAddPasta">
                    <input type="text" name='nome' placeholder="nome...">
                    <input type="hidden" name='grupoId' value="{{ $IdGrupo }}"><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
        </div>
        
        <!-- Popup Adicionar Ficheiro -->
        <div id="all4" class="popUpBack">
			<div id="addPasta">
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <p>Adicione um Ficheiro</p>
                
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
                    </select>
                    <input type="file" name='ficheiro' placeholder="ficheiro...">
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
                                @if ( $subficheiro->link != "" )
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
            @elseif ( $ficheiro->is_folder === false and in_null($ficheiro->pasta_id))
                @if ( ! is_null($ficheiro->link) )
                    <a class="item2" href="{{$subficheiro->link}}">
                        @if (str_contains($ficheiro->link, 'drive.google.com'))
                            <img src="{{ asset('images/drive.png') }}" width="23">>
                        @elseif (str_contains($ficheiro->link, 'github.com'))
                            <img src="{{ asset('images/github.png') }}"  width="23">>
                        @else 
                            <img src="{{ asset('images/link.png') }}"  width="21">>
                        @endif
                        <span>{{$ficheiro->nome}}</span>
                    </a>
                @else
                    <a class="item2">
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
		<h3>Tarefas</h3>
		<div id="tarefas">
            @foreach ($tarefas as $tarefa)
                @if ($tarefa->tarefa_id === NULL)
                    <div class="divTarefa">
                        <label class="containerCheckbox">{{$tarefa->nome}}
                            <input type="checkbox" @if (($tarefa->estado)) checked @else '' @endif >
                            <input type="hidden" value="{{$tarefa->id}}">
                            <span class="checkmark"></span>
                        </label>
                    @foreach ($tarefas as $subtarefa)
                        @if ($subtarefa->tarefa_id === $tarefa->id)
                        <div class="divSubTarefa">
                            <label class="containerCheckbox2">{{$subtarefa->nome}}
                                
                                <input type="checkbox" @if (($subtarefa->estado)) checked @else '' @endif >
                                <input type="hidden" value="{{$subtarefa->id}}">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @endif
                    @endforeach  
                    </div>
                @endif
            @endforeach  
        </div>
        <button class="calendarBtn" onclick="ShowCalendar()"><i class="far fa-calendar-alt fa-3x"></i></button>

        <div id='calendarContainer'>
            <div id='external-events'>
                <h4>Elementos do grupo</h4>
                <div id='external-events-list'>
                    @foreach ($users_grupo as $ug)
                        <?php $r = rand(0,255); $g = rand(0,255); $b = rand(0,255) ?>
                        <!-- @if (Auth::user()->getUserId() == $ug->user_id) 
                            <div class='fc-event draggable' data-color="rgb({{$r}}, {{$g}}, {{$b}})" style="background-color: rgb({{$r}}, {{$g}}, {{$b}}); border-color: rgb({{$r}}, {{$g}}, {{$b}})">{{ $ug->nome }}</div>
                        @else
                            <div class='fc-event undraggable' data-color="rgb({{$r}}, {{$g}}, {{$b}})" style="background-color: rgb({{$r}}, {{$g}}, {{$b}}); border-color: rgb({{$r}}, {{$g}}, {{$b}})">{{ $ug->nome }}</div>
                        @endif -->
                        
                        @if (Auth::user()->getUserId() == $ug->user_id) 
                            <div class='fc-event draggable'>{{ $ug->nome }}</div>
                        @else
                            <div class='fc-event undraggable'>{{ $ug->nome }}</div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div id='calendar'></div>

            <div style='clear:both'></div>

        </div>
    </div>
</div>
</div>

<script>

    $("#dropAdd").hide();
    $('div',".folder1").hide();
    $(".popUpBack").hide();

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

    $('#slc').on('change', function() {
        var id = this.value
        $.ajax({
            url: '/subTarefas',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'tarefaId': id},
            success: function(data){
                
                $('#subtarefasId').append(data)}
        });
    });

    function editTarefa(id, val) {
        $.ajax({
            url: '/editTarefa',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'val': val, 'id': id},
            success: function(data){alert(data)}
        });
    }

    function editAllTarefa(id, val) {
        $.ajax({
            url: '/editAllTarefa',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'val': val, 'id': id},
            success: function(data){alert(data)}
        });
    }

    $("#formAddPasta").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addPasta',
            type: 'GET',
            data : form_data
        }).done(function(response){ //
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
        }).done(function(response){ //
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
        }).done(function(response){ //
            location.reload();
        });
    });

    $(".containerCheckbox input").click(function() {
        if ($(this).is(':checked')) {
            editAllTarefa( $(this).next().val(), true)
            $('.divSubTarefa input',($(this).parent()).parent()).prop('checked', true)
        } else{
            editAllTarefa( $(this).next().val(), false)
            $('.divSubTarefa input',($(this).parent()).parent()).prop('checked', false)
        }
    });

    $(".divSubTarefa input").click(function() {
        if ($(this).is(':checked')) {
            editTarefa( $(this).next().val(), true)
        } else{
            editTarefa( $(this).next().val(), false)
        }
        var numSubTarefas = $('input',($(this).parent()).parent()).length
        var numSubTChecked = $('input:checked',($(this).parent()).parent()).length
        if ( numSubTarefas == numSubTChecked ){
            editTarefa( $('.containerCheckbox input',(($(this).parent()).parent()).parent()).next().val() , true)
            $('.containerCheckbox input',(($(this).parent()).parent()).parent()).prop('checked', true);
        } else {
            editTarefa( $('.containerCheckbox input',(($(this).parent()).parent()).parent()).next().val() , false)
            $('.containerCheckbox input',(($(this).parent()).parent()).parent()).prop('checked', false)
        }  
    }); 

</script>

@endsection