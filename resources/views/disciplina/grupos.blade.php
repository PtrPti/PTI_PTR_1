
<button type="button" class="addBtn" onclick="AddGrupo(<?php echo $projeto ?>)">Adicionar Grupo</button>

<table class="tableGrupos">
    @foreach ($grupos as $grupo)
    <tr>
        <td>Grupo {{$grupo->numero}}</td>
        <td>0/<?php echo $max_elementos ?></td>
        <td>-</td>
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