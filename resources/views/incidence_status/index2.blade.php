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
                            <div class="col-lg-3 well">
                                <ul class="nav nav-stacked">
                                    <li></li>
                                    <li class="form-group"><label>Actions</label> <select name="action" id="action" class="form-control">
                                            <option selected>Select Action</option>
                                            <option value="#assign">Show Call</option>
                                            <option value="#closecall">Close Call</option>
                                            <option value="#suspendcall">Suspend Call</option>
                                            <option value="#deletecall">Delete Call</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>

                            <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
                                <thead>
                                <tr>
                                    <th valign="middle">#</th>
                                    <th>Terminal No</th>
                                    <th>Name</th>
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
                                        <td>{{$post->id}}</td>
                                        <td>
                                            {{$post->call_closer_username}}
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

                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffForHumans() }}</td>
                                        <td>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel panel-default -->
                </div><!-- /.col-md-8 -->


                <!-- Modal form to show a post -->
                <div id="assign" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="id">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="id_show" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="title">Terminal ID:</label>
                                        <div class="col-sm-10">
                                            <input type="name" class="form-control" id="title_show" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="content">Detail:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="content_show" cols="40" rows="5" disabled></input>
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
                <div id="suspendcall" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="id">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="id_edit" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="title">Terminal ID:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="title_edit" disabled>
                                            <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="content">Suspension Reason:</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="content_edit" cols="40" rows="5"></textarea>
                                            <p class="errorContent text-center alert alert-danger hidden"></p>
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
                <div id="closecall" class="modal fade" role="dialog">
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
                <div class="modal fade" id="deletecall" data-target="#deletecall">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header orange">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                                </button>
                                <h4 class="modal-title"><strong></strong>Delete Call</h4>
                                <p>Description Here: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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

                <!-- Delay table load until everything else is loaded -->
                <script>
                    $(window).load(function(){
                        $('#postTable').removeAttr('style');
                    })
                </script>

            <script>

                $("#action").change(function () {
                    if ($(this).val() == "#assign") {

                        $('#assign').modal('show');
                    }
                    if ($(this).val() == "#deletecall") {
                        $('#deletecall').modal('show');
                    }
                    if ($(this).val() == "#closecall") {
                        $('#closecall').modal('show');
                    }
                    if ($(this).val() == "#suspendcall") {
                        $('#suspendcall').modal('show');
                    }
                });

            </script>
            </section>
        </div>
    </section>
@endsection