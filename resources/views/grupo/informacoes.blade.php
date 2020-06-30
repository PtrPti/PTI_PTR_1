@if(count($avaliacoes) == 0)
    <h4><b>Realize a votação</b></h4>
    <div>
        <form method="post" action="{{ route('addAvaliacao') }}">
            {{csrf_field()}}
            <table class='tabela_aval'>
                @foreach($membros as $membro)
                <tr> 
                    <td class='primeira_coluna'>{{$membro->nome}}</td>
                    <td class='segunda_coluna'><input type="number" id="nota" name="nota_{{$membro->id}}" min="0" max="20" required></td>
                </tr>
                @endforeach
            </table>
            <input type="hidden" name="grupo_id" id="grupo_id" value="{{$grupo->id }}">
            <input type="submit" value="Submeter">
        </form>
    </div>
@else
    <div>
        <h4><b>Avaliação Submetida</b></h4>
        <table class='tabela_aval'>
            @foreach($avaliacoes as $aval)
            <tr> 
                <td class='primeira_coluna'>{{$aval->nome}}</td>
                <td class='segunda_coluna'>{{$aval->nota}}</td>
            </tr>
            @endforeach
        </table>
    </div>
@endif