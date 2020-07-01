<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>Código</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departamentos as $departamento) 
            <tr>
                <td>
                    <i class="fas fa-edit" onclick="EditModal({{$departamento->id}}, 'Departamento', 'Editar departamento')" role="button" data-toggle="modal" data-target="#edit"></i>
                </td>
                <td>{{$departamento->nome}}</td>
                <td>{{$departamento->codigo}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{$departamentos->links()}}