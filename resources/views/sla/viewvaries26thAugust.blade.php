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
{{--                                            <th>Vendor</th>--}}
{{--                                            <th>Status</th>--}}

                                            <th>Logged Time</th>
                                            {{--<th>NoK Name/Mobile</th>--}}
                                            <th>Closure Time </th>
{{--                                            <th>SLA</th>--}}
                                            <th>Day </th>
                                            <th>Hours </th>
                                            <th>Actual Resolution</th>
                                            <th>SLA Default</th>
                                            <th>Penalty </th>
                                            <th>Penalty </th>
                                            <th>Penalty </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($atmreports as $atmreport)
                                            <tr role="row" class="odd">
                                                {{--                                        <td><img src="../{{$atmreport->picture }}" width="50px" height="50px"/></td>--}}
                                                <td>{{ $atmreport->id }}</td>
                                                <td>{{ $atmreport->terminal_id }}</td>
                                                <td>{{ $atmreport->atm_name }}</td>
                                                {{--                                        <td>{{ $atmreport->address }}</td>--}}
                                                <td>{{ $atmreport->error_code}}</td>
{{--                                                <td>{{ $atmreport->vendor_name }}</td>--}}
                                                {{--                                        <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}
                                                <td> {{$created_at = \Carbon\Carbon::parse($atmreport->created_at)}}</td>
                                                <td> {{$closed_at = \Carbon\Carbon::parse($atmreport->closed_at)}}</td>
{{--                                                <td>{{ $atmreport->sla_hour }} hrs</td>--}}
                                                <td>{{$closure_day = $created_at->diffInDays($closed_at, false)}}</td>
{{--                                                    "--" {{$closure_timer = $created_at->diffInHours($closed_at, false)}}</td>--}}
                                                <td> {{$timeDiffCloseLog = $created_at->diffInHours($closed_at, false)}}</td>
{{--                                                <td>{{(int)$closure_timer = $created_at->diffInWeekendDays($closed_at)}}</td>--}}
{{--                                                <td>{{(int)$closure_timer*13}}     $date1->diffInWeekendDays($date2);</td>--}}
{{--                                                DAYS MUTLIPLY BY SLA--}}
                                                <td>{{(int)$dayss  =(10/24) * $timeDiffCloseLog}}</td>
                                                <td>{{(int)$ActualResolution= $dayss - $atmreport->sla_hour}}</td>


{{--                                                <td>{{ $atmreport->sla_hour * (int)$closure_day}}</td>--}}
                                            {{-- Convert TIME DIFFRENCE OF WEEKEND TO DAYS AND HOURS --}}
                                                <td>{{$weekend = $created_at->diffInWeekendDays($closed_at)}} --{{ $weekEndHour=($weekend*24)}} </td>
                                                {{-- Convert TIME DIFFRENCE OF WEEKDAY TO DAYS AND HOURS  AND SUBTRACT ACTUAL diffInHours from the Hours of
                                                Weekday call to make it balance $dayToHourWeekDayEnd =--}}
                                                <td>{{$weekdays = $created_at->diffInWeekdays($closed_at)}}--{{$daysToHours = ($weekdays*24) }}--
                                                    {{ $diffBtwTotalSeperate =$timeDiffCloseLog - (($weekdays*24)+($weekend*24))}}
                                                    -- {{ $daysToHours+$diffBtwTotalSeperate}}    -- {{ $weekEndHour+$daysToHours+$diffBtwTotalSeperate}}</td>
                                                <td>{{ ($weekdays*24)+($weekend*24)}} -- {{ $Actual2= ((10/24)* ($weekdays*24)+(4/24)* ($weekend*24))/24 }}</td>
{{--                                                @if ($closure_timer <=48)--}}
{{--                                                    <td> {{number_format(0000)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=48 && $closure_timer <=72)--}}
{{--                                                    <td> {{number_format(1500,2)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=72 && $closure_timer <=96)--}}
{{--                                                    <td> {{number_format(3000,2)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=96 && $closure_timer <=120)--}}
{{--                                                    <td> {{number_format(6000,2)}}</td>--}}
{{--                                                @endif--}}

{{--                                                @if ($closure_timer >=120 && $closure_timer <=144)--}}
{{--                                                    <td>  {{number_format(7500,2)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=144 && $closure_timer <=168)--}}
{{--                                                    <td>  {{number_format(10000,2)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=168 && $closure_timer <=192)--}}
{{--                                                    <td>  {{number_format(12500,2)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=192 && $closure_timer <=216)--}}
{{--                                                    <td>   {{number_format(15000,2)}}</td>--}}
{{--                                                @endif--}}
{{--                                                @if ($closure_timer >=216)--}}
{{--                                                    <td>   {{number_format(25000,2)}}</td>--}}

{{--                                                @endif--}}


                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terminal ID</th>
                                            <th>ATM Name</th>
                                            <th>Error Code</th>
{{--                                            <th>Vendor</th>--}}
{{--                                            <th>Status</th>--}}

                                            <th>Logged Time</th>
                                            {{--<th>NoK Name/Mobile</th>--}}
                                            <th>Closure Time </th>
{{--                                            <th>SLA</th>--}}
                                            <th>Day </th>
                                            <th>Hours </th>
                                            <th>Actual Resolution</th>
                                            <th>SLA Default</th>
                                            <th>Penalty </th>
                                            <th>Penalty </th>
                                            <th>Penalty </th>
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
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false

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