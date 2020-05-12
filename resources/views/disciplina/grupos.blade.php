<div class="discpContainer" id="grupos">
    <div class="addBtn-row">
        <button type="button" class="addBtn" onclick="AddGrupo(<?php if (isset($projeto_id)) echo $projeto_id ?>)">Adicionar grupo</button>
        <button type="button" class="addBtn" onclick="AddMultGrupModal()">Adicionar múltiplos grupos</button>
    </div>

    <table class="tableGrupos" id="tableShowGrupos">
        @isset($grupos)
            @foreach ($grupos as $grupo)
            <tr id="grupo_{{$grupo->id}}">
                <td>
                    @if ($grupo->total_membros == 0)
                        <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                    @endif
                </td>
                <td>Grupo {{$grupo->numero}}</td>
                <td>{{$grupo->total_membros}}/<?php echo $max_elementos ?></td>
                <td>{{$grupo->elementos}}</td>
            <tr>
            @endforeach
        @endisset
    </table>
</div>

<script>
    function AddGrupo(id) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'grupos': 1},
            success: function(data) {
                for(var i = 0; i < data.length; i++) {
                    $("#tableShowGrupos").append("<tr id='grupo_" + data[i][2] + "'><td><i class='fas fa-trash-alt' onclick='DeleteGroup(" + data[i][2] + ")'></i></td><td>Grupo " + data[i][0] + "</td><td>0/" + data[i][1] + "</td><td>-</td></tr>");
                }
            }
        });
    }

    function AddMultGrupo(id) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'grupos': $('input[name=n_grupos]').val()},
            success: function(data) {
                for(var i = 0; i < data.length; i++) {
                    $("#tableShowGrupos").append("<tr id='grupo_" + data[i][2] + "'><td><i class='fas fa-trash-alt' onclick='DeleteGroup(" + data[i][2] + ")'></i></td><td>Grupo " + data[i][0] + "</td><td>0/" + data[i][1] + "</td><td>-</td></tr>");
                }
                closeForm();
            }
        });
    }

    function AddMultGrupModal() {
        $('#grupoNModal').show();
    }

    function DeleteGroup(id) {
        if(confirm('Tem a certeza que deseja apagar o grupo ?')) {
            $.ajax({
                url: 'deleteGrupo',
                type: 'POST',
                dataType: 'json',
                data: {'id': id, '_token': '{{csrf_token()}}'},
                success: function(data) {
                    $("#grupo_" + id).remove();
                }
            });
        }
    }
</script>