<?php $__env->startSection('action-content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Vendor Data</div>
                    <div class="panel-body">

                        <?php echo Form::open(['method'=>'POST', 'action'=> 'VendorDataController@store','files'=>true]); ?>


                        <div class="form-group">
                            <?php echo Form::label('name', 'Vendor Name:'); ?>

                            <select class="form-control" name="vendor_id" required>
                                <option value="">Select Vendor</option>
                                <?php $__currentLoopData = $cedata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cedata->id); ?>"><?php echo e($cedata->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php echo Form::label('name', 'Full Name:'); ?>


                            <input type="text" class="form-control" name="name"  placeholder="Full Name" required>
                        </div><div class="form-group">
                            <?php echo Form::label('mobile', 'Mobile No:'); ?>

                            <input type="text" class="form-control" name="phone"  placeholder="Eg: 0803" required>
                        </div>

                       <div class="form-group">
                            <?php echo Form::label('email', 'Email Address:'); ?>

                           <input type="text" class="form-control" name="email"  placeholder="email@email.com" required>
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
                            <?php echo Form::submit('Add Record', ['class'=>'btn btn-primary']); ?>

                        </div>

                        <?php echo Form::close(); ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('atmreport.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>