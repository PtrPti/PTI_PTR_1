<div id="disciplinas">
    @foreach($disciplinas as $disciplina)
        <div class="disciplina">
            Nome: {{$disciplina->nome}}<br>
            Código: {{$disciplina->cod_cadeiras}}<br>
            Ano: {{$disciplina->ano}}
        </div>
    @endForeach
</div>