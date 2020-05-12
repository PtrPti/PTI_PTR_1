<div class="discpContainer" id="pagInicial">
    <div class="infDisciplina">
            <h4 style="color:#aac;"><b>Docentes</b></h4>
            @foreach($docentes as $docente)
            <div class="infDocentes">
                <span><b>{{$docente->nome}}</b> ({{$docente->email}})</span>
            @endforeach
        </div>
        <a class="forumDuvidas_btn" onclick="ShowForum({{ $cadeira->id }})"><img src="{{ asset('images/forum_icon.png') }}" width=15px style="margin-top: -4px;"> Fórum de dúvidas </a>
    </div>    
</div>

<script>
    function ShowForum(id) {
        $.ajax({
            url: '/getForum',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $(".discpContainer").css('display', 'none');
                $("#forum").replaceWith(data.html);
                $("#forum").css('display', 'flex');
            }
        });
    }
</script>