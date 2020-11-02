<?php $__env->startSection('action-content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new Brand</div>
                    <div class="panel-body">

                        <?php echo Form::open(['method'=>'POST', 'action'=> 'BrandsController@store','files'=>true]); ?>


                        <div class="form-group">
                            <?php echo Form::label('name', 'Name:'); ?>

                            <?php echo Form::text('name', null, ['class'=>'form-control']); ?>

                        </div>

                        <div class="form-group">
                            <?php echo Form::submit('Add Vendor', ['class'=>'btn btn-primary']); ?>

                        </div>

                        <?php echo Form::close(); ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('brands.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>