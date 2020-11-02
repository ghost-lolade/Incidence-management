<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 
<?php $__env->startSection('action-content'); ?>
    <!-- Main content -->
   <style>
   .container{
    padding: 0.5%;
   } 
</style>
 
 
    <section class="content">
        <div class="box">
            <div class="box-header">

             


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
            
			
                        <!-- /.box-header -->


                        <div class="box">
                            
                                
                            
                            <!-- /.box-header -->
                            <div class="box-body">
               
                       
		<div class="container">
    <div class="row">
        <div class="col-12">
        
		
          <table class="table table-bordered" id="laravel_crud" width="80%">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Terminal</th>
                 <th>ATM Name</th>
				  <th>Issue</th>
				   <th>Vendor</th>
                 <th>Status</th>
                
                 <th>Closed At</th>
                 <th>Replaced Part</th>
                
                 <td colspan="2">Action</td>
              </tr>
           </thead>
           <tbody id="posts-crud">
              <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr id="post_id_<?php echo e($post->id); ?>">
                 <td><?php echo e($post->id); ?></td>
                 <td><?php echo e($post->terminal_id); ?></td>
                 <td><?php echo e($post->atm_name); ?></td>
				 <td><?php echo e($post->subject); ?>, <?php echo e($post->error_code); ?></td>
                 <td><?php echo e($post->vendor_name); ?></td>
				 <td><?php echo e($post->request_status); ?></td>
				 <td><?php echo e($post->closed_at); ?></td>
				 <td><?php echo e($post->part_replaced); ?></td>
										
                 <td><a href="javascript:void(0)" id="edit-post" data-id="<?php echo e($post->id); ?>" class="btn btn-info">Confirm</a></td>
                 <td>
                  <a href="javascript:void(0)" id="delete-post" data-id="<?php echo e($post->id); ?>" class="btn btn-danger delete-post">Delete</a></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </tbody>
          </table>
          <?php echo e($posts->links()); ?>

       </div> 
    </div>
</div>
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="postCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="postForm" name="postForm" class="form-horizontal">
           <input type="hidden" name="post_id" id="post_id">
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Terminal ID</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="terminal_id" name="terminal_id" value="" required="" disabled>
                </div>
            </div>
 
            <div class="form-group">
                <label class="col-sm-4 control-label">Change Status</label>
                <div class="col-sm-12">
				
				<select class="form-control"  id="request_status" name="request_status" required >
				<option value="">Select Option</option>
				<option value="Resolved">Accept</option>
				<option value="Open">Decline</option>
			
				</select>
                                                   
				
				
                </div>
				 <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Remarks</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="remark" name="remark" value="" required="" >
                </div>
            </div>
			
            </div>
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save
             </button>
            </div>
        </form>
    </div>
    </div>
</div>
</div>
    <div class="modal-footer">
        
    </div>
</div>
</div>
</div>
</body>
</html>
<script>
  $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#create-new-post').click(function () {
        $('#btn-save').val("create-post");
        $('#postForm').trigger("reset");
        $('#postCrudModal').html("Add New post");
        $('#ajax-crud-modal').modal('show');
    });
 
    $('body').on('click', '#edit-post', function () {
      var post_id = $(this).data('id');
      $.get('confirmcall/'+post_id+'/edit', function (data) {
         $('#postCrudModal').html("Edit post");
          $('#btn-save').val("edit-post");
          $('#ajax-crud-modal').modal('show');
          $('#post_id').val(data.id);
          $('#terminal_id').val(data.terminal_id);
		  $('#remark').val(data.remark);
          $('#request_status').val(data.request_status);  
      })
   });

    $('body').on('click', '.delete-post', function () {
        var post_id = $(this).data("id");
        confirm("Are You sure want to delete the Incidence?");
 
        $.ajax({
            type: "DELETE",
            url: "<?php echo e(url('confirmcall')); ?>"+'/'+post_id,
            success: function (data) {
                $("#post_id_" + post_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });   
  });
 
 if ($("#postForm").length > 0) {
      $("#postForm").validate({
 
     submitHandler: function(form) {

      var actionType = $('#btn-save').val();
      $('#btn-save').html('Sending..');

      
      $.ajax({
          data: $('#postForm').serialize(),
          url: "<?php echo e(route('confirmcall.store')); ?>",
          type: "POST",
          dataType: 'json',
          success: function (data) {
			 
			  
              var post = '<tr id="post_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.terminal_id + '</td><td>' + data.atm_name + '</td><td>' + data.subject + '</td><td>' + data.vendor_name + '</td><td>' + data.request_status + '</td><td>' + data.closed_at + '</td><td>' + data.part_replaced + '</td>';
              post += '<td><a href="javascript:void(0)" id="edit-post" data-id="' + data.id + '" class="btn btn-info">Confirm</a></td>';
              post += '<td><a href="javascript:void(0)" id="delete-post" data-id="' + data.id + '" class="btn btn-danger delete-post">Delete</a></td></tr>';
               
              
              if (actionType == "create-post") {
                  $('#posts-crud').prepend(post);
              } else {
                  $("#post_id_" + data.id).replaceWith(post);
              }
 
              $('#postForm').trigger("reset");
              $('#ajax-crud-modal').modal('hide');
              $('#btn-save').html('Save Changes');
              
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }
  })
}
   
  
</script>			   
					   
	</div>			   
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('ajaxcrud.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>