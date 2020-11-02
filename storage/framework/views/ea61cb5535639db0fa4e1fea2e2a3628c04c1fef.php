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
                    <div class="panel-heading">Update ATM Record</div>
                    <?php echo $__env->make('includes.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="panel-body">
                        <?php echo Form::model($atmpart, ['method'=>'PATCH', 'action'=> ['BankDataController@update', $atmpart->id],'files'=>true]); ?>


                        <?php echo e(csrf_field()); ?>


                        <table class="table" id="tableauto">
                            <tr class="test">
                                <td><b>Terminal ID:</b> <input class="form-control" type='text' data-type="terminal_id" value='<?php echo e($atmpart->terminal_id); ?>' name='terminal_id' placeholder="ATM Terminal No" required/></td>
                                <td><b>ATM Name:</b> <input class="form-control" type='text' data-type="atm_name" value='<?php echo e($atmpart->atm_name); ?>' name='atm_name' placeholder="ATM Name"/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Sol ID:</b><input class="form-control" type='text' data-type="sol_id" value='<?php echo e($atmpart->sol_id); ?>' name='sol_id' placeholder="Invoice No" required/></td>
                                <td><b>ATM Address: </b>
                                    
                                    <input class="form-control" type='text' data-type="address" value='<?php echo e($atmpart->address); ?>' name='address' placeholder="ATM Address" required/>
                                </td>
                            </tr>
                            <tr class="test">
                                <td><b>ATM State:</b><input class="form-control" type='text' data-type="state" value='<?php echo e($atmpart->state); ?>' name='state' placeholder="State" required/></td>
                                <td><b>Activation Date: </b>
                                    <input class="form-control" type='text' data-type="date" id='hiredDate' value='<?php echo e($atmpart->activation_date); ?>' name='activation_date' placeholder="Select Date" required/>
                                    
                                </td>
                            </tr>
                            <tr class="test">
                                <td><b>ATM Brand:</b><input class="form-control" type='text' data-type="brand" value='<?php echo e($atmpart->brand); ?>' name='brand' placeholder="ATM Brand" required/></td>
                                <td><b>ATM Model:</b><input class="form-control" type='text' data-type="model" value='<?php echo e($atmpart->model); ?>' name='model' placeholder="ATM Model " required/> </td>
                            </tr>

                            <tr class="test">
                                <td><b>Custodian Email:</b><input class="form-control" type='email' data-type="custodian_email" value='<?php echo e($atmpart->custodian_email); ?>' name='custodian_email' placeholder="Custodian Email" required/></td>
                                <td><b>Custodian Phone: </b>

                                    
                                    <input class="form-control" type='text' data-type="custodian_phone" value='<?php echo e($atmpart->custodian_phone); ?>' name='custodian_phone' placeholder="Custodian Phone" required/></td>
                            </tr>
                            <tr class="test">
                                <td><b>Vendor:</b><input class="form-control" type='text' data-type="vendor_id" value='<?php echo e($atmpart->vendor_id); ?>' name='vendor_id' placeholder="Vendor Name" required/></td>
                                <td><b>ATM Status:</b><input class="form-control" type='text' data-type="status" value='<?php echo e($atmpart->status); ?>' name='status' placeholder="Status" required/> </td>
                            </tr>
                        </table>

                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        
                        
                        <br/>

                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update Record
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

<?php echo $__env->make('bankdata.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>