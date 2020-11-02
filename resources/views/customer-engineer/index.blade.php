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
                        {{--<h3 class="box-title">List of Open Call </h3>--}}
                        <h3 class="box-title">List of Customer Engineer {{$date = date('Y-m-d H:i:s')}} </h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{ route('engineer-management.create') }}">Add New CE</a>
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
                            {{--<div class="box-header">--}}
                                {{--<h3 class="box-title">Registered atmreport</h3>--}}
                            {{--</div>--}}
                            <!-- /.box-header -->
                            <div class="box-body">
               
                          <table id="example1" class="table table-bordered table-striped">
			          <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CE Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Address</th>
                                    
                                    <th>Level</th>

                                    <th>State</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cedatas as $cedata)
                                    <tr role="row" class="odd">
{{--                                        <td><img src="../{{$cedata->picture }}" width="50px" height="50px"/></td>--}}
                                        <td>{{ $cedata->id }}</td>
                                        <td>{{ $cedata->name }}</td>
                                        <td>{{ $cedata->mobile }}</td>
{{--                                        <td>{{ $cedata->address }}</td>--}}
                                        <td>{{ $cedata->email_address}}</td>
                                       
{{--                                        <td>{{$cedata->insurance ? $cedata->insurance->name : 'No atmreport type'}}</td>--}}
                                        <td>{{ $cedata->level }}</td>
                                        <td>{{ $cedata->state }}</td>
                                    <td>
                                        <a href="{{ route('engineer-management.edit', ['id' => $cedata->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                            Update
                                        </a>
                                        <a href="{{route('engineer-management.show', $cedata)}}" class="btn btn-success col-sm-3 col-xs-5 btn-margin">View</a>

{{--                                        <a href="{{route('engineer-management.checkIn', $cedata)}}" class="btn btn-primary col-sm-3 col-xs-5 btn-margin">CheckIn</a>--}}
                                    </td>

                              </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>CE Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Address</th>
                                    <th>Vendor</th>
                                    <th>Level</th>

                                    <th>State</th>
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
                            title: 'Call Log_ {{$date}}',

                        },
                        {
                            extend: 'excel',
                            title: 'Call Log_ {{$date}}'
                        },
                        {
                        extend: 'pdf',
                        title: 'Call Log_ {{$date}}'
                        },
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