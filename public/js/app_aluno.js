$(document).ready(function () {
  $(".pagInicia_btn").css("background-color", "#eee9e9")
  $(".pagInicial").show()
  $(".avalDisciplina").hide()
  $(".horariosDisciplinas").hide()
  $(".pagTrabalhos").hide()

  $(".forumDuvidas").hide();

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


  // ------------------------------------ PAGINA INICIAL ------------------------------------ //
  $(".pagInicia_btn").click(function () {
    //Botoes 
    $(".pagInicia_btn").hover(function () {
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

    $(".pagInicia_btn").css("background-color", "#eee9e9")
    $(".avaliacao_btn").css("background-color", "#f5f8fa")
    $(".horarios_btn").css("background-color", "#f5f8fa")
    $(".trabalho_btn").css("background-color", "#f5f8fa")

    //Informação respetiva
    $(".pagInicial").show()
    $(".avalDisciplina").hide()
    $(".horariosDisciplinas").hide()
    $(".pagTrabalhos").hide()
  });

  // ------------------------------------ AVALIACAO ------------------------------------ //
  $(".avaliacao_btn").click(function () {
    //Botoes
    $(".pagInicia_btn").hover(function () {
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

    $(".pagInicia_btn").css("background-color", "#f5f8fa")
    $(".avaliacao_btn").css("background-color", "#eee9e9")
    $(".horarios_btn").css("background-color", "#f5f8fa")
    $(".trabalho_btn").css("background-color", "#f5f8fa")

    //Informação respetiva
    $(".pagInicial").hide()
    $(".avalDisciplina").show()
    $(".horariosDisciplinas").hide()
    $(".pagTrabalhos").hide()
  });

  // ------------------------------------ HORARIOS ------------------------------------ //
  $(".horarios_btn").click(function () {
    //Botoes
    $(".pagInicia_btn").hover(function () {
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

    $(".pagInicia_btn").css("background-color", "#f5f8fa")
    $(".avaliacao_btn").css("background-color", "#f5f8fa")
    $(".horarios_btn").css("background-color", "#eee9e9")
    $(".trabalho_btn").css("background-color", "#f5f8fa")

    //Informação respetiva
    $(".pagInicial").hide()
    $(".avalDisciplina").hide()
    $(".horariosDisciplinas").show()
    $(".pagTrabalhos").hide()
  });

  // ------------------------------------ TRABALHOS ------------------------------------ //
  $(".trabalho_btn").click(function () {
    //Botoes
    $(".pagInicia_btn").hover(function () {
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

    $(".pagInicia_btn").css("background-color", "#f5f8fa")
    $(".avaliacao_btn").css("background-color", "#f5f8fa")
    $(".horarios_btn").css("background-color", "#f5f8fa")
    $(".trabalho_btn").css("background-color", "#eee9e9")

    //Informação respetiva
    $(".pagInicial").hide()
    $(".avalDisciplina").hide()
    $(".horariosDisciplinas").hide()
    $(".pagTrabalhos").show()
  });

  $("#add_topico").click(function () {
    $("#myModal").css("display", "block");
  });

  $(".close").click(function () {
    $("#myModal").css("display", "none");
  });

  $(".forumDuvidas_btn").click(function () {
    $(".forumDuvidas").show();
    $(".infDisciplina").hide();
  });

  $(".return_pagIni").click(function () {
    $(".forumDuvidas").hide();
    $(".infDisciplina").show();
  });

});

//---------------------------------------------------------------//

$("#add_topico").click(function () {
  $("#myModal").css("display", "block");
});

$(".close").click(function () {
  $("#myModal").css("display", "none");
})

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == $("#myModal")) {
    $("#myModal").css("display", "none");
  }
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

  $(".add_mensagem").click(function () {
    $(".addMensagem").show()
  });
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

$("#add_mensagem").click(function () {
  $("#novaMensagem").css("display", "block");
});

$(".close").click(function () {
  $("#novaMensagem").css("display", "none");
})

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == $("#novaMensagem")) {
    $("#novaMensagem").css("display", "none");
  }
}

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
  document.getElementById("navbar").style.top = "-50px";
}
