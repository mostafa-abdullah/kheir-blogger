<?php $__env->startSection('content'); ?>

  <?php echo Form::model($organization,array( 'method' => 'PATCH','action' =>array('OrganizationController@update',$organization->id))); ?>

    <div class="form-group">
      <?php echo Form::label('slogan', 'Organization solegan :');; ?>

      <?php echo Form::text('slogan',null,array('class' => 'form-control'));; ?>

    </div>
    <div class="form-group">
      <?php echo Form::label('phone', 'Organization phone :');; ?>

      <?php echo Form::text('phone',null,array('class' => 'form-control'));; ?>

    </div>
    <div class="form-group">
      <?php echo Form::label('location', 'Organization location :');; ?>

      <?php echo Form::text('location',null,array('class' => 'form-control'));; ?>

    </div>
    <div class="form-group">
      <?php echo Form::label('bio', 'Organization Bio :');; ?>

      <?php echo Form::textarea('bio',null,array('class' => 'form-control'));; ?>

    </div>
     <?php echo Form::submit('Update', array('class'=>'btn btn-default'));; ?>

  <?php echo Form::close(); ?>


  <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>