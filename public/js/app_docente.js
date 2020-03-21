function ShowProjetos() {
    $("#disciplinas").css('display', 'none');
    $("#projetos").css('display', 'block');
    $("#homeBtn").removeClass('active');
    $("#projetosBtn").addClass('active');
}

function ShowHome() {
    $("#projetos").css('display', 'none');
    $("#disciplinas").css('display', 'flex');
    $("#projetosBtn").removeClass('active');
    $("#homeBtn").addClass('active');
}

function closeForm() {
    $(".bg-modal").css('display', 'none');
} 