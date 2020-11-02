<?php $__env->startSection('action-content'); ?>
    <div class="container">
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
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Cash & Charge Record</div>
                    <?php echo $__env->make('includes.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="panel-body">
                        <?php echo Form::model($atmpart, ['method'=>'PATCH', 'action'=> ['PartReplaceController@update', $atmpart->id],'files'=>true]); ?>


                        <?php echo e(csrf_field()); ?>


                        <table class="table" id="tableauto">
                            <tr>
                                <th>Terminal ID</th>
                                <th>ATM Name</th>
                            </tr>
                            <tr class="test">
                                <td> <input class="form-control autocomplete_txt" type='text' data-type="terminalid" value='<?php echo e($atmpart->terminal_id); ?>' name='terminalid' placeholder="Terminal ID" required/></td>
                                <td> <input class="form-control autocomplete_txt" type='text' data-type="atmname" value='<?php echo e($atmpart->atm_name); ?>' name='atmname' placeholder="ATM Name" required/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Part Name:</b> <input class="form-control" type='text' data-type="part_name" value='<?php echo e($atmpart->part_name); ?>'  name='part_name' placeholder="Part Name" required/></td>
                                <td><b>Price:</b> <input class="form-control" type='text' data-type="price" value='<?php echo e($atmpart->price); ?>' name='price' placeholder="1000"/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Invoice No:</b><input class="form-control" type='text' data-type="invoice_no" value='<?php echo e($atmpart->invoice_no); ?>' name='invoice_no' placeholder="Invoice No" required/></td>
                                <td><b>Date: </b>
                                    

                                    <input class="form-control" type='text' data-type="date" id='hiredDate' name='date' value='<?php echo e($atmpart->date); ?>' placeholder="Select Date" required/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Supplier By:</b><input class="form-control" type='text' data-type="supplier_by" value='<?php echo e($atmpart->supplier_by); ?>' name='supplier_by' placeholder="Supplier Name" required/></td>
                                <td><b>Approved By:</b><input class="form-control" type='text' data-type="approved_by" value='<?php echo e($atmpart->approved_by); ?>' name='approved_by' placeholder="Approval By" required/> </td>
                            </tr>
                        </table>
<br/>

                        <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Record
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('partreplaced.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>