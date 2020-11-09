{{--<!doctype html>--}}
{{--<html>--}}
{{--<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">--}}
{{--    <title>Import CSV Data to MySQL database with Laravel</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<!-- Message -->--}}
{{--@if(Session::has('message'))--}}
{{--    <p >{{ Session::get('message') }}</p>--}}
{{--@endif--}}

{{--<!-- Form -->--}}
{{--<form method='post' action='/uploadFile' enctype='multipart/form-data' >--}}
{{--</body>--}}
{{--</html>--}}



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

                                {!! Form::open(['method'=>'POST', 'action'=> 'PosLogController@uploadCallLogFile','files'=>true]) !!}

                                {{ csrf_field() }}
                                <input type='file' name='file' required >
                                <input type='submit' name='submit' value='Import'>
                                </form>


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