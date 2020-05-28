<div class="grupos">
    @if (isset($projetos))
        @foreach ($projetos as $proj)
            @if($proj->favorito == 0)
                <img onclick="changeVal(1, <?php echo $proj->usersGrupos_id ?>)" src="{{ asset('images/favorito1.png') }}" class="grupo_favorito" id="imagem_favorita">
            @else
                <img onclick="changeVal(0, <?php echo $proj->usersGrupos_id ?>)" src="{{ asset('images/favorito2.png') }}" class="grupo_favorito" id="imagem_favorita">
            @endif
            <a href="{{ route('pagProjeto', ['id' => $proj->id]) }}">
                <div class="grupo">
                    {{$proj->projeto}} | Grupo Nº{{$proj->numero}}<br>
                    <small>{{$proj->cadeiras}}</small>
                </div>
            </a>
        @endforeach
    @else
        Não existem resultados
    @endif

</div>