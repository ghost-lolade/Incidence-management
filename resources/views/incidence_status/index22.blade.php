@extends('atmreport.base')
@section('action-content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">Call Log  :: {{$date = date('Y-m-d H:i:s')}}</h3>
                    </div>
                    <div class="col-sm-4">
                        {{--                        <a class="btn btn-primary" href="{{ route('atmreport-management.create') }}">Add New atmreport</a>--}}
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>


            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
                                <thead>
                                <tr>
                                    <th valign="middle">#</th>
                                    <th>ID</th>
                                    <th>ATM Name</th>
                                    <th>Error Code</th>
                                    <th>Status</th>
                                    <th>Vendor</th>
                                    <th>Logged Time</th>
                                    <th>Action</th>

                                </tr>
                                {{ csrf_field() }}
                                </thead>
                                <tbody>
                                @foreach($posts as $indexKey => $post)

                                    <tr class="item{{$post->id}}">
                                        <td class="col1">{{ $indexKey+1 }}
                                        {{--<input id="sn" type="radio" name="chk" value="{{$post->id}}">--}}
                                        </td>
                                        <td>{{$post->terminal_id}}</td>
                                        <td>
                                            {{$post->atm_name}}
                                        </td>
                                        <td>
                                            {{$post->error_code}}
                                        </td>
                                        <td>
                                            {{$post->request_status}}
                                        </td>
                                        <td>
                                            {{$post->vendor_name}}
                                        </td>
                                        <td>{{ $post->created_at }}</td>
                                        {{--<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffForHumans() }}</td>--}}
                                        <td>
                                            <button class="show-modal btn btn-info" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content=" {{$post->atm_name}} --Suspend: {{$post->ce_suspend_reason}}-- Reopen: {{$post->reopen_reason}}"
                                                    data-assign="{{$post->ce_name}}" data-status="{{$post->ce_status}}" data-timer="{{$post->ce_arrival_time}}">
                                                <span class="glyphicon glyphicon-eye-open"></span> </button>
                                            <button class="edit-suspendcemodel btn btn-primary" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content="{{$post->vendor_request}}">
                                                <span class="glyphicon glyphicon-tint"></span> Suspend Call</button>
                                            <button class="edit-assignmodal btn btn-warning" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content="{{$post->vendor_request_status}}">
                                                <span class="glyphicon glyphicon-plus-sign"></span> Assign CE</button>
                                            <button class="delete-modal btn btn-success" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content="{{$post->content}}">
                                                <span class="glyphicon glyphicon-ok-circle"></span> Reopen CE Call</button>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel panel-default -->
                </div><!-- /.col-md-8 -->


                <!-- Modal form to show a post -->
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

                <!-- Modal form to edit a form -->
                <div id="editCESuspendModel" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="id">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="id_edit" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="title">Terminal ID:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="edit_terminal" disabled>
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="content">Suspension Reason:</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="suspend_edit" cols="40" rows="5"></textarea>
                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="content">Date:</label>
                                        <div class="col-sm-10">
                                            <input type="text"  class="form-control pull-right" id="to" placeholder="Select Date" >
                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="content">Time:</label>
                                        <div class="col-sm-10">
                                            <input type="text"  class="form-control pull-right" id="timeDate" placeholder="Select Time">
                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    {{--<div class="form-group">--}}
                                        {{--<label class="control-label col-sm-2" for="content">Picture:</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                            {{--<input type="file" id="picture" id="picture_edit" name="picture" >--}}
                                            {{--<p class="errorContent text-center alert alert-danger hidden"></p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                                        <span class='glyphicon glyphicon-check'></span> Submit
                                    </button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                        <span class='glyphicon glyphicon-remove'></span> Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal form Asssign CE form -->

                <div id="assignCEModal" class="modal fade" role="dialog">
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
                                            <input type="text" class="form-control" id="id_editCE" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Terminal ID:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="editCE_terminal" disabled>
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Assign CE:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="cedata_edit" required>
                                                <option value="">Select CE</option>
                                                @foreach ($cedata as $cedata)
                                                    <option value="{{$cedata->name}}, {{$cedata->mobile}}">{{$cedata->name}}, ({{$cedata->level}}-- {{$cedata->state}})</option>
                                                @endforeach
                                            </select>
                                            {{--<input type="text" class="form-control" id="title_edit" disabled>--}}
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="content">CE Status:</label>
                                        <div class="col-sm-9">

                                            <select class="form-control" id="ce_status_edit">
                                                <option value="">Where is the CE?</option>
                                                <option value="CE in Transit">CE in Transit</option>
                                                <option value="At another branch">At another branch</option>
                                                <option value="At the branch">At the branch</option>
                                            </select>
                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Expected Arrival Time:</label>
                                        <div class="col-sm-9">

                                            {{--<input type="text" value="{{ old('birthdate') }}" name="birthdate" class="form-control pull-right" id="birthDate" placeholder="Date of Birth" required>--}}

                                            <input class="form-control" id="cearrivaltime_edit" placeholder="30mins time" required>

                                            </input>
                                            {{--<input type="text" class="form-control" id="title_edit" disabled>--}}
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                                        <span class='glyphicon glyphicon-check'></span> Submit
                                    </button>
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
                                <h3 class="text-center">Are you sure you want to Close this call?</h3>
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
                                        <label class="control-label col-sm-2" for="title">Reopen Reason:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="reason" >
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary delete" data-dismiss="modal">
                                        <span id="" class='glyphicon glyphicon-check'></span> YES
                                    </button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                        <span class='glyphicon glyphicon-remove'></span> Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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




                    // Edit Assigned CE
                    // Edit a post
                    $(document).on('click', '.edit-suspendcemodel', function() {
                        $('.modal-title').text('Edit');
                        $('#id_edit').val($(this).data('id'));
                        $('#edit_terminal').val($(this).data('title'));
                        $('#suspend_edit').val($(this).data('ce_suspend'));
                        $('#to').val($(this).data('day_suspend'));
                        $('#timeDate').val($(this).data('time_suspend'));
                        id = $('#id_edit').val();
                        $('#editCESuspendModel').modal('show');
                    });
                    $('.modal-footer').on('click', '.edit', function() {
                        $.ajax({
                            type: 'PUT',
                            url: 'incidence-status/' + id,
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id': $("#id_edit").val(),
                                'title': $('#edit_terminal').val(),
                                'ce_suspend': $('#suspend_edit').val(),
                                'day_suspend': $('#to').val(),
                                'time_suspend': $('#timeDate').val()
                            },
                            success: function(data) {
                                $('.errorTitle').addClass('hidden');
                                $('.errorContent').addClass('hidden');

                                if ((data.errors)) {
                                    setTimeout(function () {
                                        $('#editCESuspendModel').modal('show');
                                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                                    }, 500);

                                    if (data.errors.title) {
                                        $('.errorTitle').removeClass('hidden');
                                        $('.errorTitle').text(data.errors.title);
                                    }
                                    if (data.errors.content) {
                                        $('.errorContent').removeClass('hidden');
                                        $('.errorContent').text(data.errors.content);
                                    }
                                } else {
                                    toastr.success('Successfully updated Post!', 'Success Alert', {timeOut: 5000});
                                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td class='col1'>" + data.id + "</td><td>" + data.terminal_id + "</td><td>" + data.atm_name + "</td><td>" + data.error_code + "</td><td>" + data.request_status + "</td><td>" + data.ce_name + "</td><td>" + data.created_at + "</td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-eye-open'></span> </button> <button class='edit-suspendcemodel btn btn-warning' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-tint'></span> Suspend Call</button> <button class='edit-assignmodal btn btn-info' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-plus-sign'></span> Assign CE</button> <button class='delete-modal btn btn-primary' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-ok-circle'></span> Reopen Call</button></td></tr>");

                                    if (data.is_published) {
                                        $('.edit_published').prop('checked', true);
                                        $('.edit_published').closest('tr').addClass('warning');
                                    }
                                    $('.edit_published').iCheck({
                                        checkboxClass: 'icheckbox_square-yellow',
                                        radioClass: 'iradio_square-yellow',
                                        increaseArea: '20%'
                                    });
                                    $('.edit_published').on('ifToggled', function(event) {
                                        $(this).closest('tr').toggleClass('warning');
                                    });
                                    $('.edit_published').on('ifChanged', function(event){
                                        id = $(this).data('id');
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{ URL::route('changeStatus') }}",
                                            data: {
                                                '_token': $('input[name=_token]').val(),
                                                'id': id
                                            },
                                            success: function(data) {
                                                // empty
                                            },
                                        });
                                    });
                                    $('.col1').each(function (index) {
                                        $(this).html(index+1);
                                    });
                                }
                            }
                        });
                    });


                     // Edit Assigned CE
                    // Edit a post
                    $(document).on('click', '.edit-assignmodal', function() {
                        $('.modal-title').text('Edit');
                        $('#id_editCE').val($(this).data('id'));
                        $('#editCE_terminal').val($(this).data('title'));
                        $('#ce_status_edit').val($(this).data('ce_status'));
                        $('#cedata_edit').val($(this).data('assign_ce'));
                        $('#cearrivaltime_edit').val($(this).data('ce_arrival_time'));
                        id = $('#id_editCE').val();
                        $('#assignCEModal').modal('show');
                    });
                    $('.modal-footer').on('click', '.edit', function() {
                        $.ajax({
                            type: 'PUT',
                            url: 'incidence-status/' + id,
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id': $("#id_editCE").val(),
                                'title': $('#editCE_terminal').val(),
                                'ce_status': $('#ce_status_edit').val(),
                                'assign_ce': $('#cedata_edit').val(),
                                'ce_arrival_time': $('#cearrivaltime_edit').val()
                            },
                            success: function(data) {
                                $('.errorTitle').addClass('hidden');
                                $('.errorContent').addClass('hidden');

                                if ((data.errors)) {
                                    setTimeout(function () {
                                        $('#assignCEModal').modal('show');
                                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                                    }, 500);

                                    if (data.errors.title) {
                                        $('.errorTitle').removeClass('hidden');
                                        $('.errorTitle').text(data.errors.title);
                                    }
                                    if (data.errors.content) {
                                        $('.errorContent').removeClass('hidden');
                                        $('.errorContent').text(data.errors.content);
                                    }
                                } else {
                                    toastr.success('Successfully updated Post!', 'Success Alert', {timeOut: 5000});
                                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td class='col1'>" + data.id + "</td><td>" + data.terminal_id + "</td><td>" + data.atm_name + "</td><td>" + data.error_code + "</td><td>" + data.request_status + "</td><td>" + data.ce_name + "</td><td>" + data.created_at + "</td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-eye-open'></span> </button> <button class='edit-suspendcemodel btn btn-warning' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-tint'></span> Suspend Call</button> <button class='edit-assignmodal btn btn-info' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-plus-sign'></span> Assign CE</button> <button class='delete-modal btn btn-primary' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-ok-circle'></span> Reopen CE Call</button></td></tr>");

                                    if (data.is_published) {
                                        $('.edit_published').prop('checked', true);
                                        $('.edit_published').closest('tr').addClass('warning');
                                    }
                                    $('.edit_published').iCheck({
                                        checkboxClass: 'icheckbox_square-yellow',
                                        radioClass: 'iradio_square-yellow',
                                        increaseArea: '20%'
                                    });
                                    $('.edit_published').on('ifToggled', function(event) {
                                        $(this).closest('tr').toggleClass('warning');
                                    });
                                    $('.edit_published').on('ifChanged', function(event){
                                        id = $(this).data('id');
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{ URL::route('changeStatus') }}",
                                            data: {
                                                '_token': $('input[name=_token]').val(),
                                                'id': id
                                            },
                                            success: function(data) {
                                                // empty
                                            },
                                        });
                                    });
                                    $('.col1').each(function (index) {
                                        $(this).html(index+1);
                                    });
                                }
                            }
                        });
                    });




                    // delete a post
                    $(document).on('click', '.delete-modal', function() {
                        $('.modal-title').text('Reopen Call');
                        $('#id_delete').val($(this).data('id'));
                        $('#title_delete').val($(this).data('title'));
                        $('#reason').val($(this).data('reopenreason'));
                        $('#deleteModal').modal('show');
                        id = $('#id_delete').val();
                    });
                    $('.modal-footer').on('click', '.delete', function() {
                        $.ajax({
                            type: 'DELETE',
                            url: 'incidence-status/' + id,
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'reopenreason': $('#reason').val(),
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

                <script>
                    $(document).ready(function() {
                        $('#postTable').DataTable({
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
        </div>
    </section>
@endsection