@extends('atmreport.base')
@section('action-content')

    <!-- Favicon -->
    {{--<link rel="shortcut icon" href="{{ asset('images/favicon.jpg') }}">--}}

    <!-- CSFR token for ajax call -->

    <!-- Bootstrap CSS -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet" href="{{ asset('icheck/square/yellow.css') }}">--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">SLA Rule :: {{$date = date('Y-m-d H:i:s')}}</h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-success" href="{{ route('sla-management.create') }}">Add New Rule</a>
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

                    <th>Vendor Name</th>
                    <th>State/Location</th>
                    <th>Response Time</th>
                    <th>Repair Time</th>

                    <th>Action</th>

                </tr>
                {{ csrf_field() }}
                </thead>
                <tbody>
                @foreach($rules as $indexKey => $rule)
                    <tr class="item{{$rule->id}}">
                        <td class="col1">{{ $indexKey+1 }}</td>
                        <td>{{$rule->vendor->name}}</td>
                        <td>
                            {{$rule->state->name}}
                        </td>
                        <td>
                            {{$rule->response_time}} hours
                        </td>
                        <td>
                            {{$rule->repair_time}} hours
                        </td>
                        <td>
                            {{--<button class="show-modal btn btn-success" data-id="{{$rule->id}}" data-title="{{$rule->terminal_id}}" data-content="{{$rule->address}} -- {{$rule->custodian_phone}}-- {{$rule->decline_reason}}"--}}
                                    {{--data-assign="{{$rule->ce_name}}" data-status="{{$rule->ce_status}}" data-timer="{{$rule->ce_arrival_time}}">--}}
                                {{--<span class="glyphicon glyphicon-eye-open"></span> Show</button>--}}
                            <button class="edit-modal btn btn-primary" data-id="{{$rule->id}}" data-title="{{$rule->state->name}}" data-content="{{$rule->vendor->name}}">
                                <span class="glyphicon glyphicon-edit"></span> Update</button>
                            <button class="delete-modal btn btn-danger" data-id="{{$rule->id}}" data-title="{{$rule->terminal_id}}" data-content="{{$rule->content}}">
                                <span class="glyphicon glyphicon-trash"></span> Delete</button>
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
                <div id="editModal" class="modal fade" role="dialog">
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
                                            <input type="text" class="form-control" id="id_edit" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Vendor Name:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="vendor_edit" required>
                                                <option value="">Select Vendor</option>
                                                @foreach ($vendor as $vendor)
                                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                @endforeach
                                            </select>
                                            {{--<input type="text" class="form-control" id="title_edit" disabled>--}}
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="content">Select Location:</label>
                                        <div class="col-sm-9">

                                            <select class="form-control" id="location_edit">
                                                <option value="">Select Location</option>
                                                @foreach ($states as $state)
                                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                            <p class="errorContent text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Response Time:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="response_edit" name="response_time" required>
                                                <option value="">Select Response Time</option>
                                                <option value="1">1 hour</option>
                                                <option value="2">2 hour</option>
                                                <option value="3">3 hour</option>
                                                <option value="4">4 hour</option>
                                                <option value="5">5 hour</option>
                                                <option value="6">6 hour</option>
                                                <option value="7">7 hour</option>
                                                <option value="8">8 hour</option>
                                                <option value="9">9 hour</option>
                                                <option value="10">10 hour</option>
                                                <option value="11">11 hour</option>
                                                <option value="12">12 hour</option>
                                            </select>
                                            {{--<input type="text" class="form-control" id="title_edit" disabled>--}}
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Repair Time:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="repair_edit" name="response_time" required>
                                                <option value="">Select Response Time</option>
                                                <option value="1">1 hour</option>
                                                <option value="2">2 hour</option>
                                                <option value="3">3 hour</option>
                                                <option value="4">4 hour</option>
                                                <option value="5">5 hour</option>
                                                <option value="6">6 hour</option>
                                                <option value="7">7 hour</option>
                                                <option value="8">8 hour</option>
                                                <option value="9">9 hour</option>
                                                <option value="10">10 hour</option>
                                                <option value="11">11 hour</option>
                                                <option value="12">12 hour</option>
                                            </select>
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
                <h3 class="text-center">Are you sure you want to accept call status?</h3>
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

    // Show a post
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


    // Edit a post
    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Edit');
        $('#id_edit').val($(this).data('id'));
        $('#vendor_edit').val($(this).data('vendor_id'));
        $('#location_edit').val($(this).data('state'));
        $('#response_edit').val($(this).data('response_time'));
        $('#repair_edit').val($(this).data('repair_time'));
        id = $('#id_edit').val();
        $('#editModal').modal('show');
    });
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'PUT',
            url: 'sla-management/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#id_edit").val(),
                'vendor': $('#vendor_edit').val(),
                'state': $('#location_edit').val(),
                'response_time': $('#response_edit').val(),
                'repair_time': $('#repair_edit').val(),
            },
            success: function(data) {
                $('.errorTitle').addClass('hidden');
                $('.errorContent').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
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
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td class='col1'>" + data.id + "</td><td>" + data.vendor_id + "</td><td>" + data.state_id + "</td><td>" + data.response_time + "</td><td>" + data.repair_time + "</td><td><button class='edit-modal btn btn-warning' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-edit'></span> Update</button> <button class='delete-modal btn btn-primary' data-id='" + data.id + "' data-title='" + data.title + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

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
        $('.modal-title').text('Delete');
        $('#id_delete').val($(this).data('id'));
        $('#title_delete').val($(this).data('title'));
        $('#deleteModal').modal('show');
        id = $('#id_delete').val();
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'DELETE',
            url: 'sla-management/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
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
@endsection