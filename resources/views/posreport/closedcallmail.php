
                          <table id="example1" class="table table-bordered table-striped">
			          <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    <th>Error Code</th>
                                    <th>Vendor</th>
                                    <th>Status</th>

                                    <th>Logged Time</th>
                                    <th>Action</th>
                                    {{--<th>NoK Name/Mobile</th>--}}
                                    {{--<th width="20%">Action</th>--}}
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
                                        <td>{{ $atmreport->vendor_name }}</td>
{{--                                        <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}
                                        <td>{{ $atmreport->request_status }}</td>
                                        <td>{{ $atmreport->created_at }}</td>
{{--                                        <td>{{ $atmreport->username }}</td>--}}

                                        {{--<td>{{$atmreport->brand ? $atmreport->brand->name : 'No Brand'}}</td>--}}
                                        {{--<td>{{$atmreport->category ? $atmreport->category->name : 'No Category'}}</td>--}}
                                        {{--<td>--}}

{{--                                                <a href="{{ route('atmreport-management.edit', ['id' => $atmreport->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">--}}
                                                {{--<a href="#" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">--}}
                                                    {{--Send Mail--}}
                                                {{--</a>--}}
                                                {{--<a href="{{route('atmreport-management.show', $atmreport)}}" class="btn btn-success col-sm-3 col-xs-5 btn-margin">View</a>--}}

{{--                                               <a href="{{route('atmreport-management.checkIn', $atmreport)}}" class="btn btn-primary col-sm-3 col-xs-5 btn-margin">CheckIn</a>--}}

                                        {{--</td>--}}
                                        <td>   <button class="show-modal btn btn-success" data-id="{{$atmreport->id}}" data-title="{{$atmreport->terminal_id}}" data-content="{{$atmreport->address}} -- {{$atmreport->custodian_phone}}-- {{$atmreport->decline_reason}}"
                                                       data-assign="{{$atmreport->ce_name}}" data-status="{{$atmreport->ce_status}}" data-timer="{{$atmreport->ce_arrival_time}}">
                                                <span class="glyphicon glyphicon-eye-open"></span> Show</button></td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    <th>Error Code</th>
                                    <th>Vendor</th>
                                    <th>Status</th>

                                    <th>Logged Time</th>
                                    <th>Action</th>
                                    {{--<th>NoK Name/Mobile</th>--}}
                                    {{--<th width="20%">Action</th>--}}
                                </tr>
                                </tfoot>
                            </table>


                                <div id="showModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="id">ID:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="id_show" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="title">Terminal ID:</label>
                                                        <div class="col-sm-9">
                                                            <input type="name" class="form-control" id="title_show" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">Detail:</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control" id="content_show" cols="40" rows="5" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">Assigned CE:</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" id="assign_show" cols="40" rows="5" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">CE Status:</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" id="status_show" cols="40" rows="5" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="content">Expected Arrival Time:</label>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" id="timer_show" cols="40" rows="5" disabled>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                        <span class='glyphicon glyphicon-remove'></span> Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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


        <!-- jQuery -->
        {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> --}}
        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

        <!-- Bootstrap JavaScript -->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

        <!-- toastr notifications -->
        {{-- <script type="text/javascript" src="{{ asset('toastr/toastr.min.js') }}"></script> --}}
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <!-- icheck checkboxes -->
        <script type="text/javascript" src="{{ asset('icheck/icheck.min.js') }}"></script>

        <!-- Delay table load until everything else is loaded -->
        <script>
            $(window).load(function(){
                $('#postTable').removeAttr('style');
            })
        </script>


        <!-- AJAX CRUD operations -->
        <script type="text/javascript">

            // Show a post   data-timer; data-status, data-assign
            $(document).on('click', '.show-modal', function() {
                $('.modal-title').text('Show');
                $('#id_show').val($(this).data('id'));
                $('#title_show').val($(this).data('title'));
                $('#content_show').val($(this).data('content'));
                $('#assign_show').val($(this).data('assign'));
                $('#status_show').val($(this).data('status'));
                $('#timer_show').val($(this).data('timer'));
                $('#showModal').modal('show');
            });

            </script>






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