<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<?php $__currentLoopData = $atmreports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmreport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


    <br/>
    <br/>
    Dear Support,
    <br/>
    <br/>
This is to inform you that the call is now RESOLVED
<br/>
<br/>
<table id="customers">
    <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    <th>Error Code</th>
                                    
                                    <th>Status</th>
                                    <th>Log Daytime</th>
                                    <th>Closed Date</th>
                                    <th>Remark</th>
                                    
                                    <th>Part Replaced</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr role="row" class="odd">

                                        <td><?php echo e($atmreport->id); ?></td>
                                        <td><?php echo e($atmreport->terminal_id); ?></td>
                                        <td><?php echo e($atmreport->atm_name); ?></td>

                                        <td><?php echo e($atmreport->error_code); ?></td>


                                        <td><?php echo e($atmreport->request_status); ?></td>
                                        <td><?php echo e($atmreport->created_at); ?></td>
                                        <td><?php echo e($atmreport->close_day); ?>  <?php echo e($atmreport->close_time); ?></td>
                                        <td><?php echo e($atmreport->closure_comment); ?>  </td>
                                        
                                        <td><?php echo e($atmreport->part_replaced); ?></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                            </table>


</body>
</html>