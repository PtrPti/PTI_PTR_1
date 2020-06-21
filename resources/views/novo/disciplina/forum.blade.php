<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <b>Fórum de dúvidas</b>
</div>

<div class="row-add">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#createTopico">Criar tópico</button>
</div>

<table class="tableForum">
    <tr>
        <th>Assunto</th>
        <th>Criado por</th>
        <th>Respostas</th>
        <th>Última resposta</th>
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
                <h5 class="modal-title" id="createTopicoLabel">Criar tópico</h5>
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
                            <label for="assunto" class="labelTextModal">Assunto</label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <textarea name="mensagem" cols="63" rows="3" class="area-input" maxlength="4000" id="mensagem"></textarea>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="mensagem" class="labelAreaModal">Mensagem</label>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                            <button type="button" class="btn btn-primary" onclick="Save('topicoForum', '/addForumTopico')">Criar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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