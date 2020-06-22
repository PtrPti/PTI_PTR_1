<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading col-md-6 registo-active" id="registoAluno" onclick="ShowRegistoAluno()">Aluno </div>
                <div class="panel-heading col-md-6" id="registoProfessor" onclick="ShowRegistoProfessor()">Professor </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="<?php echo e(route ('registarPost')); ?>" id="formAluno">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="perfil_id" id="perfil_id" value="1">

                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('numero') ? ' has-error' : ''); ?>">
                            <label for="numero" class="col-md-4 control-label">Nº Aluno</label>

                            <div class="col-md-6">
                                <input id="numero" type="text" class="form-control" name="numero" value="<?php echo e(old('numero')); ?>" required autofocus>

                                <?php if($errors->has('numero')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('numero')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('data_nascimento') ? ' has-error' : ''); ?>">
                            <label for="data_nascimento" class="col-md-4 control-label">Data de nascimento</label>

                            <div class="col-md-6">
                                <input id="data_nascimento" type="date" class="form-control" name="data_nascimento" value="<?php echo e(old('data_nascimento')); ?>" required autofocus>

                                <?php if($errors->has('data_nascimento')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('data_nascimento')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('departamento_id') ? ' has-error' : ''); ?>">
                            <label for="departamento_id" class="col-md-4 control-label">Departamento</label>

                            <div class="col-md-6">
                                <select class="form-control" name="departamento_id" id="departamento_id" required>
                                    <option value="">-- Selecionar --</option>
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
                            <label for="curso_id" class="col-md-4 control-label">Curso</label>

                            <div class="col-md-6">
                                <select class="form-control" name="curso_id" id="curso_id" required>
                                    <option value="">-- Escolha um departamento --</option>
                                </select>

                                <?php if($errors->has('curso_id')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('curso_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('grau_academico_id') ? ' has-error' : ''); ?>">
                            <label for="grau_academico_id" class="col-md-4 control-label">Grau académico</label>

                            <div class="col-md-6">
                                <select class="form-control" name="grau_academico_id" id="grau_academico_id" required>
                                    <option value="">-- Selecionar --</option>
                                    <?php $__currentLoopData = $graus_academicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grau_academico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($grau_academico->id == old('grau_academico_id')): ?>
                                            <option value="<?php echo e($grau_academico->id); ?>" selected><?php echo e($grau_academico->nome); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($grau_academico->id); ?>"><?php echo e($grau_academico->nome); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('grau_academico_id')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('grau_academico_id')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

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
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('cadeiras') ? ' has-error' : ''); ?>">
                            <label for="cadeiras" class="col-md-4 control-label">Disciplinas</label>

                            <div class="col-md-6">
                                <select multiple="multiple" class="form-control" name="cadeiras[]" id="cadeirasAluno" required>
                                    <option value="">-- Escolha um curso --</option>
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
                                    Registar
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" method="POST" action="<?php echo e(route ('registarPost')); ?>" id="formProfessor">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="perfil_id" id="perfil_id" value="2">

                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name2" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('numero') ? ' has-error' : ''); ?>">
                            <label for="numero" class="col-md-4 control-label">Nº Docente</label>

                            <div class="col-md-6">
                                <input id="numero2" type="text" class="form-control" name="numero" value="<?php echo e(old('numero')); ?>" required autofocus>

                                <?php if($errors->has('numero')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('numero')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('data_nascimento') ? ' has-error' : ''); ?>">
                            <label for="data_nascimento" class="col-md-4 control-label">Data de nascimento</label>

                            <div class="col-md-6">
                                <input id="data_nascimento2" type="text" class="date form-control" name="data_nascimento" value="<?php echo e(old('data_nascimento')); ?>" required autofocus>

                                <?php if($errors->has('data_nascimento')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('data_nascimento')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('departamento_id') ? ' has-error' : ''); ?>">
                            <label for="departamento_id" class="col-md-4 control-label">Departamento</label>

                            <div class="col-md-6">
                                <select class="form-control" name="departamento_id" id="departamento_id2" required>
                                    <option value="">-- Selecionar --</option>
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

                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email2" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

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
                                <input id="password2" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm2" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('cadeiras') ? ' has-error' : ''); ?>">
                            <label for="cadeiras" class="col-md-4 control-label">Disciplinas</label>

                            <div class="col-md-6">
                                <select multiple="multiple" class="form-control" name="cadeiras[]" id="cadeirasProfessor" required>
                                    <option value="">-- Escolha um departamento --</option>
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
                                    Registar
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
    $("#departamento_id").change(function() {
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>