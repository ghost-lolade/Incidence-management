@extends('vendorreport.base')
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
                        <a class="btn btn-primary" href="{{ url('logeco') }}">Log Incidence</a>
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



                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th width="50px">Terminal ID</th>
                                        <th width="50px">Date</th>
                                        <th width="50px">Count</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr><td></td>
                                    <td>Number of Calls Escalated to Vendor</td>
                                    <td>{{$callcount}}</td>
                                    </tr>
                                    <tr><td></td>
                                        <td>Total Cost of ATM Replaced Part</td>
                                        <td>{{$atmpartcost}}</td>
                                    </tr>

                                    </tbody>

                                </table>


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Incident ID</th>
                                        <th>Log Date</th>
                                        <th>Terminal ID</th>

                                        <th>POS Number</th>
                                        <th>ATM Address</th>
                                        <th>ATM State </th>
                                        <th>Error Code</th>
                                        {{-- <th>Custodian Detail</th> --}}
                                        <th>Vendor ID</th>
                                        <th>Suspend At</th>
                                        <th>Reopen At</th>
                                        <th>Call Status </th>
                                        <th>Part Replace/ Remark</th>
                                        <th>Closure Date</th>
                                        <th>ATM Brand</th>
                                        <th>Logged By</th>

                                        {{--<th>NoK Name/Mobile</th>--}}


                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($atmreports as $atmreport)
                                        <tr role="row" class="odd">
                                            {{--                                        <td><img src="../{{$atmreport->picture }}" width="50px" height="50px"/></td>--}}
                                            <td>{{ $atmreport->incidence_no }}</td>
                                            <td>{{ $atmreport->created_at }}</td>
                                            <td>{{ $atmreport->pos_id }}</td>

                                            <td>{{ $atmreport->serial_no }}</td>
                                            <td>{{ $atmreport->branch }}</td>
                                            <td>{{ $atmreport->status }}</td>
                                            <td>{{ $atmreport->fault_description}}</td>
                                            {{-- <td>{{ $atmreport->custodian_phone}}</td> --}}
                                            <td>{{ $atmreport->vendor_id }}</td>



                                            <td>{{ $atmreport->suspend_at }}</td>
                                            <td>{{ $atmreport->reopen_at }}</td>
                                            <td>{{ $atmreport->request_status }} - {{ $atmreport->remark }}</td>
                                            <td>{{ $atmreport->part_replaced }} - {{ $atmreport->closure_comment }}</td>
                                            <td>{{ $atmreport->closure_time }}</td>
                                            {{-- <td>{{ $atmreport->brand }}</td> --}}
                                            <td>{{ $atmreport->fromaddress }}</td>
                                            {{--                                            <td>{{  $diff_in_days = $to_date->diffInDays($atmreport->log_day) }}</td>--}}
                                            {{--
                                            $diff_in_days = $to_date->diffInDays($atmreport->request_status);
                                                                                 <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}





                                            {{--                                        <td>{{ $atmreport->username }}</td>--}}

                                            {{--<td>{{$atmreport->brand ? $atmreport->brand->name : 'No Brand'}}</td>--}}
                                            {{--<td>{{$atmreport->category ? $atmreport->category->name : 'No Category'}}</td>--}}
                                            {{--<td>--}}

                                            {{--<a href="{{ route('atmreport-management.edit', ['id' => $atmreport->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">--}}
                                            {{--Update--}}
                                            {{--</a>--}}
                                            {{--<a href="{{route('atmreport-management.show', $atmreport)}}" class="btn btn-success col-sm-3 col-xs-5 btn-margin">View</a>--}}

                                            {{--                                                <a href="{{route('atmreport-management.checkIn', $atmreport)}}" class="btn btn-primary col-sm-3 col-xs-5 btn-margin">CheckIn</a>--}}

                                            {{--</td>--}}

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>



                            </div>

                            <table id="example3" class="table table-bordered table-striped">    <thead>
                                <tr>
                                    <th valign="middle">#</th>
                                    <th>ID</th>
                                    <th>ATM Name</th>
                                    <th>ATM Part</th>
                                    <th>Amount</th>
                                    <th>Invoice No</th>
                                    <th>Logged Time</th>


                                </tr>
                                {{ csrf_field() }}
                                </thead>
                                <tbody>
                                @foreach($atmparts as $indexKey => $atmparts)
                                    <tr class="item{{$atmparts->id}}">
                                        <td class="col1">{{ $indexKey+1 }}</td>
                                        <td>{{$atmparts->terminal_id}}
                                            <button class="show-modal btn btn-success" data-id="{{$atmparts->terminal_id}}" data-title="{{$atmparts->part_name}}" data-content="{{$atmparts->price}}"
                                                    data-assign="{{$atmparts->approved_by}}" data-status="{{$atmparts->supplier_by}}" data-timer="{{$atmparts->user->lastname}}, {{$atmparts->user->firstname}}">
                                                <span class="glyphicon glyphicon-eye-open"></span></button>

                                        </td>
                                        <td>
                                            {{$atmparts->atm_name}}
                                        </td>
                                        <td>
                                            {{$atmparts->part_name}}
                                        </td>
                                        <td>
                                            &#x20A6 {{number_format($atmparts->price, 2)}}
                                            {{--                                            {{$atmparts->price}}--}}
                                        </td>
                                        <td>
                                            {{$atmparts->invoice_no}}
                                        </td>

                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $atmparts->created_at)->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
            $(document).ready(function() {
                $('#example3').DataTable({
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



        {{--<script>--}}
            {{--$(function () {--}}
                {{--$('#example1').DataTable()--}}
                {{--$('#example2').DataTable({--}}
                    {{--'paging'      : true,--}}
                    {{--'lengthChange': false,--}}
                    {{--'searching'   : false,--}}
                    {{--'ordering'    : true,--}}
                    {{--'info'        : true,--}}
                    {{--'autoWidth'   : false--}}
                {{--})--}}
            {{--})--}}
        {{--</script>--}}

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