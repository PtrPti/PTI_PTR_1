<div class="divDisciplinas">
      <h4 style="margin-left:15px;">Disciplinas</h4>
      <div class="disciplina">
          @foreach ($disciplinas as $disciplina)
          <a href="{{ route('indexDisciplinaDocente', ['id' => $disciplina->id]) }}"> 
              <div> 
                  {{$disciplina->nome}} 
              </div>
          </a>
          @endforeach
      </div>
  </div>