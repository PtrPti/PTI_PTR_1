

@foreach ( $feedbacks as $feedback)
    <div class='msg1'>
        @if ( empty( $feedback->mensagem_docente ) ) 
            <p class='p1'> {{$feedback->mensagem_grupo}}</p>
        @else
            <p class='p1' onclick="darvista({{$feedback->id}})"> @if (! $feedback->vista_grupo)<span class='bola'></span><strong>{{$feedback->mensagem_docente}}</strong> @else {{$feedback->mensagem_docente}} @endif </p>
        @endif
            <div class='msg2'>
                <div class='borderFeed'>
                <img class='backmsg' src="{{ asset('images/more.png') }}" width="20">
                <div class='grupop'>
                @foreach ($feedbackFicheiros as $feedbackFicheiro)
                    @if ($feedbackFicheiro->feedback_id == $feedback->id )
                        @foreach ($grupoFicheiros as $grupoFicheiro)
                            @if ($feedbackFicheiro->grupo_ficheiro_id == $grupoFicheiro->id)

                                @if ( ! empty($grupoFicheiro->link) and is_null($grupoFicheiro->notas))
                                    <a class="item1F" href="{{$grupoFicheiro->link}}">
                                        @if (str_contains($grupoFicheiro->link, 'drive.google.com'))
                                            <img src="{{ asset('images/drive.png') }}" width="23">
                                        @elseif (str_contains($grupoFicheiro->link, 'github.com'))
                                            <img src="{{ asset('images/github.png') }}"  width="23">
                                        @else 
                                            <img src="{{ asset('images/link.png') }}"  width="21">
                                        @endif
                                        <span>{{$grupoFicheiro->nome}}</span>
                                    </a>
                                @elseif ( ! is_null($grupoFicheiro->notas) )
                                    <a class="item1F" href="#"  onclick="infoNota('grupo',{{$grupoFicheiro->id}})">
                                        <img src="{{ asset('images/nota.png') }}" width="23">
                                        <span>{{$grupoFicheiro->nome}}</span>
                                    </a> 
                                @else
                                    <a class="item1F">
                                        <img src="{{ asset('images/file.png') }}" width="25">
                                        <span>{{$grupoFicheiro->nome}}</span>
                                    </a>
                                @endif

                            @endif
                        @endforeach 
                    @endif
                @endforeach
                <hr> {{$feedback->mensagem_grupo}} </div>
                @if (!empty($feedback->mensagem_docente))
                    <div class='professorp'style="color:black;" > {{$feedback->mensagem_docente}} </div>
                @else 
                    <div class='professorp'  >Aguardando feedback...</div>
                @endif
            </div>
            </div>
    </div>
@endforeach

<script>
      $('.msg2').hide();

$(".p1").click(function(){
    $(".msg2:first", $(this).parent()).show();
}); 

$(".backmsg").click(function(){
    $('.msg2').hide();
}); 

function darvista(id){
    $.ajax({
            url: '/feedbackVista',
            type: 'GET',
            data : {'id':id}
        });
}
</script>
