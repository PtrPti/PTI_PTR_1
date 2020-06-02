$(document).ready(function () {
  $(".grupo_favorito").hover(function () {
    document.getElementsByClassName('grupo_favorito').src = "{{ asset('images/favoritoo2.png') }}"
  });

  $(".pagInicial_btn").css("background-color", "#eee9e9")
  $(".pagInicial").show()
  $(".avalDisciplina").hide()
  $(".horariosDisciplinas").hide()
  $(".pagTrabalhos").hide()

  $(".avaliacao_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".horarios_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".trabalho_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $("#add_topico").click(function () {
    $("#myModal").css("display", "block");
  });

  $(".close").click(function () {
    $("#myModal").css("display", "none");
  })

  $(".add_mensagem").click(function () {
    $(".addMensagem").show()
  });

  $(".return_pagIni").click(function () {
    $(".forumDuvidas").hide();
    $(".infDisciplina").show();
  });

  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - 
  This allows the user to have multiple dropdowns without any conflict */
  //Disciplinas
  var dropdown = document.getElementsByClassName("dropdown-btn disc");
  var x;

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

// ------------------------------------ PAGINA INICIAL ------------------------------------ //
function show_pagInicial() {
  //Botoes 
  $(".pagInicial_btn").hover(function () {
    $(this).css("background-color", "#eee9e9");
  }, function () {
    $(this).css("background-color", "#eee9e9");
  });

  $(".avaliacao_btn").hover(function () {
    $(this).css("background-color", "e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".horarios_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".trabalho_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".pagInicial_btn").css("background-color", "#eee9e9")
  $(".avaliacao_btn").css("background-color", "#f5f8fa")
  $(".horarios_btn").css("background-color", "#f5f8fa")
  $(".trabalho_btn").css("background-color", "#f5f8fa")

  //Informação respetiva
  $(".pagInicial").show()
  $(".avalDisciplina").hide()
  $(".horariosDisciplinas").hide()
  $(".pagTrabalhos").hide()
}

function return_pagInicial() {
  $(".infDisciplina").show()
  $(".forumDuvidas").hide()
  $(".divMensagens").hide()
}

function showForum(cadeira_id) {
  $(".forumDuvidas").show();
  $(".infDisciplina").hide();

  $.ajax({
    url: '/showForum',
    type: 'GET',
    dataType: 'json',
    success: 'success',
    data: { 'cadeira_id': cadeira_id },
    success: function (data) {
      $(".forumDuvidas").empty();
      $(".forumDuvidas").append(data.html);
    }
  });
}

function return_forum() {
  $(".infDisciplina").hide()
  $(".forumDuvidas").show()
  $(".divMensagens").hide()
}

function verMensagens(id) {
  $(".forumDuvidas").hide();
  $(".divMensagens").show();
  $.ajax({
    url: '/verMensagens',
    type: 'GET',
    dataType: 'json',
    success: 'success',
    data: { 'id': id },
    success: function (data) {
      $(".divMensagens").empty();
      $(".divMensagens").append(data.html);
    }
  });
}

function Responder() {
  var div = document.getElementById("yourDivElement");
  var input = document.createElement("textarea");
  var button = document.createElement("button");
  input.name = "post";
  input.maxLength = "5000";
  input.cols = "80";
  input.rows = "40";
  div.appendChild(input); //appendChild
  div.appendChild(button);
}

// ------------------------------------ AVALIACAO ------------------------------------ //
function show_avaliacao() {
  //Botoes
  $(".pagInicial_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".avaliacao_btn").hover(function () {
    $(this).css("background-color", "#eee9e9");
  }, function () {
    $(this).css("background-color", "#eee9e9");
  });

  $(".horarios_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".trabalho_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".pagInicial_btn").css("background-color", "#f5f8fa")
  $(".avaliacao_btn").css("background-color", "#eee9e9")
  $(".horarios_btn").css("background-color", "#f5f8fa")
  $(".trabalho_btn").css("background-color", "#f5f8fa")

  //Informação respetiva
  $(".pagInicial").hide()
  $(".avalDisciplina").show()
  $(".horariosDisciplinas").hide()
  $(".pagTrabalhos").hide()
}

// ------------------------------------ HORARIOS ------------------------------------ //
function show_horarios() {
  //Botoes
  $(".pagInicial_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".avaliacao_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".horarios_btn").hover(function () {
    $(this).css("background-color", "#eee9e9");
  }, function () {
    $(this).css("background-color", "#eee9e9");
  });

  $(".trabalho_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".pagInicial_btn").css("background-color", "#f5f8fa")
  $(".avaliacao_btn").css("background-color", "#f5f8fa")
  $(".horarios_btn").css("background-color", "#eee9e9")
  $(".trabalho_btn").css("background-color", "#f5f8fa")

  //Informação respetiva
  $(".pagInicial").hide()
  $(".avalDisciplina").hide()
  $(".horariosDisciplinas").show()
  $(".pagTrabalhos").hide()
}

// ------------------------------------ TRABALHOS ------------------------------------ //
function show_trabalho() {
  //Botoes
  $(".pagInicial_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".avaliacao_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".horarios_btn").hover(function () {
    $(this).css("background-color", "#e6e16c");
  }, function () {
    $(this).css("background-color", "#f5f8fa");
  });

  $(".trabalho_btn").hover(function () {
    $(this).css("background-color", "#eee9e9");
  }, function () {
    $(this).css("background-color", "#eee9e9");
  });

  $(".pagInicial_btn").css("background-color", "#f5f8fa")
  $(".avaliacao_btn").css("background-color", "#f5f8fa")
  $(".horarios_btn").css("background-color", "#f5f8fa")
  $(".trabalho_btn").css("background-color", "#eee9e9")

  //Informação respetiva
  $(".pagInicial").hide()
  $(".avalDisciplina").hide()
  $(".horariosDisciplinas").hide()
  $(".pagTrabalhos").show()
}

function ShowGruposA(id) {
  $(".projetosDisciplina").hide()
  $(".infProjeto").show()

  $.ajax({
    url: '/showGruposA',
    type: 'GET',
    dataType: 'json',
    success: 'success',
    data: { 'id': id },
    success: function (data) {
      $(".inforcao_projeto").empty();
      $(".inforcao_projeto").append(data.html);
    }
  });
}

function return_trabalho() {
  $(".projetosDisciplina").show()
  $(".infProjeto").hide()
}
//---------------------------------------------------------------//

//Forum

// Get the modal
// var modal = document.getElementById("myModal");

// Get the button that opens the modal
// var btn = document.getElementById("add_topico");

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function () {
//   modal.style.display = "block";
// }



// When the user clicks on <span> (x), close the modal
// span.onclick = function () {
//   
// }

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function (event) {
//   if (event.target == $("#myModal")) {
//     $("#myModal").css("display", "none");
//   }
// }
// // Get the modal
// var modal = document.getElementById("novaMensagem");

// // Get the button that opens the modal
// var btn = document.getElementById("add_mensagem");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function () {
//   modal.style.display = "block";
// }

// When the user clicks on <span> (x), close the modal
// span.onclick = function () {
//   modal.style.display = "none";
// }

// $("#add_mensagem").click(function () {
//   alert("oi");
//   $("#novaMensagem").css("display", "block");
// });

// $(".close").click(function () {
//   $("#novaMensagem").css("display", "none");
// })

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function (event) {
//   if (event.target == $("#novaMensagem")) {
//       $("#novaMensagem").css("display", "none");
//   }
// }

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
  document.getElementById("navbar").style.top = "-50px";
}