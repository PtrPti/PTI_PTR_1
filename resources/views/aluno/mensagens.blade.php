<p>
    <a class="pagInicia_btn" id="return_btn"><b>Página Inicial</b></a> > <a class="forumDuvidas_btn" id="return_btn"><b>Forum de Dúvidas</b></a> > <u>{{$duvida[0]->assunto}}</u>
</p>

@foreach($mensagens as $mensagem)
<div class="mensagem">
    <h5><b>{{$duvida[0]->assunto}}</b> by {{$mensagem->user_id}} - {{$mensagem->created_at}}</h5>
    <p>{{$mensagem->mensagem}}</p>
</div>
@endforeach