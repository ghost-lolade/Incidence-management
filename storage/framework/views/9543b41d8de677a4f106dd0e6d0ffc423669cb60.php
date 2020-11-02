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
                        <h3 class="box-title">List of Call logged</h3>
                    </div>
                    <div class="col-sm-4">

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
                                <h2 class="box-title">ATM Report --  <?php echo e($date = date('Y-m-d H:i:s')); ?></h2>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-6">
                                <table id="example2" class="table table-bordered table-striped" width="40%">

                                    <tr><td>1</td><td>Number of Calls Escalated to Vendor</td><td><?php echo e($call_escalated); ?></td></tr>
                                    <tr><td>2</td><td>Number of Open Calls at Close of Business</td><td><?php echo e($query_open); ?></td></tr>
                                    <tr><td>3</td><td>Number of Calls Resloved Same Day</td><td><?php echo e($query_sameday); ?></td></tr>
                                    <tr><td>4</td><td>Number Resolved Previously Logged</td><td><?php echo e($query_previous); ?></td></tr>
                                    <tr><td>5</td><td>Number of Open Calls Brought Forward</td><td><?php echo e($query_forward); ?></td></tr>
                                    <tr><td>6</td><td>Number of Suspended Call</td><td><?php echo e($query_suspended); ?></td></tr>
                                    <tr><td>7</td><td>Pending Aged Calls i.e > 3 Days</td><td><?php echo e($query_aged); ?></td></tr>
                                    <tr><td>8</td><td>Total Number of Call Closed</td><td><?php echo e($query_within_date); ?></td></tr>
                                    <tr><td>9</td><td>PERCENTAGE ATM DOWN @ EOD</td><td><?php echo e(number_format($percent,2)); ?> %</td></tr>

                                </table>
                                </div>
								
								<div class="col-xs-12">
                                <table width="100%" id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Brought Forward</th>
                                        <th>Calss Logged Today</th>
                                        <th>Open Calss As At Today</th>
                                        <th>Calls Resolve As AT COB</th>
                                        <th>Outliers</th>
                                        <th>Total Calls still Open at COB</th>
                                        <th>Bank Controllable</th>
                                        <th>Calls for Next Business Day</th>
                                        <th>SLA Failure Rate</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $dailytrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dailytrend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr role="row" class="odd">
                                            <td><?php echo e($dailytrend->id); ?></td>
                                           <td><?php echo e($dailytrend->brought_forward); ?></td>
                                           <td><?php echo e($dailytrend->calls_logged); ?></td>
                                           <td><?php echo e($dailytrend->open_call_as_today); ?> </td>
                                           <td><?php echo e($dailytrend->calls_resolved_at_COB); ?></td>
                                           <td><?php echo e($dailytrend->outliers); ?></td>
                                           <td><?php echo e($dailytrend->still_open); ?></td>
                                           <td><?php echo e($dailytrend->bank_controllable); ?></td>
                                           <td><?php echo e($dailytrend->call_for_nxt_business_day); ?></td>
                                           <td><?php echo e($dailytrend->SLA_failure_rate); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
								
								
								
                                <div class="col-xs-12">

                                <table width="100%" id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Log Date</th>
                                        <th>Terminal ID</th>

                                        <th>ATM Name</th>
                                        
                                        <th>ATM State </th>
                                        <th>Error Code</th>
                                        <th>Custodian Detail</th>
                                        <th>Vendor</th>
                                        <th>Suspend At</th>
                                        <th>Reopen At</th>
                                        <th>Call Status </th>
                                        <th>Part Replace/ Remark</th>
                                        <th>Closure Date</th>
                                        
                                        

                                        


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $atmreports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmreport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr role="row" class="odd">
                                            
                                            <td><?php echo e($atmreport->id); ?></td>
                                            <td><?php echo e($atmreport->mail_at); ?></td>
                                            <td><?php echo e($atmreport->terminal_id); ?></td>

                                            <td><?php echo e($atmreport->atm_name); ?></td>
                                            
                                            <td><?php echo e($atmreport->atm_state); ?></td>
                                            <td><?php echo e($atmreport->error_code); ?></td>
                                            <td><?php echo e($atmreport->custodian_phone); ?></td>
                                            <td><?php echo e($atmreport->vendor_name); ?></td>



                                            <td><?php echo e($atmreport->suspend_at); ?></td>
                                            <td><?php echo e($atmreport->reopen_at); ?></td>
                                            <td><?php echo e($atmreport->request_status); ?> - <?php echo e($atmreport->part_replaced); ?></td>
                                            <td><?php echo e($atmreport->remark); ?></td>
                                            <td><?php echo e($atmreport->closed_at); ?></td>



                                            





                                            

                                            
                                            
                                            

                                                
                                                    
                                                
                                                



                                            

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    
                                    
                                        
                                        
                                        
                                        
                                        
                                        

                                        
                                        
                                        
                                    
                                    
                                </table>
                            </div>
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
                            title: 'ATM Report_ <?php echo e($date); ?>',


                        },
                        {
                            extend: 'excel',
                            title: 'ATM Report_ <?php echo e($date); ?>'
                        },
                        {
                            extend: 'pdf',
                            title: 'ATM Report_ <?php echo e($date); ?>'
                        },
//                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            });
        </script>



        <script>
            $(function () {
//
                $('#example2').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false

            })
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