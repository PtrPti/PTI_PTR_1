<div class="divGrupos">
    <h4 style="margin:15px;margin-right: 30px;"> Projetos </h4>
    <div class="grupo">
        @if (count($projetos) == 0)
            <p>Não está inscrito em nenhum projeto/grupo</p>                                   
        @else
            @foreach ($projetos as $proj)
            <a href="{{ route('id_projeto', ['id' => $proj->id]) }}">
                <div>
                    {{$proj->nome}}<br>
                    <small>{{$proj->cadeira}}</small>
                </div>
            </a>
            @endforeach 
        @endif
    </div>

    <div class="model-content">
        <div class="close" onclick="closeForm()" >x</div>
        <h4>Novo Projeto</h4>
        
        <form id="add_project" action="{{ route('projetoPost') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="text" placeholder="Nome do Projeto" name="nome">
            <input type="number" placeholder="Número de elementos" name="n_elem">
            <div>
                <select class="form-control" name="cadeira_id" id="cadeirasProfessor" required>
                    <option value="" style="text align: center;"> Escolha uma Disciplina </option>
                    @foreach($disciplinas as $disciplina)
                        @if($disciplina->id == old('disciplina_id'))
                            <option value="{{$disciplina->id}}" selected><{{$disciplina->nome}}</option>
                        @else
                            <option value="{{$disciplina->id}}">{{$disciplina->nome}}</option>
                        @endif
                    @endForeach
                </select>                    
            </div>
            <input type="file" name="ficheiro">
                
            <input type="text" class="date" name="datafim" required>

            <button type="submit">Adicionar</button>
        </form>
    </div>
</div>

<script>
    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });

    function OpenModal() {
        $('.model-content').show();
    }

    function closeForm() {
        $('.model-content').hide();
    }
</script>