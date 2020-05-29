<!-- Tarefas por fazer -->
<div id="tarefasNaoFeitas">
    <h3>Tarefas</h3>

    <!-- Procura -->
    <div class="searchcontainer">
        <form id="formpesquisa">
            <input type="text" placeholder="Pesquisar.." title="Pesquise por Aluno ou Tarefa" name="palavra">
            <input type="hidden" name='grupoId' value="{{$IdGrupo}}">
            <button type="submit"><img class='psq' src="{{ asset('images/pesquisa.png') }}" width="20"></button>
        </form>
    </div>
    @foreach ($tarefas as $tarefa)
        @if ($tarefa->tarefa_id === NULL and $tarefa->estado == false) 
            <div class="divTarefa">
                <img class='tarefaSeta' src="{{ asset('images/more.png') }}" width="20">
                <div class='tarefa'>
                    <label class="containerCheckbox">{{$tarefa->nome}}
                        <input type="checkbox" @if (($tarefa->estado)) checked @else '' @endif >
                        <input type="hidden" value="{{$tarefa->id}}">
                        <span class="checkmark"></span>
                    </label>
                    <img src="{{asset('images/edit.png') }}" class='editTarefa' width="15">

                    <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                    <div class="ficheirosTarefa">
                        @if ( $tarefa->notas !== NULL)
                            <div class='notaTarefa'><img src="{{asset('images/nota.png') }}" width="20"></div>
                        @endif  
                        @foreach ($ficheirosTarefas as $ficheiro)
                            @if ($tarefa->id === $ficheiro->tarefa_id)
                                @if ( empty($ficheiro->link) )
                                    <div class='ficheiroTarefa'><img src="{{asset('images/fileq.png') }}" title="{{$ficheiro->nome}}" width="20"></div>
                                @else 
                                    <div class='linkTarefa'>
                                        <a class='linkTarefa'  href="{{$ficheiro->link}}" target="_blank">
                                        <img src="{{asset('images/link.png') }}" title="{{$ficheiro->nome}}" width="20"></a>
                                    </div>
                                @endif 
                            @endif  
                        @endforeach 
                        @if (!empty($tarefa->user_id))
                            @foreach ($nomesUsers as $user)
                                @if ($tarefa->user_id === $user->id)
                                    <div class='nameUser'><span>{{$user->nome}}</span></div>
                                @endif  
                            @endforeach 
                        @endif
                    </div>
                    
                </div>
                <div class="divSubTarefa">
                @foreach ($tarefas as $subtarefa)
                    @if ($subtarefa->tarefa_id === $tarefa->id)
                        <div class='tarefa'>
                            <label class="containerCheckbox2">{{$subtarefa->nome}}
                                <input type="checkbox" @if (($subtarefa->estado)) checked @else '' @endif >
                                <input type="hidden" value="{{$subtarefa->id}}">
                                <span class="checkmark"></span>
                            </label>
                            <img src="{{asset('images/edit.png') }}" class='editTarefa' width="15">

                            <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                            <div class="ficheirosTarefa">
                                @if ($subtarefa->notas !== NULL)
                                    <div class='notaTarefa'><img src="{{asset('images/nota.png') }}" width="20"></div>
                                @endif  
                                @foreach ($ficheirosTarefas as $ficheiro)
                                    @if ($subtarefa->id === $ficheiro->tarefa_id)
                                        @if ( empty($ficheiro->link) )
                                            <div class='ficheiroTarefa'><img src="{{asset('images/fileq.png') }}" title="{{$ficheiro->nome}}" width="20"></div>
                                        @else 
                                            <div class='linkTarefa'>
                                                <a class='linkTarefa'  href="{{$ficheiro->link}}" target="_blank">
                                                <img src="{{asset('images/link.png') }}" title="{{$ficheiro->nome}}" width="20"></a>
                                            </div>
                                        @endif 
                                    @endif  
                                @endforeach 
                                @if (!empty($subtarefa->user_id))
                                    @foreach ($nomesUsers as $user)
                                        @if ($subtarefa->user_id === $user->id)
                                            <div class='nameUser'><span>{{$user->nome}}</span></div>
                                        @endif  
                                    @endforeach 
                                @endif
                            </div>

                        </div>
                    @endif
                @endforeach  
                </div>
            </div>
        @endif
    @endforeach  
</div>

