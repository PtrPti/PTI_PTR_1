<div class="flex-disciplina" id="disciplinas">
    @foreach($disciplinas as $disciplina)
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