@extends('atmreport.base')
@section('action-content')
    <!-- Main content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <section class="content">
        <div class="box">
            <div class="box-header">

                @if (session()->has('success_message'))
                    <div class="alert alert-success">
                        {{ session()->get('success_message') }}
                    </div>
                @endif

                @if (session()->has('error_message'))
                    <div class="alert alert-danger">
                        {{ session()->get('error_message') }}
                    </div>
                @endif



                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">List of Call logged</h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{ route('atmreport-management.create') }}">Add New atmreport</a>
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
                            <div class="box-header">
                                <h2 class="box-title">ATM Report --  {{$date = date('Y-m-d H:i:s')}}</h2>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-12">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terminal ID</th>
                                            <th>ATM Name</th>
                                            <th>Error Code</th>
                                            <th>Logged Time</th>
                                            <th>Closure Time </th>
                                            <th>Suspend Time</th>
                                            <th>Reopen Time </th>
                                            <th>Day </th>
                                            <th>Hours </th>
                                            <th>Work Hour</th>
                                            <th>SLA Default</th>
                                            <th>Weekend </th>
                                            <th>Weekday </th>
                                            <th>Day &Time </th>
                                            <th>Actual Time </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($atmreports as $atmreport)
                                            <tr role="row" class="odd">
                                                {{--                                        <td><img src="../{{$atmreport->picture }}" width="50px" height="50px"/></td>--}}
                                                <td>{{ $atmreport->id }}</td>
                                                <td>{{ $atmreport->terminal_id }}</td>
                                                <td>{{ $atmreport->atm_name }}</td>
                                                <td>{{ $atmreport->error_code}} {{$dayOfTheWeek = \Carbon\Carbon::parse($atmreport->created_at)->dayOfWeek  }}</td>
                                                <td> {{$created_at = \Carbon\Carbon::parse($atmreport->created_at)}}</td>
                                                <td> {{$closed_at = \Carbon\Carbon::parse($atmreport->closed_at)}}</td>
                                                <td> {{$suspend_at = \Carbon\Carbon::parse($atmreport->suspend_at)}}</td>
                                                <td> {{$reopen_at = \Carbon\Carbon::parse($atmreport->reopen_at)}}</td>
                                                <td>{{$closure_day = $created_at->diffInDays($closed_at, false)}}</td>
                                                <td> {{$timeDiffCloseLog = $created_at->diffInHours($closed_at, false)}}</td>
{{--                                                DAYS MUTLIPLY BY SLA--}}
                                                <td>{{(int)$dayss  =($atmreport->hour/24) * $timeDiffCloseLog}}</td>
                                                <td>{{(int)$ActualResolution= $dayss - $atmreport->sla_hour}}--
                                                 {{$atmreport->hour}}</td>

                                                @if ($atmreport->is_week == "Yes" )
                                            {{-- Convert TIME DIFFRENCE OF WEEKEND TO DAYS AND HOURS  AND HOURS WORK ON WEEKEND--}}
                                                <td>

                                                    {{$weekend = $created_at->diffInWeekendDays($closed_at)}} --{{ $weekEndHour=($weekend*24)}}
                                                --{{$weekEndToHours= 4* ($weekEndHour/24)  }}

                                                    {{$weekendSuspend = $suspend_at->diffInWeekendDays($reopen_at)}} --{{ $weekEndHourSuspend=($weekendSuspend*24)}}
                                                    --{{$weekEndToHoursSuspend= 4* ($weekEndHourSuspend/24)  }}
                                                </td>
                                                {{-- Convert TIME DIFFRENCE OF WEEKDAY TO DAYS AND HOURS  AND SUBTRACT ACTUAL diffInHours from the Hours of
                                                Weekday call to make it balance $dayToHourWeekDayEnd =--}}
                                                <td>{{$weekdays = $created_at->diffInWeekdays($closed_at)}}--{{$daysToHours = ($weekdays*24) }}--
                                                    {{ $diffBtwTotalSeperate =$timeDiffCloseLog - (($weekdays*24)+($weekend*24))}}
                                                    {{(int)$weekToHours=($atmreport->hour)* (($daysToHours+$diffBtwTotalSeperate)/24)}}
{{--                                                VERY IMPORTANT --}}

                                                </td>
{{--                                                TIME TAKING BEFORE APPLYING SLA--}}
                                                <td>{{(int)$totalInHours= $weekToHours+$weekEndToHours}}
                                                </td>
                                                    <td>
                                                         {{(int) $totalInDays=$totalInHours/24}} days -- {{ (int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays}} hours
                                                    </td>


                                                @endif


                                        @if ($atmreport->is_week == "No" )
                                        {{-- Convert TIME DIFFRENCE OF WEEKEND TO DAYS AND HOURS  AND HOURS WORK ON WEEKEND--}}
                                                <td>{{$weekend = $created_at->diffInWeekendDays($closed_at)}} --{{ $weekEndHour=($weekend*24)}}
                                                --{{$weekEndToHours= 0 * ($weekEndHour/24)  }}
                                                </td>
                                                <td>{{$weekdays = $created_at->diffInWeekdays($closed_at)}}--{{$daysToHours = ($weekdays*24) }}--
                                                    {{ $diffBtwTotalSeperate =$timeDiffCloseLog - (($weekdays*24)+($weekend*24))}}
                                                    {{(int)$weekToHours=($atmreport->hour)* (($daysToHours+$diffBtwTotalSeperate)/24)}}
{{--                                                VERY IMPORTANT --}}
                                                </td>
{{--                                                TIME TAKING BEFORE APPLYING SLA--}}
                                                <td>{{(int)$totalInHours= $weekToHours+$weekEndToHours}}
                                                </td>

                                                    <td>{{(int) $totalInDays=$totalInHours/24}} days -- {{ (int)$result=24*$totalHoursRemain=$totalInDays-(int)$totalInDays}} hours
                                                         </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terminal ID</th>
                                            <th>ATM Name</th>
                                            <th>Error Code</th>
                                            <th>Logged Time</th>
                                            <th>Closure Time </th>
                                            <th>Suspend Time</th>
                                            <th>Reopen Time </th>
                                            <th>Day </th>
                                            <th>Hours </th>
                                            <th>Work Hour</th>
                                            <th>SLA Default</th>
                                            <th>Weekend </th>
                                            <th>Weekday </th>
                                            <th>Day &Time </th>
                                            <th>Actual Time </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.box-body -->
        </div>


        <!-- /.content-wrapper -->





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
                            title: 'ATM Report_ {{$date}}',

                            {{--                            title: 'ATM Report {{$ldate = date(\'Y-m-d H:i:s\')}}  '--}}
                        },
                        {
                            extend: 'excel',
                            title: 'ATM Report_ {{$date}}'
                        },
                        {
                            extend: 'pdf',
                            title: 'ATM Report_ {{$date}}'
                        },
//                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            });
        </script>



        <script>
            $(function () {
//
                $('#example2').DataTable({
                    'paging': true,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false

                })
            })
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
@endsection