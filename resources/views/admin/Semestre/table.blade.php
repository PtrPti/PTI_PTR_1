<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Semestre</th>
            <th>Data início</th>
            <th>Data fim</th>
            <th>Ano letivo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($semestres as $sem) 
            <tr>
                <td><i class="fas fa-edit" onclick="EditModal({{$sem->id}}, 'Semestre', 'Editar semestre')" role="button" data-toggle="modal" data-target="#edit"></i></td>
                <td>{{$sem->semestre}}</td>
                <td>{{$sem->getFullDate($sem->dia_inicio, $sem->mes_inicio, $sem->ano_inicio, 'd-m-Y')}}</td>
                <td>{{$sem->getFullDate($sem->dia_fim, $sem->mes_fim, $sem->ano_fim, 'd-m-Y')}}</td>
                <td>{{$sem->ano}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row-btn">
    <form action="/exportExcel" method="GET" name="excel" id="excel">
        <input type="hidden" name="table" value="" id="excelData">
        <input type="hidden" name="title" value="Semestres">
        <button type="submit" onclick="exportExcel()">Exportar excel <i class="fas fa-file-excel"></i></button>
    </form>
</div>

@if(isset($semestre) || isset($ano_letivo))
    {{$semestres->appends(['campos' => ['semestre' => $semestre, 'ano_letivo' => $ano_letivo]])->links()}}
@else
    {{$semestres->links()}}
@endif

<script>
    $(document).ready(function() {
        $('.pagination a').click(function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            SearchInput('/searchSemestres', page);
        });
    });
</script>