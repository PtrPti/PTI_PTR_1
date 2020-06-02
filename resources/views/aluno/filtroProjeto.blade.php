<div class="grupos">
    @if (isset($projetos))
        @if (count($projetos) == 0)
            <p>Não está inscrito em nenhum projeto/grupo</p>
        @else
            @foreach ($projetos as $proj)
               
                <a href="{{ route('pagProjeto', ['id' => $proj->id]) }}">
                @if($proj->favorito == 0)
                    <img onclick="changeVal(1, <?php echo $proj->usersGrupos_id ?>)" src="{{ asset('images/favorito1.png') }}" class="grupo_favorito" id="imagem_favorita">
                @else
                    <img onclick="changeVal(0, <?php echo $proj->usersGrupos_id ?>)" src="{{ asset('images/favorito2.png') }}" class="grupo_favorito" id="imagem_favorita">
                @endif
                    <div class="grupo">
                        {{$proj->projeto}} | Grupo Nº{{$proj->numero}}<br>
                        <small>{{$proj->cadeiras}}</small>
                    </div>
                </a>
            @endforeach
        @endif
    @else
        Não existem resultados
    @endif
</div>