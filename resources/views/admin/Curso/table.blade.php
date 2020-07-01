<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>Código</th>
            <th>Departamento</th>
            <th>Ativo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cursos as $curso) 
            <tr>
                <td>
                    <i class="fas fa-edit" onclick="EditModal({{$curso->id}}, 'Curso', 'Editar curso')" role="button" data-toggle="modal" data-target="#edit"></i>
                </td>
                <td>{{$curso->nome}}</td>
                <td>{{$curso->codigo}}</td>
                <td>{{$curso->departamento}}</td>
                <td>{{$curso->active}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(isset($departamento))
    {{$cursos->appends(['campos' => ['departamento' => $departamento]])->links()}}
@else
    {{$cursos->links()}}
@endif

<script>
    $(document).ready(function() {
        $('.pagination a').click(function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            SearchInput('/searchCursos', page);
        });
    });
</script>