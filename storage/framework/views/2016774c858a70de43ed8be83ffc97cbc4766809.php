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
                    <div class="panel-heading">PM Information</div>
                    <?php echo $__env->make('includes.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="panel-body">
                        <?php echo Form::open(['method'=>'POST', 'action'=> 'PreventiveMentanaceController@store', 'files'=>true]); ?>


                        
                        <?php echo e(csrf_field()); ?>


                        
                        <div class="form-group">
                            <label for="surName" class="col-sm-2 control-label">PM Quarter :</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <select class="form-control" name="response_time" required>
                                        <option value="">Select PM Quarter</option>
                                        <option value="1">First (Jan-Mar)</option>
                                        <option value="2">Second(Apr-June)</option>
                                        <option value="3">Third(July-Sept)</option>
                                        <option value="4">Fourth(Oct-Dec)</option>

                                    </select>
                                </div>
                            </div>
                            <br/><br/>
                        </div>

                        <div class="form-group">
                            <label for="otherName" class="col-sm-2 control-label">Response Time:</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time"></i>
                                    </div>
                                    <input type="text"  name="from_date" class="form-control pull-right" id="birthDate" placeholder="From Date" required>

                                </div>
                            </div>
                            <br/><br/>                            </div>

                        
                        <div class="form-group">
                            <label for="surName" class="col-sm-2 control-label"> Repair Time: *</label>
                            <div class="col-sm-5">

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text"  name="to_date" class="form-control pull-right" id="hiredDate" placeholder="To Date" required>

                                </div>
                            </div>
                            <br/><br/>            </div>
                        

                        

                        

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