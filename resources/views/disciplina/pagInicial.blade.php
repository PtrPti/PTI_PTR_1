@if(sizeof($docentes) > 0)
    <h4><b>{{ __('change.docentes') }}</b></h4>
    <ul>
        @foreach($docentes as $docente)
            <li><b>{{$docente->nome}}</b> <a href="mailto:{{$docente->email}}">({{$docente->email}})</a></li>
        @endforeach
    </ul>
@endif
@if(sizeof($projetos_cadeira) > 0)
    <h4><b>{{ __('change.projetos') }}</b></h4>
    <ul>
        @foreach($projetos_cadeira as $p)
            <li><a href="#" onclick="ShowGrupos({{$p->id}});" id="proj-{{$p->id}}">{{$p->nome}}</a></li>
        @endforeach
    </ul>
@endif
<a href="#" onclick="changeTab(5)" id="btn-forumDuvidas">{{ __('change.forumDuvidas') }} <i class="fas fa-users"></i></a>

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