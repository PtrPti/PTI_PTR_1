<!-- <div id="projetos" class="flex-projetos">
    <button id='button' class="btn" onclick="OpenModal()"> Criar Novo Projeto</button>
    <div class="centered">
        <p>Projetos</p>
        <ul>
        @foreach($projetos as $projeto)
        <li> <a href="{{ route('id_projeto', ['id' => $projeto->id]) }}">{{$projeto->nome}} </a> <a href='#'><img src="{{ asset('images/edit.png') }}" width=10px style="position: relative; left: 30px;"></a><a href='#'><img src="{{ asset('images/lixo.png') }}" width=10px style="position: relative; left: 50px;"></a></li>
        @endForeach
        </ul>
    </div>

    
</div> -->

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