<!-- Tarefas feitas -->
<div id="tarefasFeitas">
    <br><br><br>
    @foreach ($tarefas as $tarefa)
        @if ($tarefa->tarefa_id === NULL and $tarefa->estado) 
            <div class="divTarefa">
                <img class='tarefaSeta' src="{{ asset('images/more.png') }}" width="20">
                <div class='tarefa'>
                    <label class="containerCheckbox">{{$tarefa->nome}}
                        <input type="checkbox" @if (($tarefa->estado)) checked @else '' @endif >
                        <input type="hidden" value="{{$tarefa->id}}">
                        <span class="checkmark"></span>
                    </label>

                    <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                    <div class="ficheirosTarefa">
                        @if ($tarefa->notas !== NULL)
                            <div class='notaTarefa'><img src="{{asset('images/nota.png') }}" width="20"></div>
                        @endif  
                        @foreach ($ficheirosTarefas as $ficheiro)
                            @if ($tarefa->id === $ficheiro->tarefa_id)
                                @if ( empty($ficheiro->link) )
                                    <div class='ficheiroTarefa'><img src="{{asset('images/fileq.png') }}" width="20"></div>
                                @else 
                                    <div class='linkTarefa'>
                                        <a class='linkTarefa'  href="{{$ficheiro->link}}" target="_blank">
                                        <img src="{{asset('images/link.png') }}" title="{{$ficheiro->nome}}" width="20"></a>
                                    </div>
                                @endif 
                            @endif  
                        @endforeach 
                        @if (!empty($tarefa->user_id))
                            @foreach ($nomesUsers as $user)
                                @if ($tarefa->user_id === $user->id)
                                    <div class='nameUser'><span>{{$user->nome}}</span></div>
                                @endif  
                            @endforeach 
                        @endif
                    </div>

                </div>
                <div class="divSubTarefa">
                @foreach ($tarefas as $subtarefa)
                    @if ($subtarefa->tarefa_id === $tarefa->id)
                        <div class='tarefa'>
                            <label class="containerCheckbox2">{{$subtarefa->nome}}
                                <input type="checkbox" @if (($subtarefa->estado)) checked @else '' @endif >
                                <input type="hidden" value="{{$subtarefa->id}}">
                                <span class="checkmark"></span>
                            </label>

                            <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                            <div class="ficheirosTarefa">
                                @if ( $subtarefa->notas !== NULL )
                                    <div class='notaTarefa'><img src="{{asset('images/nota.png') }}" width="20"></div>
                                @endif  
                                @foreach ($ficheirosTarefas as $ficheiro)
                                    @if ($subtarefa->id === $ficheiro->tarefa_id)
                                        @if ( empty($ficheiro->link) )
                                            <div class='ficheiroTarefa'><img src="{{asset('images/fileq.png') }}" width="20"></div>
                                        @else 
                                            <div class='linkTarefa'>
                                                <a class='linkTarefa'  href="{{$ficheiro->link}}" target="_blank">
                                                <img src="{{asset('images/link.png') }}" title="{{$ficheiro->nome}}" width="20"></a>
                                            </div>
                                        @endif 
                                    @endif  
                                @endforeach 
                                @if (!empty($subtarefa->user_id))
                                    @foreach ($nomesUsers as $user)
                                        @if ($subtarefa->user_id === $user->id)
                                            <div class='nameUser'><span>{{$user->nome}}</span></div>
                                        @endif  
                                    @endforeach 
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach  
                </div>
            </div>
        @endif
    @endforeach  
</div>

<!-- Popup Editar Tarefa -->
<div id="allEditT" class="popUpBack">

    <!-- view editarTarefa -->
    @include('aluno.editarTarefa')

</div>


<script>

     $('#allEditT').hide();

    $('.divTarefa').each(function( index, element ) {
        if ($(".divSubTarefa .tarefa .containerCheckbox2", this).length > 0){ 
            $( '.tarefaSeta' , element ).css( 'opacity', '1' );
        } else{
            $( '.tarefaSeta' , element ).css( 'opacity', '0' );
            $( '.tarefaSeta' , element ).css( 'cursor', 'default');
        }
    });

    $(".tarefa").hover(function(){
        $('.editTarefa' , this ).css("display", "inline-block");
        }, function(){
        $('.editTarefa' , this ).css("display", "none");
    }); 
    
    $('.divSubTarefa').addClass('visSub');

    $('.tarefaSeta').click(function() {
        $(this).toggleClass('flip');
        $('.divSubTarefa', $(this).parent()).toggleClass('visSub');
    });

    $('.editTarefa').click(function() {
        infoTarefa($('input[type=hidden]',$(this).parent()).val());
        $('#allEditT').show();
    });

    $("#formpesquisa").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/pesquisar',
            type: 'GET',
            data : form_data,
            success: function(data){
                $('#tarefas').html(data.html)
            }
        });
    });

    // Informacao para editar a tarefa
    function infoTarefa(id) {
        $.ajax({
            url: '/infoTarefa',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id },
            success: function(data){
                $('#allEditT').html(data.html)  
            }
        });
    }

    // Adiconar tarefa
    function editTarefa(id, val) {
        $.ajax({
            url: '/editTarefa',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'val': val },
            success: function(data){
                $('#tarefas').html(data.html) 
            }
        });
    }

    // Adiconar tarefa
    function editAllTarefa(id, val) {
        $.ajax({
            url: '/editAllTarefa',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'val': val, 'id': id},
            success: function(data){
                $('#tarefas').html(data.html)
            }
        });
    }

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
        var numSubTarefas = $('input[type=checkbox]',(($(this).parent()).parent()).parent()).length
        var numSubTChecked = $('input:checked',(($(this).parent()).parent()).parent()).length

        if ( numSubTarefas == numSubTChecked ){
            editTarefa( $('.containerCheckbox input',((($(this).parent()).parent()).parent()).parent()).next().val() , true)
            $('.containerCheckbox input',((($(this).parent()).parent()).parent()).parent()).prop('checked', true);
        } else {
            editTarefa( $('.containerCheckbox input',((($(this).parent()).parent()).parent()).parent()).next().val() , false)
            $('.containerCheckbox input',((($(this).parent()).parent()).parent()).parent()).prop('checked', false)
        }  
    }); 

</script>
