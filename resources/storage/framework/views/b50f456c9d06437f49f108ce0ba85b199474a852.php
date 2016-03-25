        <?php $__env->startSection('content'); ?>

            <h1> create organization review</h1>


            <?php echo Form::open(array('action' => array('OrganizationReviewController@store',$id))); ?>

            <div class = "form_group">

                <?php echo Form::label('review','Review'); ?>

                <?php echo Form::text('review',null,['class'=> 'form-control']); ?>

            </div>

            <div class = "form-group">
                <?php echo Form::label('rate','Rate'); ?>

                <?php echo Form::number('rate', 'value'); ?>

            </div>


            <div class="form-group">
                <?php echo Form::submit('AddReview',['class'=>'btn btn form-control']); ?>



            </div>


            <?php echo Form::close(); ?>


            <?php echo $__env->make('errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>





        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>