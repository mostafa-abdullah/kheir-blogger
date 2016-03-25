        <?php $__env->startSection('content'); ?>

            <h1> create organization review on <?php echo e($event->name); ?></h1>

            <?php echo Form::open(array('action' => array('EventReviewController@store',$event->id))); ?>


            <div class = "form_group">

                <?php echo Form::label('review','Review'); ?>

                <?php echo Form::text('review',null,['class'=> 'form-control']); ?>

            </div>

            <div class = "form-group">
                <?php echo Form::label('rate','Rate');; ?>

                <?php echo Form::selectRange('rate', 1, 5);; ?>

            </div>


            <div class="form-group">
                <?php echo Form::submit('AddReview',['class'=>'btn btn form-control']); ?>



            </div>

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