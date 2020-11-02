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




            <form action="<?php echo e(url('pmcert')); ?>" class="form-image-upload" method="POST" enctype="multipart/form-data">


                <?php echo csrf_field(); ?>



                <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>


                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo e($message); ?></strong>
                    </div>
                <?php endif; ?>


                <div class="row">
                    <div class="col-md-5">
                        <strong>Title:</strong>
                        <input type="text" name="terminal_id" class="form-control" placeholder="Terminal ID">
                    </div>
                    <div class="col-md-5">
                        <strong>Image:</strong>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <br/>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>


            </form>
<br/>
<br/>
<br/>

            <div class="row">
                <div class='list-group gallery'>


                    <?php if($images->count()): ?>
                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                <a class="thumbnail fancybox" rel="ligthbox" href="public/images/<?php echo e($image->image); ?>">
                                    <img class="img-responsive" alt="" src="public/images/<?php echo e($image->image); ?>" />
                                    <div class='text-center'>
                                        <small class='text-muted'><?php echo e($image->terminal_id); ?></small>
                                    </div> <!-- text-center / end -->
                                </a>
                                <form action="<?php echo e(url('pmcert',$image->id)); ?>" method="POST">
                                    <input type="hidden" name="_method" value="delete">
                                    <?php echo csrf_field(); ?>

                                    <button type="submit" class="close-icon btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                </form>
                            </div> <!-- col-6 / end -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>


                </div> <!-- list-group / end -->
            </div> <!-- row / end -->




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