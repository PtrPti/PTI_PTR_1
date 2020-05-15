<div class="discpContainer" id="pagInicial">
    <div class="infDisciplina">
        <h4 style="color:#aac;"><b>Docentes</b></h4>
        @foreach($docentes as $docente)
        <div class="infDocentes">
            <span><b>{{$docente->nome}}</b> ({{$docente->email}})</span>
        </div>
        @endforeach
        <a class="forumDuvidas_btn" onclick="ShowForum({{ $cadeira->id }})"><img src="{{ asset('images/forum_icon.png') }}" width=15px style="margin-top: -4px;"> Fórum de dúvidas </a>
    </div>    
</div>