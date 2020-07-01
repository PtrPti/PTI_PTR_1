<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th class="order">Nome</th>
            <th class="order">Código</th>
            <th class="order">Ano</th>
            <th class="order">Semestre</th>
            <th class="order">Curso</th>
            <th class="order">Ano letivo</th>
            <th class="order">Ativo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cadeiras as $cadeira) 
            <tr>
                <td>
                    <i class="fas fa-edit" onclick="EditModal({{$cadeira->id}}, 'Cadeira', 'Editar disciplina', {{$cadeira->curso_id}})" role="button" data-toggle="modal" data-target="#edit"></i>
                    <a href="{{ route ('editCadeiraForm', ['id' => $cadeira->id])}}"><i class="fas fa-hand-point-up"></i></a>
                </td>
                <td>{{$cadeira->nome}}</td>
                <td>{{$cadeira->codigo}}</td>
                <td>{{$cadeira->ano}}</td>
                <td>{{$cadeira->semestre}}</td>
                <td>{{$cadeira->curso}}</td>
                <td>{{$cadeira->ano_letivo}}</td>
                <td>{{$cadeira->active}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(isset($curso) || isset($semestre) || isset($ano_letivo))
    {{$cadeiras->appends(['campos' => ['curso' => $curso, 'semestre' => $semestre, 'ano_letivo' => $ano_letivo]])->links()}}
@else
    {{$cadeiras->links()}}
@endif

<script>
    $(document).ready(function() {
        $('.pagination a').click(function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            SearchInput('/searchCadeiras', page);
        });
    });
</script>
