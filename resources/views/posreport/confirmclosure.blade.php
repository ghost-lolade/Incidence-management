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
                        <h3 class="box-title">List of Open Call {{$date = date('Y-m-d H:i:s')}}</h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{ route('confirmclosure.create') }}">Log Incidence</a>
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
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    <th>Error Code</th>
                                    <th>Vendor</th>
                                    <th>Status</th>

                                    <th>Logged Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($atmreports as $atmreport)
                                    <tr role="row" class="odd">
                                        <td>{{ $atmreport->id }}</td>
                                        <td>{{ $atmreport->terminal_id }}</td>
                                        <td>{{ $atmreport->atm_name }}</td>
                                        <td>{{ $atmreport->error_code}}</td>
                                        <td>{{ $atmreport->vendor_name }}</td>
                                        <td>{{ $atmreport->request_status }}</td>
                                        <td>{{ $atmreport->close_day }}</td>

                                        <td>   <button class="show-modal btn btn-success" data-id="{{$atmreport->id}}" data-title="{{$atmreport->terminal_id}}" data-content="{{$atmreport->address}} -- {{$atmreport->custodian_phone}}-- {{$atmreport->decline_reason}}"
                                                       data-assign="{{$atmreport->ce_name}}" data-status="{{$atmreport->ce_status}}" data-timer="{{$atmreport->ce_arrival_time}}">
                                                <span class="glyphicon glyphicon-eye-open"></span> Show</button>
                                            <button class="delete-modal btn btn-primary" data-id="{{$atmreport->id}}" data-title="{{$atmreport->terminal_id}}" data-content="{{$atmreport->content}}">
                                                <span class="glyphicon glyphicon-edit"></span> Confirm</button>
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($atmnotclose as $atmnotclose)
                                    <tr role="row" class="odd">
                                        <td>{{ $atmnotclose->id }}</td>
                                        <td>{{ $atmnotclose->terminal_id }}</td>
                                        <td>{{ $atmnotclose->atm_name }}</td>
                                        <td>{{ $atmnotclose->error_code}}</td>
                                        <td>{{ $atmnotclose->vendor_name }}</td>
                                        <td>{{ $atmnotclose->request_status }}</td>
                                        <td>{{ $atmnotclose->close_day }}</td>

                                        <td>   <button class="show-modal btn btn-success" data-id="{{$atmnotclose->id}}" data-title="{{$atmnotclose->terminal_id}}" data-content="{{$atmnotclose->address}} -- {{$atmnotclose->custodian_phone}}-- {{$atmnotclose->decline_reason}}"
                                                       data-assign="{{$atmnotclose->ce_name}}" data-status="{{$atmnotclose->ce_status}}" data-timer="{{$atmnotclose->ce_arrival_time}}">
                                                <span class="glyphicon glyphicon-eye-open"></span> Show</button>
                                            <button class="delete-modal btn btn-primary" data-id="{{$atmnotclose->id}}" data-title="{{$atmnotclose->terminal_id}}" data-content="{{$atmnotclose->content}}">
                                                <span class="glyphicon glyphicon-edit"></span> Confirm</button>
                                        </td>
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

                                <!-- Modal form to delete a form -->
                                <div id="deleteModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <h3 class="text-center">Confirm Incidence Status?</h3>
                                                <br />
                                                <form class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="id">ID:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="id_delete" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="title">Terminal ID:</label>
                                                        <div class="col-sm-10">
                                                            <input type="name" class="form-control" id="title_delete" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="content">Change Status:</label>
                                                        <div class="col-sm-10">
                                                            <select class="control-label col-sm-4"  id="closure_edit" required >
                                                                <option  value="">Select Option</option>
                                                                <option  value="Closed">Accept</option>
                                                                <option value="Decline">Decline</option>
                                                            </select>
                                                            {{--<input class="form-control" id="closure_edit" cols="40" rows="5"></input>--}}
                                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="content">Remark:</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" id="content_edit" cols="40" rows="5"></textarea>
                                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                                        </div>
                                                    </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary delete" data-dismiss="modal">
                                                        <span id="" class='glyphicon glyphicon-check'></span> YES
                                                    </button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                        <span class='glyphicon glyphicon-remove'></span> Close
                                                    </button>
                                                </div>
                                            {{--</div>--}}
                                                </form>
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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

        <!-- toastr notifications -->
        {{-- <script type="text/javascript" src="{{ asset('toastr/toastr.min.js') }}"></script> --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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

            // delete a post
            $(document).on('click', '.delete-modal', function() {
                $('.modal-title').text('Confirm');
                $('#id_delete').val($(this).data('id'));
                $('#title_delete').val($(this).data('title'));
               $('#closure_edit').val($(this).data('closure_mail'));
                $('#content_edit').val($(this).data('remark'));

                $('#to').val($(this).data('close_day'));
                $('#timeDate2').val($(this).data('close_time'));
                $('#deleteModal').modal('show');
                id = $('#id_delete').val();
            });
            $('.modal-footer').on('click', '.delete', function() {
                $.ajax({
                    type: 'DELETE',
                    url: 'confirmclosure/' + id,
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $("#id_edit").val(),
                        'title': $('#edit_terminal').val(),
                       'closure_mail': $('#closure_edit').val(),
                       'remark': $('#content_edit').val(),
                        'close_day': $('#to').val(),
                        'close_time': $('#timeDate2').val()
                    },
                    success: function(data) {
                        toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                        $('.item' + data['id']).remove();
                        $('.col1').each(function (index) {
                            $(this).html(index+1);
                        });
                    }
                });
            });
            </script>
    <!-- /.content -->
    </div>
@endsection