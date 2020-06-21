<?php $__env->startSection('content'); ?>

<div class="row-title">
    <h2>Disciplina</h2>
    <button type="button" class="btn-title"><i class="fas fa-plus"></i> Adicionar </button>
</div>

<div class="nav-tabs">
      <div class="tab" id="tab1" onclick="changeTab(1)">Página Inicial </div>
      <div class="tab" id="tab2" onclick="changeTab(2)"> Avaliação </div>
      <div class="tab" id="tab3" onclick="changeTab(3)"> Horários </div>
      <div class="tab" id="tab4" onclick="changeTab(4)"> Alunos </div>
</div>

<div class="tab-container" id="tab-1">
    <?php echo $__env->make('disciplina.pagInicial', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="tab-container" id="tab-2">
    Avaliação
</div>

<div class="tab-container" id="tab-3">
    Horário
</div>

<div class="tab-container" id="tab-4">
    Alunos
    <!-- <?php echo $__env->make('disciplina.lista_alunos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> -->
</div>

<div class="tab-container forum" id="tab-5">
    <?php echo $__env->make('disciplina.forum', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="tab-container forumMensagens" id="tab-6">
    <?php echo $__env->make('disciplina.forumMensagens', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="tab-container" id="tab-7">
    <?php echo $__env->make('disciplina.grupos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>


<script>
    $(document).ready(function () {
        changeTab(<?php echo $active_tab ?>);
    });

    // function ShowGrupos(id) {
    //     $.ajax({
    //         url: '/showGrupos',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: 'success',
    //         data: {'id': id},
    //         success: function(data){
    //             $(".disciplina_tab").removeClass('active');
    //             $(".discpContainer").css('display', 'none');
    //             $("#grupos").html(data.html);
    //             $("#grupos").css('display', 'block');
    //             $("#show_" + id).attr("onclick","HideGrupos(" + id + ")");
    //             $("#show_" + id).html("Esconder grupos <i class='fa fa-users'></i>");
    //         }
    //     });
    // }

    // function HideGrupos(id) {
    //     $(".discpContainer").css('display', 'none');
    //     $("#pagInicial").css('display', 'block');
    //     $("#tab1").addClass('active');
    //     $("#show_" + id).attr("onclick","ShowGrupos(" + id + ")");
    //     $("#show_" + id).html("Ver grupos <i class='fa fa-users'></i>");
    // }

    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });

    function CriarProjeto() {
        $('.model-content').hide();
        $('#projetoModal').show();
    }

    function AddFile(title) {
        $('.model-content').hide();
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    // function closeForm() {
    //     $('.model-content').hide();
    // }

    // $(document).mouseup(function(e) {
    //     var container = $("#dropAdd");
    //     if ((!container.is(e.target) && container.has(e.target).length === 0)){
    //         container.hide();
    //     }
    //     else {
    //         container.show();
    //     }
    // });

    // $("#dropAdd").hide();

    // $("#btnAdd").click(function(){
    //     $("#dropAdd").show();
    // }); 
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>