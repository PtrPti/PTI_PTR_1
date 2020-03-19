function ShowRegistoAluno() {
    $("#formProfessor").css('display', 'none');
    $("#formAluno").css('display', 'block');
    $("#registoProfessor").removeClass("registo-active");
    $("#registoAluno").addClass("registo-active");
};

function ShowRegistoProfessor() {
    $("#formAluno").css('display', 'none');
    $("#formProfessor").css('display', 'block');
    $("#registoAluno").removeClass("registo-active");
    $("#registoProfessor").addClass("registo-active");
};