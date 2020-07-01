$(window, document, undefined).ready(function () {
    $(".display-input").each(function () {
        var $this = $(this);
        if ($this.val())
            $this.addClass('used');
        else
            $this.removeClass('used');
    });

    $(".checkbox-input").each(function () {
        var $this = $(this);
        if ($this.is(':checked'))
            $this.addClass('used');
        else
            $this.removeClass('used');
    });

    $('.display-input').blur(function () {
        var $this = $(this);
        if ($this.val())
            $this.addClass('used');
        else
            $this.removeClass('used');
    });

    $('.select-input').blur(function () {
        var $this = $(this);
        if ($this.val()) {
            if (!$this.hasClass('used')) {
                $this.addClass('used');
            }
        }
        else {
            $this.removeClass('used');
        }
    });

    $('.select-input').click(function () {
        var $this = $(this);
        $this.addClass('used');
    });

    $('.area-input').blur(function () {
        var $this = $(this);
        if ($this.val()) {
            $this.addClass('used');
            $this.addClass('area-input-focus');
        }
        else {
            $this.removeClass('used');
        }
    });

    $('.area-input').focus(function () {
        var $this = $(this);
        $this.removeClass('area-input-focus');
    });

    //Disciplinas
    var dropdown = document.getElementsByClassName("dropdown-btn disc");
    var x;

    $(dropdown).hover(function () {
        $(this).css("filter", "grayscale(0%) opacity(1)");
        $(this).css("background", "var(--bg-secondary)");
        $('.i-nav-disc').css("color", "#6bf7df");
    }, function () {
        $(this).css("filter", "none");
        $(this).css("background", "none");
        $('.i-nav-disc').css("color", "#a1a1a5");
    });


    for (x = 0; x < dropdown.length; x++) {
        dropdown[x].addEventListener("click", function () {
            this.classList.toggle("icon_active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                $("#i-disciplina").toggleClass('fa-caret-up fa-caret-down');
            } else {
                dropdownContent.style.display = "block";
                $("#i-disciplina").toggleClass('fa-caret-up fa-caret-down');
            }
        });
    }

    //Projeto
    var dropdown = document.getElementsByClassName("dropdown-btn proj");
    var x;

    $(dropdown).hover(function () {
        $(this).css("filter", "grayscale(0%) opacity(1)");
        $(this).css("background", "var(--bg-secondary)");
        $('.i-nav-proj').css("color", "#6bf7df");
    }, function () {
        $(this).css("filter", "none");
        $(this).css("background", "none");
        $('.i-nav-proj').css("color", "#a1a1a5");
    });

    for (x = 0; x < dropdown.length; x++) {
        dropdown[x].addEventListener("click", function () {
            this.classList.toggle("icon_active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                $("#i-projeto").toggleClass('fa-caret-up fa-caret-down');
            } else {
                dropdownContent.style.display = "block";
                $("#i-projeto").toggleClass('fa-caret-up fa-caret-down');
            }
        });
    }
});

function changeTab(tab = 1, display = "block", breadcrum = "") {
    if ($('#tab' + tab).length > 0) {
        $('.tab').removeClass('tab-active');
        $('.tab-container').hide();
        $('#tab' + tab).addClass('tab-active');
        $('#tab-' + tab).show();
        $('#tab-' + tab).css('display', display);
        $('.breadcrum').text(breadcrum);
    }
    else {
        $('.tab-container').hide();
        $('#tab-' + tab).show();
        $('#tab-' + tab).css('display', display);
        $('.breadcrum').text(breadcrum);
    }
}


function changeTab_perfil(tab = 1, display = "block", breadcrum = "") {
    if ($('#tab_perfil' + tab).length > 0) {
        $('.tab_perfil').removeClass('tab_perfil-active');
        $('.tab-container_perfil').hide();
        $('#tab_perfil' + tab).addClass('tab_perfil-active');
        $('#tab_perfil-' + tab).show();
        $('#tab_perfil-' + tab).css('display', display);
        $('.breadcrum').text(breadcrum);
    }
    else {
        $('.tab-container_perfil').hide();
        $('#tab_perfil-' + tab).show();
        $('#tab_perfil-' + tab).css('display', display);
        $('.breadcrum').text(breadcrum);
    }
}


function Save(form, url) {
    var form = $("#" + form);
    var formData = form.serialize();
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        error: function (data) {
            if (data.responseJSON) {
                var erros = Object.keys(data.responseJSON);

                var msg = "";

                erros.forEach(function (k) {
                    var erro = data.responseJSON[k][0];
                    msg = msg + "<span class='gritter-text'>" + erro + "</span>";
                    $('#' + k).addClass('error');
                });

                AddGritter('Erro', msg, 'error');
            }
        },
        success: function (data) {
            var msg = "<span class='gritter-text'>" + data.msg + "</span>";

            AddGritter(data.title, msg, 'success');

            $('#addProject').modal('hide');
            window.location.href = data.redirect;
        },
    });
}

function AddGritter(title, msg, type) {
    $('.gritter').find('.gritter-text').remove();

    if (type == "success") {
        $('.gritter-title').html("<i class='fas fa-check-circle success-icon'></i>" + title);
    }
    else {
        $('.gritter-title').html("<i class='fas fa-exclamation-circle error-icon'></i>" + title);
    }

    $('.gritter').append(msg);
    $('.gritter').slideDown('slow');

    setInterval(function () {
        $('.gritter').fadeOut();
    }, 4000);
}

