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
<?php $__currentLoopData = $atmreports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atmreport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


    <br/>
    <br/>
Dear Support,
<br/>
<br/>
This call is <?php echo e($atmreport->request_status); ?>

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
                                    <th> Log Day</th>
                                    <th> Closed Day</th>

                                    <th> Closed Time</th>
                                    
                                    <th>Reason/ Remark</th>
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
                                        <td><?php echo e($atmreport->suspend_day); ?></td>
                                        <td><?php echo e($atmreport->suspend_time); ?></td>
                                        
                                        <td><?php echo e($atmreport->suspend_comment); ?></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                            </table>


  </body>
</html>