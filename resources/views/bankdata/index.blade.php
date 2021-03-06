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
                        <h3 class="box-title">List of ATM </h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{ route('atmdata-management.create') }}">Add New ATM</a>
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
                                <h2 class="box-title">ATM Estate --  {{$date = date('Y-m-d H:i:s')}}</h2>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
               
                          <table id="example1" class="table table-bordered table-striped">
			          <thead>
                                <tr>
                                    <th> ID</th>
                                    <th>Terminal ID</th>
                                    <th>Sol ID</th>
                                    <th>ATM Name</th>
                                    <th>Address</th>
                                    <th>Vendor</th>
                                    <th>Brand</th>
                                    {{--<th>NoK Name/Mobile</th>--}}
                                    <th>Model</th>
                                    <th>State</th>
                                    <th>Region</th>
                                    <th>Custodian Info</th>
                                    <th>Sla Hour</th>
                                    <th>Bank</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($atmreports as $atmreport)
                                    <tr role="row" class="odd">
{{--                                        <td><img src="../{{$atmreport->picture }}" width="50px" height="50px"/></td>--}}



                                        <td><a href="{{ route('atmreport-management.edit', ['id' => $atmreport->id]) }}"> {{ $atmreport->id }}</a></td>
                                        <td>{{ $atmreport->terminal_id }}</td>
                                        <td>{{ $atmreport->sol_id}}</td>
                                        <td>{{ $atmreport->atm_name }}</td>
                                        <td>{{ $atmreport->address }}</td>

                                        <td>{{ $atmreport->vendor_name }}</td>
                                        <td>{{ $atmreport->brand }}</td>
                                        <td>{{ $atmreport->model }}</td>
{{--                                        <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}
                                        <td>{{ $atmreport->state }}</td>
                                        <td>{{ $atmreport->region }}</td>
                                        <td>{{ $atmreport->custodian_phone }}</td>
                                        <td>{{ $atmreport->sla_hour }}</td>
                                        <td>{{ $atmreport->bank }}</td>
                                        {{--<td>{{$atmreport->brand ? $atmreport->brand->name : 'No Brand'}}</td>--}}
                                        {{--<td>{{$atmreport->category ? $atmreport->category->name : 'No Category'}}</td>--}}
                                        <td>


                                                <a href="{{route('atmdata-management.show', $atmreport)}}" class="btn btn-success col-sm-5 col-xs-5 btn-margin">
                                                    <span class="glyphicon glyphicon-eye-open"></span></a>

                                               {{--<a href="{{route('atmreport-management.checkIn', $atmreport)}}" class="btn btn-primary col-sm-3 col-xs-5 btn-margin">CheckIn</a>--}}

                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th> ID</th>
                                    <th>Terminal ID</th>
                                    <th>Sol ID</th>
                                    <th>ATM Name</th>
                                    <th>Address</th>
                                    <th>Vendor</th>
                                    <th>Brand</th>
                                    {{--<th>NoK Name/Mobile</th>--}}
                                    <th>Model</th>
                                    <th>State</th>
                                    <th>Region</th>
                                    <th>Custodian Info</th>
                                    <th>Sla Hour</th>
                                    <th>Bank</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
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








        {{--<script>--}}
            {{--$(function () {--}}
{{--//                $('#example1').DataTable()--}}
                {{--$('#example1').DataTable({--}}
                    {{--'paging'      : true,--}}
                    {{--'lengthChange': true,--}}
                    {{--'searching'   : true,--}}
                    {{--'ordering'    : true,--}}
                    {{--'info'        : true,--}}
                    {{--'autoWidth'   : false--}}
                {{--})--}}
            {{--})--}}
        {{--</script>--}}


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
                            title: 'ATM Estate_ {{$date}}',

                        },
                        {
                            extend: 'excel',
                            title: 'ATM Estate_ {{$date}}'
                        },
                        {{--{--}}
                            {{--extend: 'pdf',--}}
                            {{--title: 'ATM Estate_ {{$date}}'--}}
                        {{--},--}}
                    ]
                } );
            });
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