function SaveEvaluation(form, url) {
    var form = $("#" + form);
    var formData = form.serialize();
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        error: function (data) {
            if (data.responseJSON) {
                var erros = Object.keys(data.responseJSON);

                var msg = "";

                erros.forEach(function (k) {
                    var erro = data.responseJSON[k][0];
                    msg = msg + "<span class='gritter-text'>" + erro + "</span>";
                    $('#' + k).addClass('error');
                });

                AddGritter('Erro', msg, 'error');
            }
        },
        success: function (data) {
            var msg = "<span class='gritter-text'>" + data.msg + "</span>";

            AddGritter(data.title, msg, 'success');


            window.location.href = data.redirect;
        },
    });
}

//-------------------------------ADMIN---------------------------------------
function EditModal(id, url, modalTitle, id2 = "") {
    $.ajax({
        url: '/edit' + url,
        type: 'GET',
        data: { 'id': id, 'id2': id2 },
        success: function (data) {
            $("#titleAdd").text(modalTitle);
            var prevKey = "";
            var prevValue = "";
            $.each(data, function (key, value) {
                if (prevKey == "checkbox") {
                    if (value == 1) {
                        $('#' + key).prop('checked', true);
                        $('#' + key).addClass('used');
                    }
                    else {
                        $('#' + key).prop('checked', false);
                    }
                }
                else
                    if (value != null) {
                        $('#' + key).val(value);
                        $('#' + key).addClass('used');
                    }

                if (jQuery.isPlainObject(value)) {
                    $.each(value, function (id, name) {
                        $("#" + key).append('<option value="' + id + '" id="' + key + '_' + id + '">' + name + ' </option>');
                    });
                    $("#" + key + '_' + prevValue).prop('selected', true);
                }
                prevKey = key;
                prevValue = value;
            });
        }
    });
}

function changeDropdown(url, paiId, selTarget, targetForm = "") {
    $.ajax({
        url: url + '/' + $("#" + paiId).val(),
        method: 'GET',
        success: function (data) {
            if (targetForm != "") {
                $('#' + targetForm + ' #' + selTarget).html(data.html);
            }
            else {
                $('#' + selTarget).html(data.html);
            }
        }
    });
}

function SearchInput(url, page = "", input = null) {
    var clear = input != null ? input.value == "" ? true : false : true;
    var campos = {};
    $.each($(".search-select"), function (i, el) {
        campos[el.id.split("-")[1]] = el.value;
    });

    var finalData = page != "" ?
        { 'campos': campos, 'search': $('input[type=search]').val(), 'clear': clear, 'page': page, } :
        { 'campos': campos, 'search': $('input[type=search]').val(), 'clear': clear };
    $.ajax({
        url: url,
        type: 'GET',
        data: finalData,
        success: function (data) {
            $(".resultsAdmin").html(data.html);
        }
    });
}

// function responsiveDisciplina(x) {
//     href = "{{ route('disciplina', ['id' => $d->id]) }}"
//     if (x.matches) { // If media query matches
//         $("#dropdownDisc").html('<i class="fas fa-book fa-2x i-nav-disc"></i>');
//         $("#containerDisc").html('<ul class="dropdown-menu" aria-labelledby="dLabel">\
//                                     @foreach($disciplinas as $d) \
//                                         <li><a href="'+ href + '" class="item-link">{{$d->nome}}</a></li> \
//                                     @endforeach\
//                                  </ul>');
//     } else {
//         $("#dropdownDisc").html('<i class="fas fa-book fa-2x i-nav-disc"></i>\
//                                  <a style="margin-left: 33px;">Disciplinas</a>\
//                                  <i id="i-disciplina" class="caret-icon fa fa-caret-down"></i>');
//         $("#containerDisc").html('<div class="dropdown-container">\
//                                     @foreach($disciplinas as $d)\
//                                         <a href="'+ href + '">{{$d->nome}}</a>\
//                                     @endforeach\
//                                  </div>');
//     }
// }

// var x = window.matchMedia("(max-width: 600px)")
// responsiveDisciplina(x) 
// x.addListener(responsiveDisciplina)

// function responsiveProjeto(x) {
//     var href_1 = "{{ route('disciplina', ['id' => $p->cadeira_id, 'tab' => 1, 'proj' => $p->id]) }}";
//     var href_2 = "{{ route('projeto', ['id' => $p->grupo_id]) }}"
//     if (x.matches) { // If media query matches
//         $("#dropdownProj").html('<i class="fas fa-clipboard-list fa-2x i-nav-proj"></i>');
//         $("#contairnerProj").html('<ul class="dropdown-menu" aria-labelledby="pLabel"> \
//                                     @foreach($projetos as $p) \
//                                         @if (Auth::user()->isProfessor()) \
//                                             <li><a href="' + href_1 + '" class="item-link">{{$p->nome}}</a></li>\
//                                         @else \
//                                             <li><a href="' + href_2 + '" class="item-link">{{$p->nome}}</a></li>\
//                                         @endif\
//                                     @endforeach\
//                                  </ul>');
//     } else {
//         $("#dropdownProj").html('<i class="fas fa-clipboard-list fa-2x i-nav-proj">\
//                                  </i><a style="margin-left: 39px;">Projetos</a>\
//                                  <i id="i-projeto" class="caret-icon fa fa-caret-down"></i>');
//         $("#containerProj").html('<div class="dropdown-container">\
//                                     @if (Auth::user()->isProfessor())\
//                                         @foreach($projetos as $p)\
//                                         <a href="' + href_1 + '">{{$p->nome}}</a>\
//                                         @endforeach\
//                                     @else\
//                                         @foreach($projetos as $p)\
//                                         <a href="' + href_2 + '">{{$p->nome}}</a>\
//                                         @endforeach\
//                                     @endif\
//                                  </div>');
//     }
// }

// var x = window.matchMedia("(max-width: 600px)")
// responsiveProjeto(x) 
// x.addListener(responsiveProjeto)
