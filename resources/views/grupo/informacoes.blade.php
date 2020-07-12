@if(sizeof($avaliacoes) == 0)

    <div class="row-add">
        <button id="add_button" class="add-button" data-toggle="modal" data-target="#addAvaliacaoAluno">{{ __('change.avaliar') }}</button>
    </div>
@endif

    <div class="modal fade" id="addAvaliacaoAluno" tabindex="-1" role="dialog" aria-labelledby="addAvaliacaoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="addAvaliacaoLabel">{{ __('change.avaliar') }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <form method="POST" action="{{ route('addAvaliacao') }}" id="avaliacaoform">
                            {{csrf_field()}}
                            <div class="row group">
                                <div class="col-md-12">
                                    <table class='tabela_aval'>
                                        @foreach($membros as $membro)
                                        <tr> 
                                            <td class='primeira_coluna'>{{$membro->nome}}</td>
                                            <td class='segunda_coluna'><input type="number" id="nota_{{$membro->id}}" name="nota_{{$membro->id}}" min="0" max="20" required></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                </div>
                            </div>
                    
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" style="display: inline-block !important">{{ __('change.submeter') }}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">{{ __('change.fechar') }}</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>



    <div>
    @if(Auth::user()->isAluno() )
        <h5><b>Avaliação Submetida</b></h4>
        @foreach($avaliacoes as $a)

        <table class='tabela_aval'>
            <tr> 
                <td class='primeira_coluna'>{{$a->nome}}</td>
                <td class='segunda_coluna'>{{$a->nota}}</td>
            </tr>
        </table>
        
        @endforeach
    @endif
    </div>



    <div>
        <h5><b>Avaliação Professor</b></h4>
        <table class='tabela_aval'>
            @if(Auth::user()->isAluno())
                @foreach($avaliacoesDocente as $avalD)
                    @if(Auth::user()->getUserId() == $avalD->id)
                        <tr> 
                            <td class='primeira_coluna'>{{$avalD->nome}}</td>
                            <td class='segunda_coluna'>{{$avalD->avaliacao}}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                @foreach($avaliacoesDocente as $avalD)
                    <tr> 
                        <td class='primeira_coluna'>{{$avalD->nome}}</td>
                        <td class='segunda_coluna'>{{$avalD->avaliacao}}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
