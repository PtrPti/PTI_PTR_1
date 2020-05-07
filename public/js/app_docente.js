function ShowProjetos() {
    $("#disciplinas").css('display', 'none');
    $("#projetos").css('display', 'block');
    $("#tab1").removeClass('active');
    $("#tab2").addClass('active');
}

function ShowHome() {
    $("#projetos").css('display', 'none');
    $("#disciplinas").css('display', 'flex');
    $("#tab2").removeClass('active');
    $("#tab1").addClass('active');
}

function closeForm() {
    $('.model-content').hide();
}