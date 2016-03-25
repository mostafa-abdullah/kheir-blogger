        <?php $__env->startSection('content'); ?>

            <h1>Write a review on <?php echo e($organization->name); ?></h1>


            <?php echo Form::open(array('action' => array('OrganizationController@storeReview',$organization->id))); ?>

            <div class = "form-group">

                <?php echo Form::label('review','Review');; ?>

                <?php echo Form::text('review',null,['class'=> 'form-control']);; ?>

            </div>

            <div class = "form-group">
                <?php echo Form::label('rate','Rate');; ?>

                <?php echo Form::selectRange('rate', 1, 5);; ?>

            </div>


            <div class="form-group">
                <?php echo Form::submit('Add Review',['class'=>'btn btn btn-default']); ?>

            </div>


            <?php echo Form::close(); ?>


            <?php echo $__env->make('errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>





        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>