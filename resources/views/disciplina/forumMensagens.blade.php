<div class="discpContainer" id="forumMensagens">
    @isset($duvida)
    <p>
        <a class="breadcrums" id="bread1" onclick="ShowPagInicialDiscDoc({{$duvida->cadeira_id}})"><b>Página Inicial</b></a> > <a class="breadcrums" id="bread2" onclick="ShowForum({{$duvida->cadeira_id}})"><b>Forum de Dúvidas</b></a> > <u>{{ $duvida->assunto }}</u>
    </p>
    @endisset

    @isset($mensagens)
        <?php $width = 98; $bloco = 0; ?>
        @foreach($mensagens as $mensagem)
        <?php if($mensagem->bloco > $bloco) { $bloco = $mensagem->bloco; $width = 97; } ?>
        <div class="mensagem" id="mensagem_{{$mensagem->id}}" style="width: {{ $width . '%' }}">
            <h5><b>{{$duvida->assunto}}</b> por {{$mensagem->nome}} - {{ date('l, jS F Y, H:i', strtotime($mensagem->created_at)) }}</h5>
            <p>{{$mensagem->mensagem}}</p>

            <div class="rowBtns">
                <button type="button" id="add_mensagem_{{$mensagem->id}}" onclick="ReplyMensagem({{$mensagem->id}})">Responder <i class="fas fa-reply"></i></button>
            </div>
            <div class="reply" id="reply_{{$mensagem->id}}">
                <form action="{{route ('replyForum') }}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="mensagem_id" id="mensagem_id" value="{{$mensagem->id}}">
                    <input type="hidden" name="duvida_id" id="duvida_id" value="{{$duvida->id}}">
                    <input type="hidden" name="cadeira_id" id="cadeira_id" value="{{$duvida->cadeira_id}}">
                    <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." rows="5"></textarea>
                    @if ($errors->has('mensagem'))
                        <span class="help-block alert alert-danger">
                            <strong>{{ $errors->first('mensagem') }}</strong>
                        </span>
                    @endif
                    <input type="submit" id="submitMessage" value="Submeter">
                    <button type="button" id="cancel" onclick="CancelReply({{$mensagem->id}})">Cancelar</button>
                </form>
            </div>
        </div>
        <?php $width-- ; ?>
        @endforeach
    @endisset
</div>

<script>
    function ReplyMensagem(id) {
        $('#reply_' + id).show();
    }

    function CancelReply(id) {
        $('#reply_' + id).hide();
    }
</script>