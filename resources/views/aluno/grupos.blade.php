<a onclick="return_trabalho()" id="return_btn"><b>Trabalhos</b></a> > <u>{{$projeto->nome}}</u>

<table class="tableGrupos" style="margin-top:9%">
    <tr>
        <th>Número do grupo</th>
        <th>Total de membros</th>
        <th colspan="2">Elementos</th>
    </tr>
    
    <?php $inGroup = False; ?>
    @foreach ($grupos as $grupo)
    <tr>
        <td>Grupo {{$grupo->numero}}</td>
        <td>{{$grupo->total_membros}} / {{$projeto->n_max_elementos}}</td>
        <td><a>{{$grupo->elementos}}</a></td>
        <td>            
            <?php 
                if ($pertenceGrupo != NULL){
                    if($grupo->id == $pertenceGrupo->grupo_id){
                        echo "<button type='button' class='buttun_group' onclick='removeUser($grupo->id, $projeto->id)'>Sair no Grupo</button>", csrf_field();
                    }else{
                        echo " ";
                    }
                    $inGroup = True; 
                }
                else{
                    if($grupo->total_membros == $projeto->n_max_elementos){
                        echo "Fechado";
                        $inGroup = True;
                    }else{
                        echo "<button type='button' class='buttun_group' onclick='addUser($grupo->id, $projeto->id)'>Entrar no Grupo</button>", csrf_field();
                    }
                }            
            ?>
        </td>
    </tr>
    @endforeach
</table>

<?php
if(!$inGroup){
    echo "<button type='button' style='position:absolute;bottom:86%;;left:52%;' id='button_style' onclick='addUserGroup($grupo->id, $projeto->id)'>Adicionar Grupo</button>", csrf_field();
}
?> 

<script>
    function removeUser(grupo_id, projeto_id) {
        $.ajax({
            url: '/removeUser',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'grupo_id': grupo_id,'_token':'{{csrf_token()}}'},
            success: function(data){
                ShowGruposA(projeto_id);
            }
        });
    }
    
    function addUser(grupo_id, projeto_id) {
        $.ajax({
            url: '/addUser',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'grupo_id': grupo_id, '_token':'{{csrf_token()}}'},
            success: function(data){
                ShowGruposA(projeto_id);
            }
        });
    }

    function addGroup(projeto_id) {
        $.ajax({
            url: '/addGroup',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'projeto_id': projeto_id, '_token':'{{csrf_token()}}'},
            success: function(data){
                ShowGruposA(projeto_id);
            }
        });
    }

    function addUserGroup(projeto_id) {
        $.ajax({
            url: '/addUserGroup',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'projeto_id': projeto_id, '_token':'{{csrf_token()}}'},
            success: function(data){
                ShowGruposA(projeto_id);
                $('#button_style').hide()
            }
        });
    }
</script>