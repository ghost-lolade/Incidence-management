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
                    <div class="panel-heading">Vendor Daily Report</div>
                    <?php echo $__env->make('includes.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="panel-body">
                        <?php echo Form::open(['method'=>'POST', 'action'=> 'VendorReportController@viewDailyReporter', 'target'=>'_blank','files'=>true]); ?>


                        
                        <?php echo e(csrf_field()); ?>


                        <div class="col-sm-10"> <!-- FIRST COLUMN -->
                            
                                
                                
                                    
                                        
                                            
                                        
                                        
                                            
                                            
                                                
                                            
                                        
                                    
                                
                                
                            
                        </div>

                        

                        

                        <div class="col-sm-10"> <!-- Second COLUMN -->
                            <div class="form-group">
                                <label for="otherName" class="col-sm-2 control-label"> Date: *</label>
                                <div class="col-sm-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>

                                        <input hidden  type="text"  name="vendor_id" value="<?php echo e(Auth::user()->usertype); ?>">
                                        <input type="text" value="<?php echo e(old('birthdate')); ?>" name="to_date" class="form-control pull-right" id="birthDate" placeholder="Select Date" required>
                                    </div> </div>
                            </div>
                            <br/><br/>                         

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Generate Report
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