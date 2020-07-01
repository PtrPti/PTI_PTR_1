<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <a href="#" onclick="changeTab(5)">{{ __('change.forumDuvidas') }}</a> > <b><span class="breadcrum"><span></b>
</div>

@isset($mensagens)
    <?php $width = 98; $bloco = 0; ?>
        @foreach($mensagens as $mensagem)
            <?php if($mensagem->bloco > $bloco) { $bloco = $mensagem->bloco; $width = 97; } ?>
            <div class="mensagem" id="mensagem_{{$mensagem->id}}" style="width: {{ $width . '%' }}">
                <h5><b>{{$duvida->assunto}}</b> {{ __('change.por') }} {{$mensagem->nome}} - {{ date('l, jS F Y, H:i', strtotime($mensagem->created_at)) }}</h5>
                <p>{{$mensagem->mensagem}}</p>

                <div class="row-btn">
                    <button type="button" onclick="ReplyMensagem({{$mensagem->id}})">{{ __('change.responder') }} <i class="fas fa-reply"></i></button>
                </div>

                <div class="reply" id="reply_{{$mensagem->id}}">
                    <form action="#" method="POST" id="replyForm_{{$mensagem->id}}">
                        {{csrf_field()}}
                        <input type="hidden" name="mensagem_id" id="mensagem_id" value="{{$mensagem->id}}">
                        <input type="hidden" name="duvida_id" id="duvida_id" value="{{$duvida->id}}">
                        <input type="hidden" name="cadeira_id" id="cadeira_id" value="{{$duvida->cadeira_id}}">
                        <textarea class="inputTopico" name="resposta" id="resposta" placeholder="Escreva a sua resposta..." rows="5"></textarea>
                        <div class="row-btn">
                            <button type="button" class="btn btn-primary" onclick="Save('replyForm_{{$mensagem->id}}', '/replyForum')">{{ __('change.submeter') }}</button>
                            <button type="button" id="cancel" onclick="CancelReply({{$mensagem->id}})">{{ __('change.cancelar') }}</button>
                        </div>
                    </form>
                </div>
                <?php $width-- ; ?>
            </div>
        @endforeach
@endisset

<script>
    function ReplyMensagem(id) {
        $('#reply_' + id).show();
    }

    function CancelReply(id) {
        $('#reply_' + id).hide();
    }
</script>