@if (Auth::user()->isAluno() && $projeto->data_fim >= date('Y-m-d H:i:s'))
    <div class="row-add">
        <button id="add_button" class="add-button" data-toggle="modal" data-target="#createFeedback">{{ __('change.pedirFeedback') }}</button>
    </div>
@endif

<table class="tableForum">
    @foreach($feedbacks as $feedback)
        <tr onclick="verFeedback({{ $feedback->id }},@if(Auth::user()->isAluno())'aluno'@else'docente'@endif)">
            <td>{{$feedback->mensagem}}</td>
            <td>{{$feedback->created_at}}</td>
        </tr>
    @endforeach
</table>

@if (Auth::user()->isAluno() && $projeto->data_fim >= date('Y-m-d H:i:s'))
    <div class="modal fade" id="createFeedback" tabindex="-1" role="dialog" aria-labelledby="createFeedbackLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFeedbackLabel">{{ __('change.pedirFeedback') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="createFeedbackForm">
                        {{csrf_field()}}
                        <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                        <input type="hidden" name="aluno_id" value="{{ Auth::user()->getUserId() }}">
                        <input type="hidden" name="files_ids" id="files_ids" value="">
                        <div class="row group">
                            <div class="col-md-12">
                                <input type="text" class="display-input" id="assunto" name="assunto">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="assunto" class="labelTextModal">Assunto</label>
                            </div>
                        </div>
                        
                        <div class="row group" style="margin-bottom: 45px">
                            <div class="col-md-12">
                                <div class="dropdownFiles">
                                    <!-- <span class="hida">Escolher ficheiros</span> -->
                                    <p class="multiSel">
                                        {{ __('change.escolherFicheirosFeedback') }}

                                    </p>
                                    <div class="multiSelect">
                                        <ul>
                                            @foreach($feedFicheiros as $ff)
                                                <li>
                                                    <input class="{{$ff->tipo}}" id="{{$ff->id}}" type="checkbox" name="file" value="{{$ff->id}}" />{{ explode("/", $ff->nome)[2] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-12">
                                <textarea name="message" cols="63" rows="3" class="area-input" maxlength="4000" id="message"></textarea>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="message" class="labelAreaModal">{{ __('change.mensagem') }}</label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                                <button type="button" class="btn btn-primary" onclick="Save('createFeedbackForm', '/createFeedback')">{{ __('change.criar') }}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('change.fechar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function () {
        
        $(".dropdownFiles p").click(function () {
            if ($(".multiSelect").hasClass('show')) {
                $(".multiSelect").removeClass('show');
            }
            else {
                $(".multiSelect").addClass('show')
            }
        });

        $('.multiSelect input').click(function () {
            var text = $(this).parent().text();
            var tipo = $(this)[0].className;
            var id = $(this)[0].id;

            var files = $('.multiSel span').length;

            if (!$(this).is(':checked')) {
                $('span[title="' + text + '"]').remove();
                if (files == 1) {
                    $('.multiSel').empty();
                    $('.multiSel').text('Escolha os ficheiros para feedback');
                    $('#files_ids').val('');
                }
                var value = $('#files_ids').val();
                $('#files_ids').val(value.replace(id + '_' + tipo + ',',''));
            }
            else if (files == 0) {
                $('.multiSel').empty();
                var html = '<span title="' + text + '">' + text + ';</span>';
                $('.multiSel').append(html);
                $('#files_ids').val(id + '_' + tipo + ',');
            }
            else {
                var html = '<span title="' + text + '">' + text + ';</span>';
                $('.multiSel').append(html);
                var value = $('#files_ids').val();
                $('#files_ids').val(value + id + '_' + tipo + ',');
            }
        });
    });

    function verFeedback(id,user) {
        $.ajax({
            url: '/verFeedback',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: { 'id': id, 'user': user },
            success: function (data) {
                $("#tab-3").html(data.html);
                changeTab(3, 'flex');
            }
        });
    }
</script>
