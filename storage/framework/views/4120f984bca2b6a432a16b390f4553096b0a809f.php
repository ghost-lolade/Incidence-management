<?php $__env->startSection('action-content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">View Data</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                

                                    
                                    
                                
                                
                                   
                                    
                                
                                <tr>
                                   <th width="20%" rowspan="1" colspan="1">CE Name</th>
                                    <td><?php echo e($cedata->name); ?> <?php echo e($cedata->firstname); ?></td>
                                </tr><tr>    <th width="20%" rowspan="1" colspan="1">Email Address</th>
                                    <td><?php echo e($cedata->email); ?></td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">Mobile No</th>
                                    <td><?php echo e($cedata->requester_phone); ?></td>
                                </tr><tr> <th width="20%" rowspan="1" colspan="1">Department</th>
                                    <td><?php echo e($cedata->requester_dept); ?></td>
                                </tr>
                                
                                    

                                
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                
                                
                                    
                                

                                
                                    
                                
                                    
                                
                                <tr>
                                    <th rowspan="1" colspan="1">Action</th>
                                    <td>
                                        
                                            
                                            
                                        <a href="<?php echo e(route('requester-management.edit', ['id' => $cedata->id])); ?>" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                            Update
                                        </a>
                                        

                                        <a href="<?php echo e(url('requester-management')); ?>" class="btn btn-success col-sm-3 col-xs-4 btn-margin">Return</a>

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