<?php $__env->startSection('action-content'); ?>
    <div class="container">
        <?php if(session()->has('success_message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('success_message')); ?>

            </div>
        <?php endif; ?>

        <?php if(session()->has('error_message')): ?>
            <div class="alert alert-danger">
                <?php echo e(session()->get('error_message')); ?>

            </div>
        <?php endif; ?>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Data: Customer Engineer</div>
                    <div class="panel-body">
                        <?php echo Form::model($cedata, ['method'=>'PATCH', 'action'=> ['VendorDataController@update', $cedata->id],'files'=>true]); ?>

                        

                        <div class="form-group">
                            <?php echo Form::label('name', 'Vendor Name:'); ?>

                            <select class="form-control" name="vendor_id" required>
                                <option value=""><?php echo e($cedata->brand[0]->name); ?></option>
                                <option value="">Select Vendor</option>
                                <?php $__currentLoopData = $vendor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendor->id); ?>"><?php echo e($vendor->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php echo Form::label('name', 'Full Name:'); ?>

                            
                            <input type="text" class="form-control" id="name" name="name" placeholder="Surname" value="<?php echo e($cedata->name); ?>" required>
                        </div><div class="form-group">
                            <?php echo Form::label('mobile', 'Mobile No:'); ?>

                            <input type="text" class="form-control" name="phone"  placeholder="Eg: 0803" value="<?php echo e($cedata->phone); ?>" required>
                        </div>

                        <div class="form-group">
                            <?php echo Form::label('email_address', 'Email Address:'); ?>

                            <input type="text" class="form-control" name="email"  placeholder="email@email.com" value="<?php echo e($cedata->email); ?>" required>
                        </div>

                        <div class="form-group">
                            <?php echo Form::label('name', 'Level:'); ?>

                            <select class="form-control" name="level" required>

                                <option value="">Select Level</option>
                                <option value="1">Helpdesk Member </option>
                                <option value="2">Team Lead</option>
                                <option value="3">Management/CEO</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php echo Form::submit('Update Record', ['class'=>'btn btn-primary']); ?>

                        </div>

                        <?php echo Form::close(); ?>


                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('atmreport.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>