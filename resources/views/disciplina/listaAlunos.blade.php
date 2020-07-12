<div class="row-add">
        <button id="add_button" class="add-button" data-toggle="modal" data-target="#addAluno">{{ __('change.adicionarAlunos') }}</button>        
    </div>

    <div class="modal fade" id="addAluno" tabindex="-1" role="dialog" aria-labelledby="addAlunoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="addAlunoLabel">{{ __('change.adicioneMaisAlunos') }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <form method="POST" action="{{route('addAluno')}}" id="addAlunoForm">
                            {{csrf_field()}}
                            <input type="hidden" name="cadeira_id" value="{{ $disciplina->id }}" required>
                            <input type="hidden" name="user_id" value="" id="id_user" required>
                      
                            <div class="row group">
                                <div class="col-md-12">
                                    <div class="search_alunos">
                                        <input type="text" name="search" id="search_aluno"  placeholder="{{ __('change.pesquisar') }}">
                                        <i class="fas fa-search search-icon"></i>
                                    </div>
                                    <ul class="inbox_aluno" id="result" >
                                        
                                    </ul>
                                </div>
                            </div>
                    
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>


<table class="tableForum">
    @isset($lista_alunos)
        <tr>
            <th>{{ __('change.nomeAluno') }}</th>
            <th>{{ __('change.numeroAluno') }}</th>
            <th>{{ __('change.emailAluno') }}</th>
        </tr>
        @foreach ($lista_alunos as $user)
            <tr id="user_{{$user->id}}">
                <td>{{$user->nome}}</td>
                <td>{{$user->numero}}</td>
                <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
            </tr>
        @endforeach
    @endisset
</table>


<script>

$('#search_aluno').keyup(function() {
    var search = $('#search_aluno').val();
    $.ajax({
        type: "get",
        url: "/search_alunos",
        data: {'search': search, 'cadeira_id': <?php echo $disciplina->id?>},
        cache: false,
        success: function (data) {
            console.log(data.users)
            $(".inbox_aluno").empty();
            $.each(data.users, function (nome,id) {
                $("#result").append('<li><button type="submit" class="show_al" onclick="idUser(' + id + ')"  >' + nome.split("_")[0] + ' | ' + nome.split("_")[1] +' </button></li>');
             
                    });
                },
            })
});



</script>
 

