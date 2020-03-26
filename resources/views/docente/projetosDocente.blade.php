

<div id="projetos">
    <div class="split left">
            <div class="centered">  
                <button id='button' class="btn" onclick="$('.bg-modal').slideToggle(function(){ $('#button').html($('.bg-modal').is(':visible')?'See Less Details':'See More Details');});"> Criar Novo Projeto</button>
            </div>
        </div>

        <div class="split right">
            <div class="centered">
                <p>Projetos</p>
                <ul>
                @foreach($projetos as $projeto)
                    <li><a href="#">{{$projeto->nome}}</a></li>
                @endForeach
                </ul>
            </div>
        </div>


    <div class="bg-modal">
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
</div>

<script>
    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });
</script>