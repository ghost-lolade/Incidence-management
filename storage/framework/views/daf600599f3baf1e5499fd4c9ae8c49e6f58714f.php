<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>


    <br/>
    <br/>
    Dear Support,
    <br/>
    <br/>
This is to inform you that the call is now OPEN:  <b><?php echo e($atmreport->subject); ?></b>
<br/>
<br/>
<table id="customers">
    <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    
                                    <th>Assigned CE</th>
                                    <th>Status</th>
                                    <th>Log Time</th>
                                    <th>Vendor </th>
                                    <th>Custodian Detail</th>
                                    <th>Error Detail</th>
                                    
                                    
                                    
                                </tr>
                                </thead>
                                <tbody>
                              
                                    <tr role="row" class="odd">
                                        <td><?php echo e($atmreport->ticket_no); ?></td>
                                        <td><?php echo e($atmreport->terminal_id); ?></td>
                                        <td><?php echo e($atmreport->atm_name); ?></td>
                                        <td><?php echo e($atmreport->ce_name); ?></td>
                                       


                                        <td><?php echo e($atmreport->request_status); ?></td>
                                        <td><?php echo e($atmreport->created_at); ?></td>
                                        <td><?php echo e($atmreport->vendor_name); ?></td>
                                        <td><?php echo e($atmreport->custodian_email); ?> - <?php echo e($atmreport->custodian_phone); ?></td>
                                        
                                         <td><?php echo e($atmreport->error_code); ?></td>
                                         
                                        
                                        

                                    </tr>
                                </tbody>

                            </table>


</body>
</html>