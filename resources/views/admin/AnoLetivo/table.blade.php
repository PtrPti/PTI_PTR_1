<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Ano letivo</th>
            <th>Data início</th>
            <th>Data fim</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anosLetivos as $ano) 
            <tr>
                <td><i class="fas fa-edit" onclick="EditModal({{$ano->id}}, 'AnoLetivo', 'Editar ano letivo')" role="button" data-toggle="modal" data-target="#edit"></i></td>
                <td>{{$ano->ano}}</td>
                <td>{{$ano->getFullDate($ano->dia_inicio, $ano->mes_inicio, $ano->ano_inicio, 'd-m-Y')}}</td>
                <td>{{$ano->getFullDate($ano->dia_fim, $ano->mes_fim, $ano->ano_fim, 'd-m-Y ')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(isset($ano_letivo))
    {{$anosLetivos->appends(['campos' => ['ano_letivo' => $ano_letivo]])->links()}}
@else
    {{$anosLetivos->links()}}
@endif

<script>
    $(document).ready(function() {
        $('.pagination a').click(function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            SearchInput('/searchAnosLetivos', page);
        });
    });
</script>