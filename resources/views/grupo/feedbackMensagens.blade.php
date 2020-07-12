<div class="back-links">
    <a href="#" onclick="changeTab(2)"><i class="fas fa-chevron-circle-left"></i> {{ __('change.voltar') }}</a>
    <h5>{{$assunto[0]->mensagem}}</h5>
</div>

<div class="split-left">
    <h6>{{ __('change.ficheirosSubmetidos') }}</h6>
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
    <div class='mensagens_feedback'>
    @foreach ($feedback as $msg)
        @if(Auth::user()->isAluno())
            @if (is_null($msg->docente_id))
                <div class="outgoing_msg">
                    <div class="sent_msg">
                        <span class="msg_user">{{ $msg->aluno }}</span>
                        <div class="sent_withd_msg">
                            <p>{{ $msg->mensagem }} </p>
                            <span class="time_date">{{ $msg->created_at }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="incoming_msg">
                    <div class="received_msg">
                        <span class="msg_user">{{ $msg->docente }}</span>
                        <div class="received_withd_msg">
                            <p>{{ $msg->mensagem }}</p>
                            <span class="time_date">{{ $msg->updated_at }}</span>
                        </div>
                    </div>
                </div>
            @endif

        @else

            @if (!is_null($msg->docente_id))
                <div class="outgoing_msg">
                    <div class="sent_msg">
                        <span class="msg_user">{{ $msg->docente }}</span>
                        <div class="sent_withd_msg">
                            <p>{{ $msg->mensagem }} </p>
                            <span class="time_date">{{ $msg->created_at }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="incoming_msg">
                    <div class="received_msg">
                        <span class="msg_user">{{ $msg->aluno }}</span>
                        <div class="received_withd_msg">
                            <p>{{ $msg->mensagem }}</p>
                            <span class="time_date">{{ $msg->updated_at }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
    </div>

    <div class="feedback_inp">
    <form method="post" id="sendFeedbackForm" action="#" enctype="multipart/form-data">
        {{csrf_field()}}                       
        <input type="hidden" name="id" value="{{ $assunto[0]->id }}">
        <input type="hidden" name="grupo_id" value="{{ $assunto[0]->grupo_id }}">
        <input type="hidden" name="aluno_id" value="@if(Auth::user()->isAluno()) {{Auth::user()->getUserId() }} @endif">
        <input type="hidden" name="docente_id" value="@if(!Auth::user()->isAluno()) {{ Auth::user()->getUserId() }} @endif">

        <input type="text" name='mensagem' class='inpFeed'>
        
        <button type="button" onclick='sendFeedback("sendFeedbackForm")'><i class="fas fa-paper-plane"></i></button>
    <form>
</div>
    
</div>


<script>
    $(document).ready(function () {
        $(".mensagens_feedback").scrollTop($(".mensagens_feedback").prop("scrollHeight"));
    });
    
    function sendFeedback(form) {
        var form = $("#" + form);
        var formData = form.serialize();
        $.ajax({
            url: '/sendFeedback',
            type: 'POST',
            data: formData,
            success: function (data) {
                $("#tab-3").html(data.html);
                changeTab(3, 'flex');
            }
        });
    }
    function AddCreateFeedback(id) {
        $.ajax({
            url: '/addMensagemFeedbackDocente',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data) {
                $("#ModalFeedback p" ).text(data.message);
                $("#ModalFeedback").show();
            }
        });
    }

</script>
