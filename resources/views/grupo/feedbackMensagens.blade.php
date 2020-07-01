<div class="back-links">
    <a href="#" onclick="changeTab(2)"><i class="fas fa-chevron-circle-left"></i> {{ __('change.voltar') }}</a>
</div>

<div class="split-left">
    <h5>{{ __('change.ficheirosSubmetidos') }}</h5>
    <ul class="grupoFiles">
        @foreach($feedbackFicheiros as $ff)
            @if($ff->tf_id == null || $ff->tf_id == "")
                <li><i class="fas fa-file"></i><a href="{{ url('/download', ['folder' => 'grupo', 'filename' => $ff->gf_nome]) }}">{{ explode("_", $ff->gf_nome, 2)[1] }}</a></li> <!-- href para fazer download -->
            @else
                <li><i class="fas fa-file"></i><a href="{{ url('/download', ['folder' => 'tarefa', 'filename' => $ff->tf_nome]) }}">{{ explode("_", $ff->tf_nome, 2)[1] }}</a></li> <!-- href para fazer download -->
            @endif
        @endforeach
    </ul>
</div>
<div class="split-right">
    <div class="outgoing_msg">
        <div class="sent_msg">
            <p>{{ $feedback->mensagem_grupo }}</p>
            <span class="time_date">{{ $feedback->created_at }}</span>
        </div>
    </div>
    @if($feedback->mensagem_docente != null || $feedback->mensagem_docente != "")
        <div class="incoming_msg">
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p>{{ $feedback->mensagem_docente }}</p>
                    <span class="time_date">{{ $feedback->updated_at }} por {{ $feedback->nome }}</span>
                </div>
            </div>
        </div>
    @endif
    @if($feedback->mensagem_grupo == null || $feedback->mensagem_grupo == "")
        <div class="type_msg">
            <div class="input_msg_write">
                <input type="text" class="write_msg" placeholder="Type a message" />
                <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
    @endif
</div>