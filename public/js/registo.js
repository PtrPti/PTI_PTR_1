function ShowRegistoAluno() {
    $("#formProfessor").css('display', 'none');
    $("#formAluno").css('display', 'block');
    $("#registoProfessor").removeClass("registo-active");
    $("#registoAluno").addClass("registo-active");

    $("#name2").val('');
    $("#numero2").val('');
    $("data_nascimento2").val('');
    $("departamento_id2").val('');
    $("#email2").val('');
    $("password2").val('');
    $("password-confirm2").val('');
};

function ShowRegistoProfessor() {
    $("#formAluno").css('display', 'none');
    $("#formProfessor").css('display', 'block');
    $("#registoAluno").removeClass("registo-active");
    $("#registoProfessor").addClass("registo-active");

    $("#name").val('');
    $("#numero").val('');
    $("data_nascimento").val('');
    $("departamento_id").val('');
    $("curso_id").val('');
    $("grau_academico_id").val('');
    $("#email").val('');
    $("password").val('');
    $("password-confirm").val('');
};