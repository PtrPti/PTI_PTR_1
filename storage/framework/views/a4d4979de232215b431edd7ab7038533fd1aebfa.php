<?php $__env->startSection('content'); ?>

<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 

    <div class="flex-left">
        <div class="nav_icons_back">
            <div class="" onclick="IndexDocente()"><img src="<?php echo e(asset('images/home_icon.png')); ?>"> Home </div>
            <div class="has-dropdown"><img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>"> Disciplinas 
                <ul class="dropdown">
                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="dropdown-item">
                            <a href="<?php echo e(route('indexDisciplinaDocente', ['id' => $d->id])); ?>" class="item-link"><?php echo e($d->nome); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="has-dropdown"><img src="<?php echo e(asset('images/projetos_icon.png')); ?>"> Projetos 
                <ul class="dropdown">
                    <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="dropdown-item">
                        <a href="<?php echo e(route('id_projeto', ['id' => $p->id])); ?>" class="item-link"><?php echo e($p->nome); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>

        <button id="btnAdd"><img src="<?php echo e(asset('images/plus_docente.png')); ?>" width="23"><span>Criar/Adicionar</span></button>
        <div id="dropAdd">
            <span onclick="AddFile('Enunciado')"><i class="fas fa-file-import"></i>Enunciado </span>
            <a href="https://www.google.com/drive/"><span ><i class="fab fa-google-drive"></i>Google Drive</span></a>
            <a href="https://github.com/"><span><i class="fab fa-github"></i>Github</span></a>
            <span ><i class="far fa-sticky-note"></i>Notas</span>
        </div>
    </div>

    <div id="all1" class="popUpBack">
        <div id="addSite" class='popupDiv'>
            <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
            <h4>Adicione um Link</h4>
            <form id="formAddLink">
                </select>
                <input type="text" name='nome' placeholder="nome..."><br>
                <input type="url" name='url' placeholder="URL..."><br>
                <input type="submit" value='Adicionar'>
            </form>
        </div>
    </div>
        
    <div class="flex-right1">
        <div class="flex-right-header1">
            <h2><?php echo e($projeto->nome); ?></h2>
            <h3>Disciplina: <a href="<?php echo e(route('indexDisciplinaDocente', $cadeira->id)); ?>"><?php echo e($cadeira->nome); ?></a></h3>
        </div>
        <div class="flex-right-container">
            <h4>Grupos inscritos:  <?php echo e($gruposcount); ?></h4>
            <table class="tableGrupos">
                <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="grupo_<?php echo e($grupo->id); ?>">
                    <td>
                        <?php if($grupo->total_membros == 0): ?>
                            <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                        <?php endif; ?>
                    </td>
                    <td><a href="<?php echo e(route('GrupoDocente', $grupo->id)); ?>" >Grupo <?php echo e($grupo->numero); ?></a></td>
                    <td><?php echo e($grupo->total_membros); ?>/<?php echo $max_elementos ?></td>
                    <td><?php echo e($grupo->elementos); ?></td>
                    <td>
                    <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($feedback->grupo_id == $grupo->id ): ?>
                            <?php if($feedback->vista_docente == 0): ?>
                            <div class="led-box">
                                <div class="led-green"></div>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>
</div>

<script>
    $("#openNotepad").click(function() {});

    function CriarProjeto() {
        $('.model-content').hide();
        $('#projetoModal').show();
    }

    function AddFile(title) {
        $('.model-content').hide();
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    function closeForm() {
        $('.model-content').hide();
    }

    $(document).mouseup(function(e) {
        var container = $("#dropAdd");
        if ((!container.is(e.target) && container.has(e.target).length === 0)){
            container.hide();
        }
        else {
            container.show();
        }
    });

    $("#dropAdd").hide();

    $("#btnAdd").click(function(){
        $("#dropAdd").show();
    }); 

    $(".closebtn").click(function(){
        ($($(this).parent()).parent()).hide();
    });

    function Showfeedback() {
        document.getElementById("chat").style.display = "block";
    }
    function closeForm() {
        document.getElementById("chat").style.display = "none";
    }

    function AddFile(title) {
        $('.model-content').hide();
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    $(".popUpBack").hide();

    $(".siteadd").click(function(){
        $("#all1").show();
    }); 
    // Feedback

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("btgrupos");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("closef")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
// more feedback content
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>