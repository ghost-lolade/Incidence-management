<?php $__env->startSection('action-content'); ?>

    <!-- Favicon -->
    

    <!-- CSFR token for ajax call -->

    <!-- Bootstrap CSS -->
    
    
    
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">Preventive Maintenance   :: <?php echo e($date = date('Y-m-d H:i:s')); ?></h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="<?php echo e(route('pm-management.create')); ?>">Add PM Time</a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>


            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
        <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
                <thead>
                <tr>
                    <th valign="middle">#</th>
                    <th>ID</th>
                    <th>ATM Name</th>
                    <th>Vendor</th>
                    <th>Status</th>
                    <th>Date</th>
                    

                </tr>
                <?php echo e(csrf_field()); ?>

                </thead>
                <tbody>
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexKey => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="item<?php echo e($post->id); ?>">
                        <td class="col1"><?php echo e($indexKey+1); ?></td>
                        <td><?php echo e($post->terminal_id); ?></td>
                        <td>
                            <?php echo e($post->atm_name); ?>

                        </td>
                        <td>
                            <?php echo e($post->vendor_name); ?>

                        </td>
                        <td>
                            <?php echo e($post->quarter_first); ?>

                        </td>

                        <td>
                            <?php echo e($post->quarter_first_date); ?>

                        </td>
                        
                            
                                    
                                
                            
                                
                            
                                
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div><!-- /.panel-body -->
    </div><!-- /.panel panel-default -->
</div><!-- /.col-md-8 -->


<!-- jQuery -->

<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

<!-- Bootstrap JavaScript -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

<!-- toastr notifications -->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- icheck checkboxes -->
<script type="text/javascript" src="<?php echo e(asset('icheck/icheck.min.js')); ?>"></script>

<!-- Delay table load until everything else is loaded -->
<script>
    $(window).load(function(){
        $('#postTable').removeAttr('style');
    })
</script>


                <script>
                    $(document).ready(function() {
                        $('#postTable').DataTable({
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
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('atmreport.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>