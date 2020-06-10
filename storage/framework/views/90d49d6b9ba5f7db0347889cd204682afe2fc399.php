<?php $__env->startSection('content'); ?>

<div id="apps" class="sticky">
  <div class="nav_icons_home">
    <div style="border-bottom: 1.5px solid #e6e16c;">
        <a href="<?php echo e(route('alunoHome')); ?>"> <img src="<?php echo e(asset('images/home_icon.png')); ?>" width=23px> Home </a>
    </div>

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>" width=23px> Disciplinas
        </button>
        <ul class="dropdown-menu">
            <?php $__currentLoopData = $cadeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e(route('pagDisciplina', ['cadeira_id' => $disciplina->id])); ?>"> <?php echo e($disciplina->nome); ?> </a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <img src="<?php echo e(asset('images/projetos_icon.png')); ?>" width=23px> Projetos
        </button>
        <ul class="dropdown-menu">
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('pagProjeto', ['id' => $proj->id])); ?>"> <?php echo e($proj->projeto); ?> | Grupo Nº<?php echo e($proj->numero); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>      
  </div>
</div>

<div class=pagProjeto>
    <h1><?php echo e($projeto->nome); ?>  |  Grupo Nº<?php echo e($grupo->numero); ?>  <small>  <?php echo e($disciplina->nome); ?></small></h1>
    <?php $__currentLoopData = $nomesUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h2><?php echo e($nome->nome); ?></h2>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
    
</div>

