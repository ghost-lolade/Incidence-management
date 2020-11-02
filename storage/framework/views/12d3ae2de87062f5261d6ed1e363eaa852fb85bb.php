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
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Search ATM Information</div>
                    <?php echo $__env->make('includes.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="panel-body">
                        <?php echo Form::open(['method'=>'POST', 'action'=> 'CallLogController@viewReporter', 'target'=>'_blank','files'=>true]); ?>


                        
                            <?php echo e(csrf_field()); ?>


                            <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label">Vendor Name:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <select class="form-control" name="vendor_id">
                                                <option value="">Select ALL Vendor</option>
                                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($vendor->name); ?>"><?php echo e($vendor->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>       </div>
                                    </div>
 <br/><br/>
                                </div>
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">ATM State:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>

                                            <select class="form-control" name="state_id">
                                                <option value="">ATM State</option>
                                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($state->name); ?>"><?php echo e($state->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>  </div>
                                    </div>
                                                   </div>
                            </div>

                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="phoneNumber" class="col-sm-3 control-label">ATM Status:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-mobile"></i>
                                            </div>

                                            <select class="form-control" name="status">
                                                <option value="">All Call</option>
                                                <option value="open">Open Call</option>
                                                <option value="resolved">Resolved Call</option>
                                                <option value="suspended">Suspended Call</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <br/>  <br/>        </div>
                                <!--<div class="form-group">-->

                                <!--    <label for="phoneNumber2" class="col-sm-3 control-label">ATM Region: </label>-->
                                <!--    <div class="col-sm-9">-->
                                <!--        <div class="input-group date">-->
                                <!--            <div class="input-group-addon">-->
                                <!--                <i class="fa fa-phone"></i>-->
                                <!--            </div>-->
                                <!--            <select class="form-control" name="region" >-->
                                <!--                <option value="">All Region</option>-->
                                <!--                <option value="1">Southern Region</option>-->
                                <!--                <option value="2">Northern Region</option>-->
                                <!--            </select>  </div>-->
                                <!--    </div>-->
                                <!--</div>-->


                            </div>

                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label"> From Date: *</label>
                                    <div class="col-sm-9">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="<?php echo e(old('date_hired')); ?>" name="from_date" class="form-control pull-right" id="hiredDate" placeholder="Select Date" required>
                                        </div>
                                    </div>

                                    <br/>  <br/>
                                </div>
                                
                                    
                                    
                                        
                                            
                                                
                                            
                                            
                                        
                                    
                                    
                            </div>

                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">To Date: *</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="<?php echo e(old('birthdate')); ?>" name="to_date" class="form-control pull-right" id="birthDate" placeholder="Select Date" required>
                                        </div> </div>
                                </div>
                    <br/>

                            </div>

                                <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('atmreport.basesearch', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>