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
                        <a class="btn btn-primary" href="<?php echo e(route('atmreport-management.create')); ?>">Add New atmreport</a>
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
                                <div class="col-xs-12">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terminal ID</th>
                                            <th>ATM Name</th>
                                            <th>Error Code</th>
                                            <th>Logged Time</th>

                                            <th>Suspend Time</th>
                                            <th>Reopen Time </th>
                                            <th>Closure Time </th>
                                            <th>Day </th>
                                            <th>Hours </th>
                                            <th>Work Hour</th>

                                            <th>Weekend </th>
                                            <th>Actual New </th>
                                            <th>Day &Time </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $atmreports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmreport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr role="row" class="odd">
                                                
                                                <td><?php echo e($atmreport->ticket_no); ?>, <?php echo e($dayOfTheWeek = \Carbon\Carbon::parse($atmreport->mail_at)->dayOfWeek); ?></td>
                                                <td><?php echo e($atmreport->terminal_id); ?></td>
                                                <td><?php echo e($atmreport->atm_name); ?></td>
                                                <td><?php echo e($atmreport->error_code); ?> </td>
                                                <td> <?php echo e($created_at = \Carbon\Carbon::parse($atmreport->mail_at)); ?></td>

                                                <td> <?php echo e($suspend_at = \Carbon\Carbon::parse($atmreport->suspend_at)); ?></td>
                                                <td> <?php echo e($reopen_at = \Carbon\Carbon::parse($atmreport->reopen_at)); ?></td>
                                                <td> <?php echo e($closed_at = \Carbon\Carbon::parse($atmreport->closed_at)); ?></td>

                                                <td><?php echo e($closure_day = $created_at->diffInDays($closed_at, false)); ?>

                                                </td>
                                                <td> <?php echo e($suspendInterval = $suspend_at->diffInHours($reopen_at, false)); ?>, <?php echo e($timeDiffCloseLog  = ($created_at->diffInHours($closed_at, false))- $suspendInterval); ?></td>

                                                <td><?php echo e((int)$days  =($atmreport->sla_hour/24) * $timeDiffCloseLog); ?></td>






                                                <?php if($atmreport->is_week == "Yes" ): ?>



                                                <?php if($dayOfTheWeek==1 || $dayOfTheWeek ==2 || $dayOfTheWeek ==3 || $dayOfTheWeek ==4): ?>

                                                    
                                                    <td>
                                                        WeekDay
                                                  <?php echo e((int)$dayss  =($atmreport->hour/24) * $timeDiffCloseLog); ?>, <?php echo e($atmreport->part_replaced); ?></td>
                                                <?php if($atmreport->part_replaced ==''): ?>
                                                    <td><?php echo e((int)$ActualResolution= $dayss - $atmreport->sla_hour); ?>

                                                        <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days  <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                    </td>

                                                    <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==7): ?>
                                                    <td><?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+6))); ?>

                                                        <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                    </td>

                                                    <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==13): ?>
                                                        <td><?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+12))); ?>

                                                            <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                        </td>
                                                <?php else: ?>
                                                    <td>Something is wrong here</td>
                                                    <?php endif; ?>

                                                    


                                                    


                                                    <td> <?php echo e($atmreport->atm_state); ?>

                                                    </td>
                                                <?php endif; ?>

                                                <?php if($dayOfTheWeek==0 ||$dayOfTheWeek==5 || $dayOfTheWeek ==6 ): ?>

                                                        
                                                        <td>
                                                            WeekendDay

                                                            <?php echo e((int)$dayss  =(($atmreport->hour/24) * $timeDiffCloseLog) - 2*($atmreport->hour-4)); ?>, <?php echo e($atmreport->part_replaced); ?></td>
                                                        
                                                        <?php if($atmreport->part_replaced ==''): ?>
                                                            <td> <?php echo e((int)$ActualResolution= $dayss - $atmreport->sla_hour); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                            </td>

                                                        <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==7): ?>
                                                            <td> <?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+6))); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                            </td>

                                                        <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==13): ?>
                                                            <td> <?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+12))); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                            </td>
                                                        <?php else: ?>
                                                            <td>Something is wrong here</td>
                                                        <?php endif; ?>
                                                        <td> <?php echo e($atmreport->atm_state); ?>

                                                        </td>
                                                    <?php endif; ?>
                                                <?php endif; ?>



                                                <?php if($atmreport->is_week == "No" ): ?>


                                                    <?php if($dayOfTheWeek==1 || $dayOfTheWeek ==2 || $dayOfTheWeek ==3 || $dayOfTheWeek ==4 || $dayOfTheWeek ==5): ?>



                                                        
                                                        <td>
WeekNOIsWeek
                                                            <?php echo e((int)$dayss  =($atmreport->hour/24) * $timeDiffCloseLog); ?>, <?php echo e($atmreport->part_replaced); ?></td>
                                                        
                                                        <?php if($atmreport->part_replaced ==''): ?>
                                                            <td><?php echo e((int)$ActualResolution= $dayss - $atmreport->sla_hour); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                            </td>

                                                        <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==7): ?>
                                                            <td><?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+6))); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                            </td>

                                                        <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==13): ?>
                                                            <td><?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+12))); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours</td>
                                                        <?php else: ?>
                                                            <td>Something is wrong here</td>
                                                        <?php endif; ?>

                                                        <td> <?php echo e($atmreport->atm_state); ?>

                                                        </td>
                                                    <?php endif; ?>

                                                        <?php if($dayOfTheWeek==0 ||$dayOfTheWeek==5 || $dayOfTheWeek ==6 ): ?>

                                                            
                                                            <td>
                                                                Weekend

                                                                <?php echo e((int)$dayss  =(($atmreport->hour/24) * $timeDiffCloseLog) - 2*($atmreport->hour)); ?>, <?php echo e($atmreport->part_replaced); ?></td>
                                                            
                                                            <?php if($atmreport->part_replaced ==''): ?>
                                                                <td><?php echo e((int)$ActualResolution= $dayss - $atmreport->sla_hour); ?>

                                                                <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                                </td>

                                                            <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==7): ?>
                                                                <td> <?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+6))); ?>

                                                                    <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours
                                                                </td>

                                                            <?php elseif($atmreport->part_replaced !='' && $atmreport->sla_hour==13): ?>
                                                                <td><?php echo e((int)$ActualResolution = ($dayss - ($atmreport->sla_hour+12))); ?>

                                                                    <?php echo e((int) $totalInDays=$ActualResolution/24); ?> days <?php echo e((int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays); ?> hours</td>
                                                            <?php else: ?>
                                                                <td>Something is wrong here</td>
                                                            <?php endif; ?>
                                                            <td> <?php echo e($atmreport->atm_state); ?>


                                                            </td>


                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terminal ID</th>
                                            <th>ATM Name</th>
                                            <th>Error Code</th>
                                            <th>Logged Time</th>

                                            <th>Suspend Time</th>
                                            <th>Reopen Time </th>
                                            <th>Closure Time </th>
                                            <th>Day </th>
                                            <th>Hours </th>
                                            <th>Work Hour</th>

                                            <th>Weekend </th>
                                            <th>Weekday </th>
                                            <th>Day &Time </th>

                                        </tr>
                                        </tfoot>
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
                    'paging': true,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false

                })
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