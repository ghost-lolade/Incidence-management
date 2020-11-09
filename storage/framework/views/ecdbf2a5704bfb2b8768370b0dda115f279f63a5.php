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
                        <h3 class="box-title">List of Open Call <?php echo e($date = date('Y-m-d H:i:s')); ?></h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="<?php echo e(url('logeco')); ?>">Log Incidence</a>
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
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                                                        <th>ATM Address</th>
                                    <th>Issues</th>
                                    <th>Description </th>
                                    <th>Vendor</th>
                                     <th>Asigned CE</th>
                                    <th>Status</th>
                                    <!--<th>Remark</th>-->

                                    <th>Logged Time</th>
                                    <th>Action</th>
                                    
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $atmreports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmreport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row" class="odd">

                                        <td><?php echo e($atmreport->id); ?></td>
                                        <td><?php echo e($atmreport->terminal_id); ?></td>
                                        <td><?php echo e($atmreport->atm_name); ?></td>
                                        <td><?php echo e($atmreport->address); ?></td>
                                        <td><?php echo e($atmreport->subject); ?></td>
                                        <td width="25%"><?php echo e($atmreport->error_code); ?></td>
                                        <td><?php echo e($atmreport->vendor_name); ?> </td>  <td><?php echo e($atmreport->ce_name); ?>  </td>

                                        <td><?php echo e($atmreport->request_status); ?></td>
                                        <!--<td><?php echo e($atmreport->remark); ?></td>-->
                                        <td><?php echo e($atmreport->mail_at); ?></td>

                                        <td>   <button class="show-modal btn btn-success" data-id="<?php echo e($atmreport->id); ?>" data-title="<?php echo e($atmreport->terminal_id); ?>" data-content="<?php echo e($atmreport->address); ?> -- <?php echo e($atmreport->custodian_phone); ?>-- <?php echo e($atmreport->decline_reason); ?>"
                                                       data-assign="<?php echo e($atmreport->ce_name); ?>" data-status="<?php echo e($atmreport->ce_status); ?>" data-timer="<?php echo e($atmreport->ce_arrival_time); ?>">
                                                <span class="glyphicon glyphicon-eye-open"></span> Show</button>


                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $atmnotclose; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmnotclose): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row" class="odd">
                                        
                                        <td><?php echo e($atmnotclose->id); ?></td>
                                        <td><?php echo e($atmnotclose->terminal_id); ?></td>
                                        <td><?php echo e($atmnotclose->atm_name); ?></td>
                                        <td><?php echo e($atmnotclose->address); ?></td>
                                        <td><?php echo e($atmnotclose->subject); ?></td>
                                    
                                        <td width="25%"><?php echo e($atmnotclose->error_code); ?></td>
                                        <td><?php echo e($atmnotclose->vendor_name); ?></td>
                                        <td> <?php echo e($atmnotclose->ce_name); ?> </td>
                                        
                                        <td><?php echo e($atmnotclose->request_status); ?></td>
                                        <!--<td><?php echo e($atmnotclose->remark); ?></td>-->

                                        <td><?php echo e($atmnotclose->mail_at); ?></td>


                                        <td>   <button class="show-modal btn btn-success" data-id="<?php echo e($atmnotclose->id); ?>" data-title="<?php echo e($atmnotclose->terminal_id); ?>" data-content="<?php echo e($atmnotclose->address); ?> -- <?php echo e($atmnotclose->custodian_phone); ?>-- <?php echo e($atmnotclose->decline_reason); ?>"
                                                       data-assign="<?php echo e($atmnotclose->ce_name); ?>" data-status="<?php echo e($atmnotclose->ce_status); ?>" data-timer="<?php echo e($atmnotclose->ce_arrival_time); ?>">
                                                <span class="glyphicon glyphicon-eye-open"></span> Show</button>


                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                   <th>ID</th>
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    <th>ATM Address</th>
                                    <th>Issues</th>
                                    <th>Description</th>
                                    <th>Vendor</th>
                                    <th>Status</th>
                                    <!--<th>Remark</th>-->

                                    <th>Logged Time</th>
                                    <th>Action</th>
                                    
                                    
                                </tr>
                                </tfoot>
                            </table>


                                <div id="showModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="id">ID:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="id_show" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="title">Terminal ID:</label>
                                                        <div class="col-sm-9">
                                                            <input type="name" class="form-control" id="title_show" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">Detail:</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control" id="content_show" cols="40" rows="5" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">Assigned CE:</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" id="assign_show" cols="40" rows="5" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">CE Status:</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" id="status_show" cols="40" rows="5" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">Expected Arrival Time:</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" id="timer_show" cols="40" rows="5" disabled>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                        <span class='glyphicon glyphicon-remove'></span> Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal form to delete a form -->
                                <div id="deleteModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <h3 class="text-center">Are you sure you want to Reopen this call?</h3>
                                                <br />
                                                <form class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="id">ID:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="id_delete" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="title">Terminal ID:</label>
                                                        <div class="col-sm-10">
                                                            <input type="name" class="form-control" id="title_delete" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="content">Reopen Remark:</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" id="closure_edit" cols="40" rows="5"></input>
                                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                                        </div>
                                                    </div>
                                                    
                                                        
                                                        
                                                            
                                                            
                                                        
                                                    
                                                    
                                                        
                                                        
                                                            
                                                            
                                                        

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary delete" data-dismiss="modal">
                                                        <span id="" class='glyphicon glyphicon-check'></span> YES
                                                    </button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                        <span class='glyphicon glyphicon-remove'></span> Close
                                                    </button>
                                                </div>
                                            </div>
                                                </form>
                                            </div>

                                    </div>
                                </div>

                            </div>
                      <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.box-body -->
        </div>


        <!-- /.content-wrapper -->


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


        <!-- AJAX CRUD operations -->
        <script type="text/javascript">

            // Show a post   data-timer; data-status, data-assign
            $(document).on('click', '.show-modal', function() {
                $('.modal-title').text('Show');
                $('#id_show').val($(this).data('id'));
                $('#title_show').val($(this).data('title'));
                $('#content_show').val($(this).data('content'));
                $('#assign_show').val($(this).data('assign'));
                $('#status_show').val($(this).data('status'));
                $('#timer_show').val($(this).data('timer'));
                $('#showModal').modal('show');
            });

            // delete a post
            $(document).on('click', '.delete-modal', function() {
                $('.modal-title').text('Delete');
                $('#id_delete').val($(this).data('id'));
                $('#title_delete').val($(this).data('title'));
                $('#closure_edit').val($(this).data('closure_mail'));
                $('#to').val($(this).data('close_day'));
                $('#timeDate2').val($(this).data('close_time'));
                $('#deleteModal').modal('show');
                id = $('#id_delete').val();
            });
            $('.modal-footer').on('click', '.delete', function() {
                $.ajax({
                    type: 'DELETE',
                    url: 'atmreport-management/' + id,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $("#id_edit").val(),
                        'title': $('#edit_terminal').val(),
                        'closure_mail': $('#closure_edit').val(),
                        'close_day': $('#to').val(),
                        'close_time': $('#timeDate2').val()
                    },
                    success: function(data) {
                        toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                        $('.item' + data['id']).remove();
                        $('.col1').each(function (index) {
                            $(this).html(index+1);
                        });
                    }
                });
            });
            </script>






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