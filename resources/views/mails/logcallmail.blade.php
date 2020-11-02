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
This is to inform you that the call is now OPEN:  <b>{{ $atmreport->subject }}</b>
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
                                    
                                    {{--<th>Closure Remark</th>--}}
                                    {{--<th>Part Replaced</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                              
                                    <tr role="row" class="odd">
                                        <td>{{ $atmreport->ticket_no }}</td>
                                        <td>{{ $atmreport->terminal_id }}</td>
                                        <td>{{ $atmreport->atm_name }}</td>
                                        <td>{{ $atmreport->ce_name }}</td>
                                       
{{--                                        <td>{{ $atmreport->vendor_name }}</td>--}}
{{--                                        <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}
                                        <td>{{ $atmreport->request_status }}</td>
                                        <td>{{ $atmreport->created_at }}</td>
                                        <td>{{ $atmreport->vendor_name }}</td>
                                        <td>{{ $atmreport->custodian_email }} - {{ $atmreport->custodian_phone }}</td>
                                        
                                         <td>{{ $atmreport->error_code}}</td>
                                         
                                        {{--<td>{{ $atmreport->suspend_comment }}</td>--}}
                                        {{--<td>{{ $atmreport->closure_comment }}</td>--}}

                                    </tr>
                                </tbody>

                            </table>


</body>
</html>