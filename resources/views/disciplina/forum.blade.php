<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <b>{{ __('change.forumDuvidas') }}</b>
</div>

<div class="row-add">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#createTopico">{{ __('change.criar_topico') }}</button>
</div>

<table class="tableForum">
    <tr>
        <th>{{ __('change.assunto') }}</th>
        <th>{{ __('change.criado_por') }}</th>
        <th>{{ __('change.respostas') }}</th>
        <th>{{ __('change.ultima_resposta') }}</th>
    </tr>
    @foreach($duvidas as $duvida)
        <tr>
            <td><a id="duvida-{{$duvida->id}}" onclick="verMensagensForum({{$duvida->id}}, '{{$duvida->assunto}}')">{{$duvida->assunto}}</a></td>
            <td>{{$duvida->primeiro}}</td>
            <td>{{$duvida->totalMensagens}}</td>
            <td>{{$duvida->ultimo}}</td>
        </tr>
    @endforeach
</table>

<div class="modal fade" id="createTopico" tabindex="-1" role="dialog" aria-labelledby="createTopicoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTopicoLabel">{{ __('change.criar_topico') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="topicoForum">
                    {{csrf_field()}}
                    <input type="hidden" name="cadeira_id" value="{{ $disciplina->id }}" required>
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="text" name="assunto" class="display-input" id="assunto">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="assunto" class="labelTextModal">{{ __('change.assunto') }}</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <textarea name="mensagem" cols="63" rows="3" class="area-input" maxlength="4000" id="mensagem"></textarea>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="mensagem" class="labelAreaModal">{{ __('change.mensagem') }}</label>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                            <button type="button" class="btn btn-primary" onclick="Save('topicoForum', '/addForumTopico')">{{ __('change.criar') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('change.fechar') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(Session::has('click'))
<script>
    $(document).ready(function() {
        $("#<?php echo Session::get('click') ?>").click();
    });
</script>
@endif

<script>
    function verMensagensForum(id, nome) {
        $.ajax({
            url: '/verMensagensForum',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: { 'id': id },
            success: function (data) {
                $("#tab-6").html(data.html);
                changeTab(6, 'block', nome);
            }
        });
    }
</script>