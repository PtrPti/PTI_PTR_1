<button type="button" class="addBtn" onclick="AddGrupo(<?php echo $projeto ?>)">Adicionar Grupo</button>
<table class="tableGrupos">
    <tr>
        <th>Número do grupo</th>
        <th>Elementos</h>
    </tr>
    @foreach ($grupos as $grupo)
    <tr>
        <td>Grupo {{$grupo->numero}}</td>
        
    <tr>
    @endforeach
</table>

<script>
    function AddGrupo(id) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $(".tableGrupos").append("<tr><td>Grupo " + data.numero + "</td><td>0/" + data.max_elem + "</td><td>-</td></tr>");
            }
        });
    }
</script>