<?php $__env->startSection('action-content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">View Patient Data</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                <tr role="row">


                                   <th width="20%" rowspan="1" colspan="1">Patient ID</th>
                                    <td><?php echo e($data->id); ?></td>
                                </tr><tr>
                                   <th width="20%" rowspan="1" colspan="1">terminal ID</th>
                                    <td><?php echo e($data->terminal_id); ?> </td>
                                </tr><tr>    <th width="20%" rowspan="1" colspan="1">Sol ID</th>
                                    <td><?php echo e($data->sol_id); ?></td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">ATM Name</th>
                                    <td><?php echo e($data->atm_name); ?></td>
                                </tr><tr> <th width="20%" rowspan="1" colspan="1">Vendor Name</th>
                                    <td><?php echo e($data->vendor_name); ?></td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">State</th>
                                    <td><?php echo e($data->state); ?></td>

                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">ATM brand</th>
                                    <td><?php echo e($data->brand); ?></td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">ATM Model</th>
                                    <td><?php echo e($data->model); ?></td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">Custodian Email</th>
                                    <td><?php echo e($data->custodian_email); ?></td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">Custodian Phone</th>
                                    <td><?php echo e($data->custodian_phone); ?></td>
                                </tr>

                                <tr>    <th width="20%" rowspan="1" colspan="1">ATM Serial No</th>
                                    <td><?php echo e($data->atm_serial_no); ?></td>
                                </tr><tr>   <th width="20%" rowspan="1" colspan="1">Address</th>
                                    <td><?php echo e($data->address); ?></td>
                                </tr>
                                <tr>
                                    <th rowspan="1" colspan="1">Action</th>
                                    <td>
                                        
                                            
                                            
                                            <a href="<?php echo e(route('atmdata-management.edit', ['id' => $data->id])); ?>" class="btn btn-warning col-sm-3 col-xs-4 btn-margin">
                                                Update
                                            </a>
                                        

                                        <a href="<?php echo e(url('atmdata-management')); ?>" class="btn btn-success col-sm-3 col-xs-4 btn-margin">Return</a>

                                    </td>

                                </tr>   </thead>
                                <tbody>
                                    <tr role="row" class="odd">

                                        
                                        
                                                                            </tr>
                                </tbody>



                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('atmreport.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>