<div id='esqdrt'>
    <div id="esq">
        <div id="divAdd">
			<button id="btnAdd" ><img src="<?php echo e(asset('images/plus.png')); ?>" width="23"><span>Adicionar</span></button>
			<div id="dropAdd">
                <a class="pastaadd" ><img src="<?php echo e(asset('images/addpasta.png')); ?>" width="40"><span>Pasta</span></a>
                <hr>
                <a class="uploadFile" ><img src="<?php echo e(asset('images/uploadficheiro.png')); ?>" width="40"><span>Carregar Ficheiro</span></a>
				<label class="addLabel"><img src="<?php echo e(asset('images/uploadpasta.png')); ?>" width="40">Carregar Pasta<input type="file"></label>
				<hr>
				<a class="siteadd"><img src="<?php echo e(asset('images/link.png')); ?>" width="37"><span>Site</span></a>
				<a class="siteadd"><img src="<?php echo e(asset('images/drive.png')); ?>" width="37"><span>Google Drive</span></a>
				<a class="siteadd"><img src="<?php echo e(asset('images/github.png')); ?>" width="37"><span>Github</span></a>
				<hr>
                <a class="taskadd"><img src="<?php echo e(asset('images/addtarefa.png')); ?>"width="40"><span>Tarefa</span></a>
                <a class="taskSubadd"><img src="<?php echo e(asset('images/addtarefa.png')); ?>"width="40"><span>Subtarefa</span></a>
				<hr>
				<a class="notaAdd"><img src="<?php echo e(asset('images/nota.png')); ?>" width="40"><span>Nota</span></a>
			</div>
		</div>

        <!-- Popup Adicionar site/link -->
        <div id="all1" class="popUpBack">
			<div id="addSite" class='popupDiv'>
                <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
                <h4>Adicione um Link</h4>
                <form id="formAddLink">
                    <label for="p">Pasta</label>
                    <select name='Pasta' id='p'>
                        <option value=''>Nenhuma</option>
                        <?php $__currentLoopData = $ficheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($ficheiro->is_folder): ?>
                                <option value="<?php echo e($ficheiro->id); ?>"><?php echo e($ficheiro->nome); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    </select><br>
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="url" name='url' placeholder="URL..."><br>
                    <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>"><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Tarefa -->
		<div id="all2" class="popUpBack">
			<div id="addTarefa" class='popupDiv'>
            <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
            <h4>Adicione uma Tarefa</h4>
                <form id='formAddTarefa'>
                    <label for='nT'>Nome: </label>
                    <input type="text" name='nome' id='nT' placeholder="tarefa..."><br>
                    <label for="tarefaPrincipal">Adicionar:</label>
                    <select name='ordem' id='tarefaPrincipal' require>
                        <option value="0" >Inicio</option>
                        <?php $__currentLoopData = $tarefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(is_null($tarefa->tarefa_id)): ?>
                                <option value="<?php echo e($tarefa->ordem); ?>">Depois de: <?php echo e($tarefa->nome); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    </select><br>
                    <label for='dtT'>Prazo: </label>
                    <input type="date" name='prazo' id='dtT' ><br>
                    <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>">
                    <input type="hidden" name='projetoId' value="<?php echo e($projeto->id); ?>">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
        </div>

        <!-- Popup Adicionar Subtarefa -->
        <div id="all5" class="popUpBack">
			<div id="addSubTarefa" class='popupDiv'>
            <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
            <h4>Adicione uma Subtarefa</h4>
                <form id='formAddSubTarefa'>
                    <label for='nT'>Nome: </label>
                    <input type="text" name='nome' id='nT' placeholder="tarefa..."><br>
        
                    <label for="slc">Tarefa principal:</label>
                    <select name='tarefaId' id='slc' require>
                        <?php $__currentLoopData = $tarefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(is_null($tarefa->tarefa_id)): ?>
                                <option value="<?php echo e($tarefa->id); ?>"><?php echo e($tarefa->nome); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select><br>

                    <label for="oT2">Adicionar: </label>
                    <select name='ordem' id='subtarefasId' require>
                        <option value="0" >Inicio</option>
                    </select><br>

                    <label for='dtT2'>Prazo: </label>
                    <input type="date" name='prazo' id='dtT2' ><br>

                    <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>">
                    <input type="hidden" name='projetoId' value="<?php echo e($projeto->id); ?>">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Pasta -->
        <div id="all3" class="popUpBack" >
			<div id="addPasta" class='popupDiv'>
                <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
                <h4>Adicione uma Pasta</h4>
                <form id="formAddPasta">
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
        </div>
        
        <!-- Popup Adicionar Ficheiro -->
        <div id="all4" class="popUpBack">
			<div id="addPasta" class='popupDiv'>
                <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
                <h4>Adicione um Ficheiro</h4>
                
                <form id="formUploadFicheiro" action="<?php echo e(route ('uploadFicheiro')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <label for="pastaaa">Pasta</label>
                    <select name='Pasta' id="pastaaa">  
                        <option value=''>Nenhuma</option>
                        <?php $__currentLoopData = $ficheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($ficheiro->is_folder): ?>
                                <option value="<?php echo e($ficheiro->id); ?>"><?php echo e($ficheiro->nome); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    </select><br>
                    <input type="file" name='ficheiro' placeholder="ficheiro...">
                    <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>">
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>

        <!-- Popup Adicionar Nota -->
        <div id="all6" class="popUpBack">
            <div id="addNota" class='popupDiv'>
                <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
                <h4>Adicione uma Nota</h4>
                <form id="formAddNotaGrupo">
                    <label for="pastaaa">Pasta</label>
                    <select name='Pasta' id='pastaaa'>
                        <option value=''>Nenhuma</option>
                        <?php $__currentLoopData = $ficheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($ficheiro->is_folder): ?>
                                <option value="<?php echo e($ficheiro->id); ?>"><?php echo e($ficheiro->nome); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    </select><br>
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>"><br>
                    <input type="hidden" name='tipo' value="grupo"><br>
				    <input type="submit" value='Adicionar'>
                </form>
            </div>
        </div>

        <!-- Popup Escolher Ficheiros -->
        <div id="all7" class="popUpBack">
            <div id="addSubmissao" class='popupDiv'>
                <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
                <h4>Selecione</h4>
                
                    <?php $__currentLoopData = $ficheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($ficheiro->is_folder): ?>
                            <label class='inpt1'>
                                <input type="checkbox" class='fichIds' name="checkFich" value="<?php echo e($ficheiro->id); ?>">
                                <img src="<?php echo e(asset('images/folder.png')); ?>" width="20"><?php echo e($ficheiro->nome); ?>

                            </label>
                            <?php $__currentLoopData = $ficheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subficheiro->pasta_id === $ficheiro->id): ?>
                                    <?php if( $subficheiro->link != "" and is_null($subficheiro->notas)): ?>
                                        <label class='inpt2'>
                                            <input type="checkbox" class='fichIds' name="checkFich"  value="<?php echo e($subficheiro->id); ?>">
                                            <?php if(str_contains($subficheiro->link, 'drive.google.com')): ?>
                                                <img src="<?php echo e(asset('images/drive.png')); ?>" width="20">
                                            <?php elseif(str_contains($subficheiro->link, 'github.com')): ?>
                                                <img src="<?php echo e(asset('images/github.png')); ?>" width="23">
                                            <?php else: ?> 
                                                <img src="<?php echo e(asset('images/link.png')); ?>" width="21">
                                            <?php endif; ?>
                                            <?php echo e($subficheiro->nome); ?>

                                        </label>
                                    <?php elseif( ! is_null($subficheiro->notas) ): ?>
                                        <label class='inpt2'>
                                            <input type="checkbox" class='fichIds' name="checkFich"  value="<?php echo e($subficheiro->id); ?>">
                                            <img src="<?php echo e(asset('images/nota.png')); ?>" width="20"><?php echo e($subficheiro->nome); ?>

                                        </label>
                                    <?php else: ?>
                                        <label class='inpt2'>
                                            <input type="checkbox" class='fichIds' name="checkFich"  value="<?php echo e($subficheiro->id); ?>">
                                            <img src="<?php echo e(asset('images/file.png')); ?>" width="20"><?php echo e($subficheiro->nome); ?>

                                        </label>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
                        <?php elseif( $ficheiro->is_folder == false and is_null($ficheiro->pasta_id)): ?>
                            <?php if( ! is_null($ficheiro->link) and is_null($ficheiro->notas)): ?>
                                <label class='inpt1'>
                                    <input type="checkbox" class='fichIds' name="checkFich" value="<?php echo e($ficheiro->id); ?>" >
                                    <?php if(str_contains($ficheiro->link, 'drive.google.com')): ?>
                                        <img src="<?php echo e(asset('images/drive.png')); ?>" width="20">
                                    <?php elseif(str_contains($ficheiro->link, 'github.com')): ?>
                                        <img src="<?php echo e(asset('images/github.png')); ?>" width="23">
                                    <?php else: ?> 
                                        <img src="<?php echo e(asset('images/link.png')); ?>" width="21">
                                    <?php endif; ?>
                                    <?php echo e($ficheiro->nome); ?>

                                </label>
                            <?php elseif( ! is_null($ficheiro->notas) ): ?>
                                <label class='inpt1'>
                                    <input type="checkbox" class='fichIds' name="checkFich" value="<?php echo e($ficheiro->id); ?>" >
                                    <img src="<?php echo e(asset('images/nota.png')); ?>" width="20"><?php echo e($ficheiro->nome); ?>

                                </label>
                            <?php else: ?>
                                <label class='inpt1'>
                                    <input type="checkbox" class='fichIds' name="checkFich" value="<?php echo e($ficheiro->id); ?>" >
                                    <img src="<?php echo e(asset('images/file.png')); ?>" width="20"><?php echo e($ficheiro->nome); ?>

                                </label>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  	
                    <button onclick="selectFicheiros()">Guardar</button>
            </div>
        </div>


        <div id="all8" class="popUpBack" >
			<div id="feedbackdone" class='popupDiv'>
                <img class='closebtn' src="<?php echo e(asset('images/cancel.png')); ?>">
			</div>
        </div>

        <!-- Lado esquerdo - pastas e ficheiros -->
        <div id="esqcontainer">
        <?php $__currentLoopData = $ficheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($ficheiro->is_folder): ?>
                <div class="folder1">
                    <a class="item1">
                        <img src="<?php echo e(asset('images/folder.png')); ?>" width="25">
                        <span><?php echo e($ficheiro->nome); ?></span>
                    </a>
                    <?php $__currentLoopData = $subFicheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($subficheiro->pasta_id === $ficheiro->id): ?>
                            <div class="folder2">
                                <?php if( $subficheiro->link != "" and is_null($subficheiro->notas)): ?>
                                    <a class="item2" href="<?php echo e($subficheiro->link); ?>">
                                        <?php if(str_contains($subficheiro->link, 'drive.google.com')): ?>
                                            <img src="<?php echo e(asset('images/drive.png')); ?>" width="23">
                                        <?php elseif(str_contains($subficheiro->link, 'github.com')): ?>
                                            <img src="<?php echo e(asset('images/github.png')); ?>" width="23">
                                        <?php else: ?> 
                                            <img src="<?php echo e(asset('images/link.png')); ?>" width="21">
                                        <?php endif; ?>
                                        <span><?php echo e($subficheiro->nome); ?></span> 
                                    </a>
                                <?php elseif( ! is_null($subficheiro->notas) ): ?>
                                    <a class="item2" href="#" onclick="infoNota('grupo',<?php echo e($subficheiro->id); ?>)">
                                        <img src="<?php echo e(asset('images/nota.png')); ?>" width="23">
                                        <span><?php echo e($subficheiro->nome); ?></span>
                                    </a> 
                                <?php else: ?>
                                    <a class="item2" href="<?php echo e(url('/downloadF', $subficheiro->id.'.'.explode('.', $subficheiro->nome, 2)[1])); ?>">
                                        <img src="<?php echo e(asset('images/file.png')); ?>" width="25">
                                        <span><?php echo e($subficheiro->nome); ?></span>
                                    </a> 
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
                </div>
            <?php elseif( $ficheiro->is_folder == false and is_null($ficheiro->pasta_id)): ?>
                <?php if( ! empty($ficheiro->link) and is_null($ficheiro->notas)): ?>
                    <a class="item1" href="<?php echo e($subficheiro->link); ?>">
                        <?php if(str_contains($ficheiro->link, 'drive.google.com')): ?>
                            <img src="<?php echo e(asset('images/drive.png')); ?>" width="23">
                        <?php elseif(str_contains($ficheiro->link, 'github.com')): ?>
                            <img src="<?php echo e(asset('images/github.png')); ?>"  width="23">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/link.png')); ?>"  width="21">
                        <?php endif; ?>
                        <span><?php echo e($ficheiro->nome); ?></span>
                    </a>
                <?php elseif( ! is_null($ficheiro->notas) ): ?>
                    <a class="item1" href="#"  onclick="infoNota('grupo',<?php echo e($ficheiro->id); ?>)">
                        <img src="<?php echo e(asset('images/nota.png')); ?>" width="23">
                        <span><?php echo e($ficheiro->nome); ?></span>
                    </a> 
                <?php else: ?>
                    <a class="item1">
                        <img src="<?php echo e(asset('images/file.png')); ?>" width="25">
                        <span><?php echo e($ficheiro->nome); ?></span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


    <!-- Lado direito - Tarefas -->
	<div id="drt">

        <div id='tarefasBtn' >Tarefas</div>
        <div id='feedbackBtn' >Feedback</div>

		<div id="tarefas">
            <!-- view tarefasAluno -->
            <?php echo $__env->make('aluno.tarefasAluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>            
        </div>
        <button class="calendarBtn" onclick="ShowCalendar()"><i class="far fa-calendar-alt fa-3x"></i></button>

        <div id='calendarContainer'>
            <div id='external-events'>
                <h4>Elementos do grupo</h4>
                <div id='external-events-list'>
                    <?php $__currentLoopData = $users_grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $r = rand(0,255); $g = rand(0,255); $b = rand(0,255) ?>
                        <!-- <?php if(Auth::user()->getUserId() == $ug->user_id): ?> 
                            <div class='fc-event draggable' data-color="rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>)" style="background-color: rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>); border-color: rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>)"><?php echo e($ug->nome); ?></div>
                        <?php else: ?>
                            <div class='fc-event undraggable' data-color="rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>)" style="background-color: rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>); border-color: rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>)"><?php echo e($ug->nome); ?></div>
                        <?php endif; ?> -->
                        
                        <?php if(Auth::user()->getUserId() == $ug->user_id): ?> 
                            <div class='fc-event draggable'><?php echo e($ug->nome); ?></div>
                        <?php else: ?>
                            <div class='fc-event undraggable'><?php echo e($ug->nome); ?></div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div id='calendar'></div>

            <div style='clear:both'></div>
        </div>
        
        <div id="allFeedback">
            <!-- view feedbacksAluno -->
            <?php echo $__env->make('aluno.feedbackAluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
</div>
</div>

<!-- Nota -->

<div id="notaa">

    <!-- view nota -->
    <?php echo $__env->make('aluno.notaAluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>

<!-- Feedback -->

<div class="feedback-footer">
    <div class="chat-popup" id="chat">
        <form id='formAddFeedback' class="form-container">
            <input type="hidden" name="grupo_id" value=''>
            <?php echo e(csrf_field()); ?>  
            
            <div class="dropup">
                <p><strong>Envie um pedido de feedback para o Professor</strong></p>
                <button type="button" id="btgrupos"> <i class="fa fa-users"></i> Escolher ficheiros</button>

                <div class="dropdown">
                    <span>Ficheiros</span>
                    <div class="dropdown-content">
                    </div>
                </div><br>
                <br>

                <label for="msg"><b>Mensagens</b></label>
                <textarea name="mensagem" id="message_content" ></textarea>

                <input type="hidden" id='idsImput' name='ids'>
                <input type="hidden"  name='tipo' value='grupo'>
                <input type="hidden" name='grupoId' value="<?php echo e($IdGrupo); ?>"><br>

                <button  type="submit" class="btn">Enviar Feedback</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Fechar</button>

                </div>

            </div>
            
        </form>
    </div>
</div>

<button type="button" id="btgrupoDocente" onclick="Showfeedback()">  
    <img src="<?php echo e(asset('images/feedback.png')); ?>" width="27" style="margin-right:10px">
    Pedir Feedback ao Professor
</button>


<script>
    $(document).ready(function(){
        if(<?php echo $tarefaId ?> > 0){
            infoTarefa(<?php echo $tarefaId ?>);
            $('#allEditT').show();
        }
    });

    $("#dropAdd").hide();
    $('div',".folder1").hide();
    $(".popUpBack").hide();
    $('#mydiv').hide();
    $('#allFeedback').hide();
    

    $("#tarefasBtn").click(function(){
        $("#allFeedback").hide();
        $("#tarefas").show();
        $("#tarefasBtn").css({'border-bottom':'2px solid grey'});
        $("#feedbackBtn").css({'border-bottom':'0px'});
    });

    $("#feedbackBtn").click(function(){
        $("#tarefas").hide();
        $("#allFeedback").show();
        $("#feedbackBtn").css({'border-bottom':'2px solid grey'});
        $("#tarefasBtn").css({'border-bottom':'0px'});
    });

    $(".siteadd").click(function(){
        $("#all1").show();
    }); 

    $(".taskadd").click(function(){
        $("#all2").show();
    });

    $(".pastaadd").click(function(){
        $("#all3").show();
    }); 
    
    $(".uploadFile").click(function(){
        $("#all4").show();
    }); 

    $(".notaAdd").click(function(){
        $("#all6").show();
    }); 

    $(".taskSubadd").click(function(){
        $("#all5").show();
    });

    $("#btgrupos").click(function(){
        $("#all7").show();
    });

    $(".closebtn").click(function(){
        ($($(this).parent()).parent()).hide();
    });

    $(document).mouseup(function(e){
        var container = $("#dropAdd");
        if (!container.is(e.target) && container.has(e.target).length === 0){
            container.hide();
        }
    });

    $("#btnAdd").click(function(){
        $("#dropAdd").show();
    }); 

    $('.folder1 .item1').click(function() {
        if ($('a img:nth-child(1)', $(this).parent()).attr("src") == "<?php echo e(asset('images/folder.png')); ?>") {
            $('img',$(this).parent()).eq(0).attr("src","<?php echo e(asset('images/openfolder.png')); ?>");
            $('div',$(this).parent()).show();
        } else  {
            $('img',$(this).parent()).eq(0).attr("src","<?php echo e(asset('images/folder.png')); ?>");
            $('div',$(this).parent()).hide();
        }
    });

    jQuery(function($) {
        $('#slc').on('change', function() {
            var id = this.value
            $.ajax({
                url: '/subTarefas',
                type: 'GET',
                dataType: 'json',
                success: 'success',
                data: {'tarefaId': id},
                success: function(data){
                    $('#subtarefasId').html(data)
                }
            });
        }).change();
    });

    $("#formAddPasta").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/uploadFicheiro',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    $("#formAddFeedback").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addFeedback',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            $('#feedbackdone').append(response);
            $('#all8').show();
            closeForm();
        });
    });

    $("#formAddNotaGrupo").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addNota',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    $("#formAddSubTarefa").submit(function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: '/addSubTarefa',
            type: 'GET',
            data : form_data
        }).done(function(response){
            location.reload();
        });
    });
    
     $("#formAddLink").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/addLink',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    $("#formAddTarefa").submit(function(event){
        event.preventDefault(); 
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/addTarefa',
            type: 'GET',
            data : form_data
        }).done(function(response){ 
            location.reload();
        });
    });

    function infoNota(tipo,id){
        $.ajax({
            url: '/infoNota',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data : {'tipo': tipo, 'id':id},
            success: function(data){
                $('#notaa').html(data.html);
                $('#notaa').show();
            }
        })
    }

    function selectFicheiros(){
        var ids = [];
        $(".dropdown-content").empty();
        $("input:checkbox[name=checkFich]:checked").each(function(){
            ids.push($(this).val());
            $('.dropdown-content').append( '<p>'+($(this).parent().text())+'</p>' )
        });
        $('#idsImput').val(ids);
        $('#all7').hide();
    }

    function Showfeedback() {
        document.getElementById("chat").style.display = "block";}
    
    function closeForm() {
        document.getElementById("chat").style.display = "none";
        $('#message_content').val('');
        $(".dropdown-content").empty();
        $("input:checkbox[name=checkFich]").each(function(){
            $(this).prop("checked", false );
        });
    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_aluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>