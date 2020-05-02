<div class="flex-disciplina" id="disciplinas">
    @foreach($disciplinas as $disciplina)
        <!-- <div class="disciplina">
            <p>{{$disciplina->nome}} ({{$disciplina->cod_cadeiras}})</p>
            <p>{{$disciplina->ano}}º ano </p>
            <a href="{{ route('indexDisciplinaDocente', ['id' => $disciplina->id])  }}">Entrar »</a>
        </div> -->
        <a class="disciplina" href="{{ route('indexDisciplinaDocente', ['id' => $disciplina->id])  }}">
            <div> 
                {{$disciplina->nome}}
            </div>
        </a>
    @endForeach

    @if (sizeof($disciplinas) % 4 == 1)
        <div class="emptyDiv"></div>
        <div class="emptyDiv"></div>
        <div class="emptyDiv"></div>
    @elseif (sizeof($disciplinas) % 4 == 2)
        <div class="emptyDiv"></div>
        <div class="emptyDiv"></div>
    @elseif (sizeof($disciplinas) % 4 == 3)
        <div class="emptyDiv"></div>
    @endif
</div>