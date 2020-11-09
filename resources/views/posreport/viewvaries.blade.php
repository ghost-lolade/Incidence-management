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
                        <a class="btn btn-primary" href="{{ route('posreport-management.create') }}">Add New PoS Report</a>
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
                                <h2 class="box-title">POS Report --  {{$date = date('Y-m-d H:i:s')}}</h2>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">



                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Incident ID</th>
                                        <th>Log Date</th>
                                        <th>Terminal ID</th>

                                        <th>ATM Name</th>
                                        <th>ATM Address</th>
                                        <th>ATM State </th>
                                        <th>Error Code</th>
                                        <th>Custodian Detail</th>
                                        <th>Vendor</th>
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
                                            <td>{{ $atmreport->id }}</td>
                                            <td>{{ $atmreport->mail_at }}</td>
                                            <td>{{ $atmreport->terminal_id }}</td>

                                            <td>{{ $atmreport->atm_name }}</td>
                                            <td>{{ $atmreport->address }}</td>
                                            <td>{{ $atmreport->atm_state }}</td>
                                            <td>{{ $atmreport->error_code}}</td>
                                            <td>{{ $atmreport->custodian_phone}}</td>
                                            <td>{{ $atmreport->vendor_name }}</td>



                                            <td>{{ $atmreport->suspend_at }}</td>
                                            <td>{{ $atmreport->reopen_at }}</td>
                                            <td>{{ $atmreport->request_status }} - {{ $atmreport->remark }}</td>
                                            <td>{{ $atmreport->part_replaced }} - {{ $atmreport->closure_comment }}</td>
                                            <td>{{ $atmreport->closed_at }}</td>
                                            <td>{{ $atmreport->brand }}</td>
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
                                    {{--<tfoot>--}}
                                    {{--<tr>--}}
                                    {{--<th>Pat ID</th>--}}
                                    {{--<th>Terminal ID</th>--}}
                                    {{--<th>ATM Name</th>--}}
                                    {{--<th>Error Code</th>--}}
                                    {{--<th>Vendor</th>--}}
                                    {{--<th>Status</th>--}}

                                    {{--<th>Logged Time</th>--}}
                                    {{--<th>NoK Name/Mobile</th>--}}
                                    {{--<th>Action</th>--}}
                                    {{--</tr>--}}
                                    {{--</tfoot>--}}
                                </table>
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