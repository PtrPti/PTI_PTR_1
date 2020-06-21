<h4><b>Docentes</b></h4>
<ul>
    @foreach($docentes as $docente)
        <li><b>{{$docente->nome}}</b> ({{$docente->email}})</li>
    @endforeach
</ul>
@if(sizeof($projetos_cadeira) > 0)
    <h4><b>Projetos</b></h4>
    <ul>
        @foreach($projetos_cadeira as $p)
            <li><a href="#" onclick="ShowGrupos({{$p->id}});" id="proj-{{$p->id}}">{{$p->nome}}</a></li>
        @endforeach
    </ul>
@endif
<a href="#" onclick="changeTab(5)" id="btn-forumDuvidas">Fórum de dúvidas <i class="fas fa-users"></i></a>

<script>
    function ShowGrupos(id) {
        $.ajax({
            url: '/showGrupos',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $("#tab-7").html(data.html);
                changeTab(7, 'flex', data.nome);
            }
        });
    }
</script>