@isset($tarefaEdit, $fichTarefa)
<div id="editTarefa" class='popupDiv'>
   
    <img class='closebtn' src="{{asset('images/cancel.png') }}" >

    <div id='btnsAddEdit'>
        <div id='btnEdit'><span>Editar</span></div>  
        <div id='btnAdici'><span>Adicionar</span></div>  
    </div><br> 
    
    <div id='editarFicheiro'>
        <form id='formEditTarefa'>
            <label for='nomeTarefa'>Nome tarefa: </label>
            <input type="text" name='nome' id='nomeTarefa' value="{{$tarefaEdit[0]->nome}}"><br>

            <label for='prazo'>Prazo: </label>
            <input type="date" name='prazo' id='prazo' value="{{ date('l jS F Y H:i', strtotime($tarefaEdit[0]->prazo)) }}" ><br>

            <label for="aluno">Atribuir a: </label>
            <select name='alunoId' id='aluno' require>
                <option value="0" >-------------</option>
                @foreach ($nomesUsers as $user)
                    @if ($user->id === $tarefaEdit[0]->user_id)
                        <option value="{{$user->id}}" selected>{{$user->nome}}</option>
                    @else
                        <option value="{{$user->id}}" >{{$user->nome}}</option>
                    @endif
                @endforeach
            </select><br>
            <input type="hidden" name='tarefaId' value="{{ $tarefaEdit[0]->id }}">
            <input type="submit" value='Guardar'>
        </form>
        
            @if( $tarefaEdit[0]->notas !== NULL )
                <div class='elmFicheiro'>
                    <img src="{{asset('images/nota.png') }}" width="20">
                    <span>Nota</span>
                    <img class='eliminarFich' src="{{asset('images/lixo.png') }}" width="20" onclick="eliminarFicheiro( 0, {{ $tarefaEdit[0]->id }} )">
                </div>
            @endif

            @foreach ($fichTarefa as $fich)
                @if (empty ($fich->link))
                    <div class='elmFicheiro'>
                        <img src="{{asset('images/fileq.png') }}" width="20">
                        <span>{{$fich->nome}}</span>
                        <img class='eliminarFich' src="{{asset('images/lixo.png') }}" width="20" onclick="eliminarFicheiro( {{$fich->id}} , {{ $tarefaEdit[0]->id }})">
                    </div>
                @else
                    <div class='elmFicheiro'>
                        <img src="{{asset('images/link.png') }}" width="20"></a>
                        <span>{{$fich->nome}}</span>
                        <img class='eliminarFich' src="{{asset('images/lixo.png') }}" width="20" onclick="eliminarFicheiro( {{$fich->id}} , {{ $tarefaEdit[0]->id }})">
                    </div>
                @endif
            @endforeach
        
    </div>

    <div class='adicionarFicheiro'>

        <label for="addF">Adicionar: </label>
        <select name='adicionar' id='addF'>
            @if( $tarefaEdit[0]->notas === NULL)
            <option value="" >Nota</option>
            @endif
            <option value="">Link</option>
            <option value="" >Ficheiro</option>
        </select><br>

        <div>
            <form id='formAddNotaTarefa'>
                <input type="text" name='nome' placeholder="nome.."><br>
                <input type="hidden" name='tarefaId' value="{{ $tarefaEdit[0]->id }}">
                <input type="hidden" name='tipo' value="tarefa">
            </form>
        </div>

        <div>
            <form id="formAddFicheiro" action="{{route ('uploadFicheiroTarefa')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name='ficheiro' placeholder="ficheiro...">
                <input type="hidden" name='tarefaId' value="{{ $tarefaEdit[0]->id }}">
                <input type="submit" value='Adicionar'>
            </form>
        </div>
        
        <div>
            <form id="formAddLinkTarefa">
                <input type="text" name='nome' placeholder="nome..."><br>
                <input type="url" name='url' placeholder="URL..."><br>
                <input type="hidden" name='tarefaId' value="{{ $tarefaEdit[0]->id }}"><br>
                <input type="submit" value='Adicionar'>
            </form>
        </div>       

    </div>
  
</div>


<script>

    $('#btnEdit').click(function(){
        $('.adicionarFicheiro').hide();
        $('#editarFicheiro').show();
    });

    $('#btnAdici').click(function(){
        $('.adicionarFicheiro').show();
        $('#editarFicheiro').hide();
        $('#btnEdit').css();
    });

    $(".closebtn").click(function(){
        ($($(this).parent()).parent()).hide();
    });

    // Informacao para editar a tarefa
    function eliminarFicheiro(idF,idT) {
        $.ajax({
            url: '/eliminarFicheiro',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'idF': idF , 'idT': idT },
            success: function(data){
                $('#tarefas').html(data.html)
                $('#allEditT').show();
            }
        });
    }

    $("#formAddLinkTarefa").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/addLinkTarefa',
            type: 'GET',
            data : form_data,
            success: function(data){
                $('#tarefas').html(data.html)
                $('#allEditT').show();
            }
        });
    })

    $("#formEditTarefa").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/alterarTarefa',
            type: 'GET',
            data : form_data,
            success: function(data){
                $('#tarefas').html(data.html)
                $('#allEditT').hide();
            }
        });
    })

    /* $("#formAddNotaTarefa").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/addNota',
            type: 'GET',
            data : form_data,
            success: function(data){
                $('#tarefas').html(data.html)
                $('#allEditT').show();
            }
        });
    }) */

</script>

@endisset
