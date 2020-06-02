<p><a onclick="return_pagInicial()" id="return_btn"><b>Página Inicial</b></a> > <u>Forum de Dúvidas</u></p>
<div class="div_button">
    <button id="button_style" class="add_button">Adicionar tópico</button>
</div>
@if(Session::has("serverError"))
    <p class="alert alert-danger">{{Session::get('serverError')}}</p>
@endif
<div id="myModal" class="modal">
    <!-- <form action="/addTopico" method="post"> -->
        {{csrf_field()}}
        <input type="hidden" id="cadeira_id" value="<?php echo $cadeira[0]->id ?>">
        <div class="novo_topico">
            <span class="close">&times;</span>
            <h4> Novo tópico </h5><br>
            <div class="row">
                <div class="col-25">
                    <label for="assunto">Assunto</label>
                </div>
                <div class="col-75">
                    <input type="text" class="inputTopico" name="assunto" id="assunto" placeholder="Título do Assunto">
                </div>
            </div>
            <div class="row">
                <div class="col-25"> 
                    <label for="mensagem">Mensagem</label>
                </div>
                <div class="col-75">
                    <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." style="height:200px"></textarea>
                </div>
            </div>
            <div class="row">
                <button type="button" onclick="addTopico()" class="sub_novoTopico" id="button_style">Adicionar</button>
                {{csrf_field()}}
                <!-- <input id="button_style" type="submit" value="Adicionar"> -->
            </div>
        </div>
    <!-- </form> -->
</div>

<table class="tableGrupos">
    <tr>
        <th>Assunto</th>
        <th>Começado por</th>
        <th>Respostas</th>
        <th>Ultima resposta</th>
    </tr>
    @foreach($duvidas as $duvida)
    <tr>
        <td><a onclick="verMensagens({{$duvida->id}})">{{$duvida->assunto}}</a></td>
        <td>{{$duvida->primeiro_user}}</td>
        <td><?php echo 'totalMensagens'?></td>
        <td>{{$duvida->ultimo_user}}</td>
    </tr>
    @endforeach
</table>

<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("button_style");
var span = document.getElementsByClassName("close")[0];

$('#button_style').click(function() {
    modal.style.display = "block";
});

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function addTopico() {
    $.ajax({
        url: '/addTopico',
        type: 'POST',
        dataType: 'json',
        success: 'success',
        data: {'assunto': $('#assunto').val(), 'mensagem':$("#mensagem").val(), 'cadeira_id': $('#cadeira_id').val(), '_token':'{{csrf_token()}}'},
        success: function(data){
            showForum($("#cadeira_id"));
        }
    });
}
</script>