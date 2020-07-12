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

<div class="row-btn">
    <form action="/exportExcel" method="GET" name="excel" id="excel">
        <input type="hidden" name="table" value="" id="excelData">
        <input type="hidden" name="title" value="Departamentos">
        <button type="submit" onclick="exportExcel()">Exportar excel <i class="fas fa-file-excel"></i></button>
    </form>
</div>

{{$departamentos->links()}}