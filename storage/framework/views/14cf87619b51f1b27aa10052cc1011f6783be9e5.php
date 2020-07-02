<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="flex-center position-ref full-height ">
            <div class="top-right links">
                <a href="<?php echo e(url('/login')); ?>"><?php echo e(__('change.iniciarSessao')); ?></a>
            </div>  
        </div>
    
    <div class="row">
        

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading col-md-6" id="registoAluno" onclick="ShowRegistoAluno()"><?php echo e(__('change.aluno')); ?> </div>
                <div class="panel-heading col-md-6" id="registoProfessor" onclick="ShowRegistoProfessor()"><?php echo e(__('change.professor')); ?> </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="<?php echo e(route ('registarAluno')); ?>" id="formAluno">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="perfil_id" id="perfil_id" value="1">
                        <input type="hidden" name="tab_active" id="tab_active" value="#registoAluno">

                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label"><?php echo e(__('change.nome')); ?></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>"  autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('numero') ? ' has-error' : ''); ?>">
                            <label for="numero" class="col-md-4 control-label"><?php echo e(__('change.numeroAluno')); ?></label>

                            <div class="col-md-6">
                                <input id="numero" type="text" class="form-control" name="numero" value="<?php echo e(old('numero')); ?>"  autofocus>

                                <?php if($errors->has('numero')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('numero')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('data_nascimento') ? ' has-error' : ''); ?>">
                            <label for="data_nascimento" class="col-md-4 control-label"><?php echo e(__('change.dataNascimento')); ?></label>

                            <div class="col-md-6">
                                <input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="<?php echo e(old('data_nascimento')); ?>"  autofocus>

                                <?php if($errors->has('data_nascimento')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('data_nascimento')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('departamento_id') ? ' has-error' : ''); ?>">
                            <label for="departamento_id" class="col-md-4 control-label"><?php echo e(__('change.departamento')); ?></label>

                            <div class="col-md-6">
                                <select class="form-control" name="departamento_id" id="departamento_id" >
                                    <option value="">-- <?php echo e(__('change.selecionar')); ?> --</option>
                                    <?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($departamento->id == old('departamento_id')): ?>
                                            <option value="<?php echo e($departamento->id); ?>" selected><?php echo e($departamento->nome); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo e($departamento->id); ?>"><?php echo e($departamento->nome); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('departamento_id')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('departamento_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('curso_id') ? ' has-error' : ''); ?>">
                            <label for="curso_id" class="col-md-4 control-label"><?php echo e(__('change.curso')); ?></label>

                            <div class="col-md-6">
                                <select class="form-control" name="curso_id" id="curso_id" >
                                    <option value="">-- <?php echo e(__('change.escolherCurso')); ?>--</option>
                                    <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($curso->id == old('curso_id')): ?>
                                            <option value="<?php echo e($curso->id); ?>" selected><?php echo e($curso->nome); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo e($curso->id); ?>"><?php echo e($curso->nome); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('curso_id')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('curso_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" >

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                
                    
                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label"><?php echo e(__('change.confirmarPass')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('cadeiras') ? ' has-error' : ''); ?>">
                            <label for="cadeiras" class="col-md-4 control-label"><?php echo e(__('change.disciplinas')); ?></label>

                            <div class="col-md-6">
                                <select multiple="multiple" class="form-control" name="cadeiras[]" id="cadeirasAluno" >
                                    <?php if(sizeof($cadeiras) == 0): ?>
                                        <option value="">-- <?php echo e(__('change.escolherCurso')); ?> --</option>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $cadeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cadeira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($cadeira->id == old('cadeira_id')): ?>
                                                <option value="<?php echo e($cadeira->id); ?>" selected><?php echo e($cadeira->nome); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($cadeira->id); ?>"><?php echo e($cadeira->nome); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>

                                <?php if($errors->has('cadeiras')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('cadeiras')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                <?php echo e(__('change.registar')); ?>

                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" method="POST" action="<?php echo e(route ('registarProfessor')); ?>" id="formProfessor">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="perfil_id" id="perfil_id" value="2">
                        <input type="hidden" name="tab_active" id="tab_active" value="#registoProfessor">

                        <div class="form-group<?php echo e($errors->has('nameProf') ? ' has-error' : ''); ?>">
                            <label for="nameProf" class="col-md-4 control-label"><?php echo e(__('change.nome')); ?></label>

                            <div class="col-md-6">
                                <input id="name2" type="text" class="form-control" name="nameProf" value="<?php echo e(old('nameProf')); ?>"  autofocus>

                                <?php if($errors->has('nameProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('nameProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('numeroProf') ? ' has-error' : ''); ?>">
                            <label for="numeroProf" class="col-md-4 control-label"><?php echo e(__('change.numDocente')); ?></label>

                            <div class="col-md-6">
                                <input id="numero2" type="text" class="form-control" name="numeroProf" value="<?php echo e(old('numeroProf')); ?>"  autofocus>

                                <?php if($errors->has('numeroProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('numeroProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('data_nascimentoProf') ? ' has-error' : ''); ?>">
                            <label for="data_nascimentoProf" class="col-md-4 control-label"><?php echo e(__('change.dataNascimento')); ?></label>

                            <div class="col-md-6">
                                <input id="data_nascimento2" type="date" class="form-control" name="data_nascimentoProf" value="<?php echo e(old('data_nascimentoProf')); ?>"  autofocus>

                                <?php if($errors->has('data_nascimentoProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('data_nascimentoProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('departamento_idProf') ? ' has-error' : ''); ?>">
                            <label for="departamento_idProf" class="col-md-4 control-label"><?php echo e(__('change.departamento')); ?></label>

                            <div class="col-md-6">
                                <select class="form-control" name="departamento_idProf" id="departamento_id2" >
                                    <option value="">-- <?php echo e(__('change.selecionar')); ?> --</option>
                                    <?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($departamento->id == old('departamento_idProf')): ?>
                                            <option value="<?php echo e($departamento->id); ?>" selected><?php echo e($departamento->nome); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo e($departamento->id); ?>"><?php echo e($departamento->nome); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('departamento_idProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('departamento_idProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('emailProf') ? ' has-error' : ''); ?>">
                            <label for="emailProf" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email2" type="email" class="form-control" name="emailProf" value="<?php echo e(old('emailProf')); ?>" >

                                <?php if($errors->has('emailProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('emailProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                
                    
                        <div class="form-group<?php echo e($errors->has('passwordProf') ? ' has-error' : ''); ?>">
                            <label for="passwordProf" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password2" type="password" class="form-control" name="passwordProf" >

                                <?php if($errors->has('passwordProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('passwordProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="passwordProf-confirm" class="col-md-4 control-label"><?php echo e(__('change.confirmarPass')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm2" type="password" class="form-control" name="passwordProf_confirmation" >
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('cadeirasProf') ? ' has-error' : ''); ?>">
                            <label for="cadeirasProf" class="col-md-4 control-label"><?php echo e(__('change.disciplinas')); ?></label>

                            <div class="col-md-6">
                                <select multiple="multiple" class="form-control" name="cadeirasProf[]" id="cadeirasProfessor" >
                                    <?php if(sizeof($cadeirasProf) == 0): ?>
                                        <option value="">-- <?php echo e(__('change.escolherDepartamento')); ?> --</option>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $cadeirasProf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cadeira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($cadeira->id == old('cadeira_id')): ?>
                                                <option value="<?php echo e($cadeira->id); ?>" selected><?php echo e($cadeira->nome); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($cadeira->id); ?>"><?php echo e($cadeira->nome); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>

                                <?php if($errors->has('cadeirasProf')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('cadeirasProf')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                <?php echo e(__('change.registar')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="register_Image">
            <img src="<?php echo e(asset('images/register_image.svg')); ?>" width=27% class="image_register"> 
    </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({
        dateFormat: "dd-mm-yy"
     });

    $("#departamento_id").change(function(){
        $.ajax({
            url: "<?php echo e(route('changeDepartamentoId')); ?>?departamento_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#curso_id').html(data.html);
            }
        });
    });

    $("#departamento_id2").change(function(){
        $.ajax({
            url: "<?php echo e(route('changeDepartamentoProfId')); ?>?departamento_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#cadeirasProfessor').html(data.html);
            }
        });
    });

    $("#curso_id").change(function(){
        $.ajax({
            url: "<?php echo e(route('changeCursoId')); ?>?curso_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#cadeirasAluno').html(data.html);
            }
        });
    });

    $(document).ready(function() {
        if('<?php echo e($tab_active); ?>' == "#registoAluno") {
            ShowRegistoAluno();
        }
        else {
            ShowRegistoProfessor();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>