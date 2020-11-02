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
                        
                        <h3 class="box-title">List of Vendors (Data) <?php echo e($date = date('Y-m-d H:i:s')); ?> </h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="<?php echo e(route('vendordata-management.create')); ?>">Add Vendor Data</a>
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
                            
                                
                            
                            <!-- /.box-header -->
                            <div class="box-body">
               
                          <table id="example1" class="table table-bordered table-striped">
			          <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Vendor </th>
                                     <th>Staff Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Address</th>
                                    <th>Level</th>
                                   
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $cedatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row" class="odd">

                                        <td><?php echo e($cedata->id); ?></td>
                                         <td><?php echo e($cedata->brand[0]->name); ?></td>
                                        <td><?php echo e($cedata->name); ?></td>
                                        <td><?php echo e($cedata->phone); ?></td>

                                        <td><?php echo e($cedata->email); ?></td>
                                       

                                        <td><?php echo e($cedata->level); ?></td>
                                       
                                    <td>
                                        <a href="<?php echo e(route('vendordata-management.edit', ['id' => $cedata->id])); ?>" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                            Update
                                        </a>
                                        <a href="<?php echo e(route('vendordata-management.show', $cedata)); ?>" class="btn btn-success col-sm-3 col-xs-5 btn-margin">View</a>


                                    </td>

                              </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                     <th>Vendor</th>
                                    <th> Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Address</th>
                                    <th>Level</th>
                                   

                                    
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
                            title: 'Call Log_ <?php echo e($date); ?>',

                        },
                        {
                            extend: 'excel',
                            title: 'Call Log_ <?php echo e($date); ?>'
                        },
                        {
                        extend: 'pdf',
                        title: 'Call Log_ <?php echo e($date); ?>'
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