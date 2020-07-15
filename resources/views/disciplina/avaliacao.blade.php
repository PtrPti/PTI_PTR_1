@if (Auth::user()->isProfessor())
    <div class="row-add">
        <button id="add_button" class="add-button" data-toggle="modal" data-target="#createEvaluation">{{ __('change.criarCriteriosDeAvaliacao') }}</button>            
    </div>

    <div class="row-add">
        <h5 class="avaliacao_titulo">{{ __('change.metodosAvaliacao') }}</h5>
    </div>

    <div class="modal fade" id="createEvaluation" tabindex="-1" role="dialog" aria-labelledby="createEvaluationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="createEvaluationLabel">{{ __('change.insiraMetodosAvaliacao') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <div class="modal-body">
                    <form method="POST" action="{{route('createEvaluation')}}" id="createEvaluationForm">
                        {{csrf_field()}}
                        <input type="hidden" name="cadeira_id" value="{{ $disciplina->id }}" required>
                        <div class="row group">
                            <div class="col-md-12">
                                <textarea style="width:100%;" name="mensagem_criterios" cols="63" rows="3" class="area-input" maxlength="4000" id="mensagem_criterios" placeholder="{{ __('change.insiraAquiTexto') }}"></textarea>
                            </div>
                        </div>
                
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary ">{{ __('change.submeterCriterios') }}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('change.fechar') }}</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-add">
        <table class="table" style="margin-top:40px;">
            <tbody>
                @foreach($avaliacao as $a)
                    <tr>
                        <td> {{$a->mensagem_criterios}}</td>
                        <td> <a onclick="EditEvaluation({{$a->id}})" style="cursor:pointer;" data-toggle="modal" data-target="#editEvaluation"><img src="{{ asset('images/edit_perfil.png') }}" width=18px ></a>  <a style="cursor:pointer;" onclick="EraiseEvaluation({{$a->id}})"><img src="{{ asset('images/delete.png') }}" width=18px data-toggle="modal" data-target="#eraiseEvaluation"></a></td>    
                    </tr>   
                @endforeach
            </tbody>
        </table>    
    </div>

    <div class="modal fade" id="editEvaluation" tabindex="-1" role="dialog" aria-labelledby="editEvaluationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editEvaluationLabel">{{ __('change.editarMetodosAvaliacao') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <div class="modal-body">
                    <form method="POST" action="{{route('changeEvaluation')}}" id="editEvaluationForm">
                        {{csrf_field()}}
                        <input type="hidden" name="cadeira_id" value="{{ $disciplina->id }}" required>
                        
                        <input type="hidden" name="id" value="" id="avaliacao_id" required>                            
                        
                        <div class="row group">
                            <div class="col-md-12">
                                @foreach($avaliacao as $a)
                                <textarea style="width:100%;" name="nova_mensagem" cols="63" rows="3" class="area-input" maxlength="10000" id="nova_mensagem" placeholder="{{ __('change.insiraAquiTexto') }}">{{$a->mensagem_criterios}}</textarea>
                                @endforeach
                            </div>
                        </div>
                        
                
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary ">{{ __('change.submeterCriterios') }}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('change.fechar') }}</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eraiseEvaluation" tabindex="-1" role="dialog" aria-labelledby="eraiseEvaluation" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="eraiseEvaluationLabel">{{ __('change.apagar') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <div class="modal-body">
                    <form method="POST" action="{{route('eraiseEvaluation')}}" id="eraiseEvaluationForm">
                        {{csrf_field()}}
                        <input type="hidden" name="cadeira_id" value="{{ $disciplina->id }}" required>
                        @foreach($avaliacao as $a)
                        <input type="hidden" name="id" value="" id="avaliacao_id_eraise" required>
                        @endforeach
                        <div class="row group">
                            <div class="col-md-12">
                                <h6 class="modal-title" id="eraiseEvaluation" >{{ __('change.temACertezaQueQuerApagar') }}</h6>
                            </div>
                        </div>
                
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary ">{{ __('change.apagar') }}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('change.fechar') }}</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif (Auth::user()->isAluno())
    <div class="row-add">
        <h5 class="avaliacao_titulo1">{{ __('change.metodosAvaliacao') }}</h5>
    </div>

    <div class="col-add">
        @foreach($avaliacao as $a)
            @if($a->mensagem_criterios == NULL)
            <p style="text-align:center"> {{ __('change.aindaNaoExistemMetodosDeAvaliacao') }}</p> 
            @else
            <p style="text-align:center"> {{$a->mensagem_criterios}}</p>
            @endif
            @endforeach              
    </div>
@endif