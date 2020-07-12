@if (isset($projetos))
    @if (count($projetos) == 0)
        
        @if(isset($mensagem))
            <p>{{ $mensagem }}</p>
        @else
            <p>{{ __('change.naoInscrito') }}</p>
        @endif
    
        
    @else
        @foreach ($projetos as $proj)
            <div class="box" id="result_projetos">            
                @if($proj->favorito == 0)
                    <img onclick="changeVal(1, <?php echo $proj->usersGrupos_id ?>)" src="{{ asset('images/favorito1.png') }}" />
                @else
                    <img onclick="changeVal(0, <?php echo $proj->usersGrupos_id ?>)" src="{{ asset('images/favorito2.png') }}" />
                @endif
                <a href="{{ route('projeto', ['id' => $proj->grupo_id]) }}">
                    {{$proj->nome}} | {{ __('change.grupo') }} {{ __('change.num') }}{{$proj->numero}}<br>
                    <small>{{$proj->cadeira}}</small>
                </a>
            </div>
        @endforeach
    @endif



@else
    <p>{{ __('change.naoExistemResultados') }}</p>
@endif