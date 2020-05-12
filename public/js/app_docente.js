function closeForm() {
    $('.model-content').hide();
}

function ShowPagInicial() {
    $(".discpContainer").css('display', 'none');
    $("#pagInicial").css('display', 'block');
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

function TabActive(tab) {
    $("#" + tab).addClass('active');
    $("#" + tab).trigger('click');
}