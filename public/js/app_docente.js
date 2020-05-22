function closeForm() {
    $('.model-content').hide();
}

function ShowPagInicial() {
    $(".discpContainer").css('display', 'none');
    $("#pagInicial").css('display', 'flex');
    $("#tab3").removeClass('active');
    $("#tab2").removeClass('active');
    $("#tab1").addClass('active');
}

function ShowAvaliacao() {
    $(".discpContainer").css('display', 'none');
    $("#avaliacao").css('display', 'block');
    $("#tab3").removeClass('active');
    $("#tab1").removeClass('active');
    $("#tab2").addClass('active');
}

function ShowHorario() {
    $(".discpContainer").css('display', 'none');
    $("#horario").css('display', 'block');
    $("#tab1").removeClass('active');
    $("#tab2").removeClass('active');
    $("#tab3").addClass('active');
}

function IndexDocente() {
    window.location.href = '/docenteHome'
}

function TabActive(tab) {
    $("#" + tab).addClass('active');
    $("#" + tab).trigger('click');
}

function ShowForum(id) {
    $.ajax({
        url: '/getForum',
        type: 'GET',
        dataType: 'json',
        success: 'success',
        data: { 'id': id },
        success: function (data) {
            $(".discpContainer").css('display', 'none');
            $("#forum").replaceWith(data.html);
            $("#forum").css('display', 'flex');
        }
    });
}

function ShowPagInicialDiscDoc(id) {
    $.ajax({
        url: '/getPagInicial',
        type: 'GET',
        dataType: 'json',
        success: 'success',
        data: { 'id': id },
        success: function (data) {
            $(".discpContainer").css('display', 'none');
            $("#pagInicial").replaceWith(data.html);
            $("#pagInicial").css('display', 'flex');
        }
    });
}

function ShowPage(id, url, targetDiv, openForm) {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: 'success',
        data: { 'id': id },
        success: function (data) {
            $(".discpContainer").css('display', 'none');
            $("#" + targetDiv).replaceWith(data.html);
            $("#" + targetDiv).css('display', 'flex');
            $(openForm).trigger('click');
        }
    });
}