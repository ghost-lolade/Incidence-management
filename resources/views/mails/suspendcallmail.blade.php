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
@foreach ($atmreports as $atmreport)


    <br/>
    <br/>
Dear Support,
<br/>
<br/>
This call is {{ $atmreport->request_status }}
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
                                    {{--<th>Closure Remark</th>--}}
                                    <th>Reason/ Remark</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr role="row" class="odd">
{{--                                        <td><img src="../{{$atmreport->picture }}" width="50px" height="50px"/></td>--}}
                                        <td>{{ $atmreport->id }}</td>
                                        <td>{{ $atmreport->terminal_id }}</td>
                                        <td>{{ $atmreport->atm_name }}</td>
{{--                                        <td>{{ $atmreport->address }}</td>--}}
                                        <td>{{ $atmreport->error_code}}</td>
{{--                                        <td>{{ $atmreport->vendor_name }}</td>--}}
{{--                                        <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}
                                        <td>{{ $atmreport->request_status }}</td>
                                        <td>{{ $atmreport->created_at }}</td>
                                        <td>{{ $atmreport->suspend_day }}</td>
                                        <td>{{ $atmreport->suspend_time }}</td>
                                        {{--<td>{{ $atmreport->suspend_comment }}</td>--}}
                                        <td>{{ $atmreport->suspend_comment }}</td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>


  </body>
</html>