<?php $__env->startSection('action-content'); ?>
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Incidence</div>
                    
                    <div class="panel-body">

                        <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

                        
                        <h3>Add ATM </h3>
                        <div>
                            <?php echo Form::open(['method'=>'POST', 'action'=> 'BankDataController@store','files'=>true]); ?>


                            <table class="table" id="tableauto">
                                <tr class="test">
                                    <td><b>Terminal ID:</b> <input class="form-control" type='text' data-type="terminal_id" id='terminal_id' name='terminal_id' placeholder="ATM Terminal No" required/></td>
                                    <td><b>ATM Name:</b> <input class="form-control" type='text' data-type="atm_name" id='atm_name' name='atm_name' placeholder="ATM Name"/> </td>
                                </tr>
                                <tr class="test">
                                    <td><b>Sol ID:</b><input class="form-control" type='text' data-type="sol_id" id='sol_id' name='sol_id' placeholder="Branch No" required/></td>
                                    <td><b>ATM Address: </b>
                                        
                                        <input class="form-control" type='text' data-type="address" id='address' name='address' placeholder="ATM Address" required/>
                                    </td>
                                </tr>
                                <tr class="test">
                                    <td><b>ATM State:</b><input class="form-control" type='text' data-type="state" id='state' name='state' placeholder="State" required/></td>
                                    <td><b>Activation Date: </b>
                                        <input class="form-control" type='text' data-type="date" id='hiredDate' name='activation_date' placeholder="Select Date" required/>
                                        
                                    </td>
                                </tr>
                                <tr class="test">
                                    <td><b>ATM Brand:</b><input class="form-control" type='text' data-type="brand" id='brand' name='brand' placeholder="ATM Brand" required/></td>
                                    <td><b>ATM Model:</b><input class="form-control" type='text' data-type="model" id='model' name='model' placeholder="ATM Model " required/> </td>
                                </tr>

                                <tr class="test">
                                    <td><b>Custodian Email:</b><input class="form-control" type='email' data-type="custodian_email" id='custodian_email' name='custodian_email' placeholder="Custodian Email" required/></td>
                                    <td><b>Custodian Phone: </b>

                                        
                                        <input class="form-control" type='text' data-type="custodian_phone" id='custodian_phone' name='custodian_phone' placeholder="Custodian Phone" required/></td>
                                </tr>
                                <tr class="test">
                                    <td><b>Vendor:</b><input class="form-control" type='text' data-type="vendor_id" id='vendor_id' name='vendor_id' placeholder="Vendor Name" required/></td>
                                    <td><b>ATM Status:</b><input class="form-control" type='text' data-type="status" id='status' name='status' placeholder="Status" required/> </td>
                                </tr>
                            </table>

                            <?php echo Form::submit('Submit Record', ['class'=>'btn btn-success']); ?>

                            

                        </div>


                        <br/>
                        


                        
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

        </div>

    </div>





    <script type="text/javascript">

        $(".delete").on('click', function() {
            $('.chkbox:checkbox:checked').parents("tr").remove();
            $('.check_all').prop("checked", false);
            updateSerialNo();
        });
        // (#mydiv table tr).attr('id', 'mydatatable')
        //        var i=$('table tr').length;
        //        var i=$('#test tr').length;
        var i=$('#tableauto tr').length;

        $(".addbtn").on('click',function(){
            count=$('#tableauto tr').length;

            var data="<tr class='test'><td><input type='checkbox' class='chkbox'/></td>";
            data+="<td><span id='sn"+i+"'>"+count+".</span></td>";
            data+="<td><input class='form-control autocomplete_txt' type='text' data-type='terminalid' id='terminalid_"+i+"' name='terminalid[]'/></td>";
            data+="<td><input class='form-control autocomplete_txt' type='text' data-type='atmname' id='atmname_"+i+"' name='atmname[]' /></td>";
            data+="<td><input class='form-control autocomplete_txt' type='text' data-type='custodian_phone' id='custodian_phone_"+i+"' name='custodian_phone[]'/></td>";
            data+="<td><input class='form-control autocomplete_txt1' type='text'  name='errorcode[]'/></td></tr>";
            $('#tableauto').append(data);
            i++;
        });

        function select_all() {
            $('input[class=chkbox]:checkbox').each(function(){
                if($('input[class=check_all]:checkbox:checked').length == 0){
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }
        function updateSerialNo(){
            obj=$('table tr').find('span');
            $.each( obj, function( key, value ) {
                id=value.id;
                $('#'+id).html(key+1);
            });
        }
        //autocomplete script
        $(document).on('focus','.autocomplete_txt',function(){
            type = $(this).data('type');

            if(type =='terminalid' )autoType='terminal_id';
            if(type =='atmname' )autoType='atm_name';
            if(type =='custodian_phone' )autoType='custodian_phone';
//            if(type =='errorcode' )autoType='errorcode';

            $(this).autocomplete({
                minLength: 0,
                source: function( request, response ) {
                    $.ajax({
                        url: "<?php echo e(route('searchatm')); ?>",
                        dataType: "json",
                        data: {
                            term : request.term,
                            type : type,
                        },
                        success: function(data) {
                            var array = $.map(data, function (item) {
                                return {
                                    label: item[autoType],
                                    value: item[autoType],
                                    data : item
                                }
                            });
                            response(array)
                        }
                    });
                },
                select: function( event, ui ) {
                    var data = ui.item.data;
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    elementId = id[id.length-1];
                    $('#terminalid_'+elementId).val(data.terminal_id);
                    $('#atmname_'+elementId).val(data.atm_name);
                    $('#custodian_phone_'+elementId).val(data.custodian_phone);
//                    $('#errorcode'+elementId).val(data.errorcode);
                }
            });


        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('atmreport.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>