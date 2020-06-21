$(window, document, undefined).ready(function () {
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