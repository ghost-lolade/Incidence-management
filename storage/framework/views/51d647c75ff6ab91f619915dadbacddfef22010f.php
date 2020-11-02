<?php $__env->startSection('action-content'); ?>
    <!-- Main content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <section class="content">
        <div class="box">
            <div class="box-header">

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
                    <div class="col-sm-8">
                        <h3 class="box-title">List of ATM </h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="<?php echo e(route('atmdata-management.create')); ?>">Add New ATM</a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>


            <section class="content">
                <div class="row">
                      <div class="col-xs-12">

                        <!-- /.box-header -->


                        <div class="box">
                            <div class="box-header">
                                <h2 class="box-title">ATM Estate --  <?php echo e($date = date('Y-m-d H:i:s')); ?></h2>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
               
                          <table id="example1" class="table table-bordered table-striped">
			          <thead>
                                <tr>
                                    <th> ID</th>
                                    <th>Terminal ID</th>
                                    <th>Sol ID</th>
                                    <th>ATM Name</th>
                                    <th>Address</th>
                                    <th>Vendor</th>
                                    <th>Brand</th>
                                    
                                    <th>Model</th>
                                    <th>State</th>
                                    <th>Region</th>
                                    <th>Custodian Info</th>
                                    <th>Sla Hour</th>
                                    <th>Bank</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $atmreports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmreport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row" class="odd">




                                        <td><a href="<?php echo e(route('atmreport-management.edit', ['id' => $atmreport->id])); ?>"> <?php echo e($atmreport->id); ?></a></td>
                                        <td><?php echo e($atmreport->terminal_id); ?></td>
                                        <td><?php echo e($atmreport->sol_id); ?></td>
                                        <td><?php echo e($atmreport->atm_name); ?></td>
                                        <td><?php echo e($atmreport->address); ?></td>

                                        <td><?php echo e($atmreport->vendor_name); ?></td>
                                        <td><?php echo e($atmreport->brand); ?></td>
                                        <td><?php echo e($atmreport->model); ?></td>

                                        <td><?php echo e($atmreport->state); ?></td>
                                        <td><?php echo e($atmreport->region); ?></td>
                                        <td><?php echo e($atmreport->custodian_phone); ?></td>
                                        <td><?php echo e($atmreport->sla_hour); ?></td>
                                        <td><?php echo e($atmreport->bank); ?></td>
                                        
                                        
                                        <td>


                                                <a href="<?php echo e(route('atmdata-management.show', $atmreport)); ?>" class="btn btn-success col-sm-5 col-xs-5 btn-margin">
                                                    <span class="glyphicon glyphicon-eye-open"></span></a>

                                               

                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th> ID</th>
                                    <th>Terminal ID</th>
                                    <th>Sol ID</th>
                                    <th>ATM Name</th>
                                    <th>Address</th>
                                    <th>Vendor</th>
                                    <th>Brand</th>
                                    
                                    <th>Model</th>
                                    <th>State</th>
                                    <th>Region</th>
                                    <th>Custodian Info</th>
                                    <th>Sla Hour</th>
                                    <th>Bank</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                      <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.box-body -->
        </div>


        <!-- /.content-wrapper -->








        
            

                
                    
                    
                    
                    
                    
                    
                
            
        


        <script>
            $(document).ready(function() {
                $('#example1').DataTable({
                    'paging'      : true,
                    'lengthChange': true,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'print',
                        {
                            extend: 'csv',
                            title: 'ATM Estate_ <?php echo e($date); ?>',

                        },
                        {
                            extend: 'excel',
                            title: 'ATM Estate_ <?php echo e($date); ?>'
                        },
                        
                            
                            
                        
                    ]
                } );
            });
        </script>

    </section>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


    <!-- /.content -->
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('atmreport.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>