<div class="forumDuvidas discpContainer" id="forum">
    <p><a class="breadcrums" id="bread1" onclick="ShowPagInicialDiscDoc(<?php if(isset($cadeira_id)) echo $cadeira_id;?>)"><b>Página Inicial</b></a> > <u>Forum de Dúvidas</u></p>
    <div class="div_button">
        <button id="add_button" onclick="AddTopico()">Adicionar tópico à discussão</button>
    </div>

    @if(Session::has("serverError"))
        <p class="alert alert-danger">{{Session::get('serverError')}}</p>
    @endif
    
    <div id="topicoModal" class="model-content">
        <form action="{{ route ('addTopicoDocente') }}" method="post"> 
            {{csrf_field()}}
            <input type="hidden" name="cadeira_id" value="<?php if(isset($cadeira)) echo $cadeira->id; elseif(isset($cadeira_id)) echo $cadeira_id;?>">
            <div class="close" onclick="closeForm()" >x</div>
            <h4> Novo tópico </h4>
            <div class="row-topico">
                <div class="label-topico">
                    <label for="assunto">Assunto</label>
                </div>
                <div class="input-topico">
                    <input type="text" class="inputTopico" name="assunto" id="assunto" placeholder="Título do Assunto">
                </div>
                @if ($errors->has('assunto'))
                    <span class="help-block alert alert-danger">
                        <strong>{{ $errors->first('assunto') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row-topico">
                <div class="label-topico">
                    <label for="mensagem">Mensagem</label>
                </div>
                <div class="input-topico">
                    <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." rows="5"></textarea>
                </div>
                @if ($errors->has('mensagem'))
                    <span class="help-block alert alert-danger">
                        <strong>{{ $errors->first('mensagem') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row-topico">
                <input class="sub_novoTopico" type="submit" value="Adicionar">
            </div>
        </form>
    </div>

    <table class="tableGrupos">
        <tr>
            <th>Assunto</th>
            <th>Começado por</th>
            <th>Respostas</th>
            <th>Ultima resposta</th>
        </tr>
        @isset($duvidas)
            @foreach($duvidas as $duvida)
            <tr>
                <td><a onclick="verMensagens({{$duvida->id}})">{{$duvida->assunto}}</a></td>
                <td>{{$duvida->primeiro}}</td>
                <td>{{$duvida->totalMensagens}}</td>
                <td>{{$duvida->ultimo}}</td>
            </tr>
            @endforeach
        @endisset
    </table>
</div>

<div class="addMensagem">
    <div id="novaMensagem" class="modal">
        <form action="/addMensagem" method="post"> 
            {{csrf_field()}}
            <input type="hidden" name="duvida_id">
            <div class="novo_topico">
                <span class="close">&times;</span>
                <h4> Nova mensagem </h5><br>
                <div class="row">
                    <div class="col-75">
                        <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." style="height:200px"></textarea>
                    </div>
                </div>
                <div class="row">
                <input class="novaMensagem" type="submit" value="Responder">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function AddTopico() {
        $('.model-content').hide();
        $('#topicoModal').show();
    }

    function verMensagens(id) {
        // $(".forumDuvidas").hide();
        // $(".divMensagens").show();
        $.ajax({
            url: '/verMensagensDocente',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: { 'id': id },
            success: function (data) {
                $(".discpContainer").css('display', 'none');
                $("#forumMensagens").replaceWith(data.html);
                $("#forumMensagens").css('display', 'flex');
            }
        });
    }
</script>