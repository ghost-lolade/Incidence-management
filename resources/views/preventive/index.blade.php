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
                        <h3 class="box-title">Preventive Maintenance   :: {{$date = date('Y-m-d H:i:s')}}</h3>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="{{ route('pm-management.create') }}">Add PM Time</a>
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
                    <th>Vendor</th>
                    <th>Status</th>
                    <th>Date</th>
                    {{--<th>Action</th>--}}

                </tr>
                {{ csrf_field() }}
                </thead>
                <tbody>
                @foreach($posts as $indexKey => $post)
                    <tr class="item{{$post->id}}">
                        <td class="col1">{{ $indexKey+1 }}</td>
                        <td>{{$post->terminal_id}}</td>
                        <td>
                            {{$post->atm_name}}
                        </td>
                        <td>
                            {{$post->vendor_name}}
                        </td>
                        <td>
                            {{$post->quarter_first}}
                        </td>

                        <td>
                            {{$post->quarter_first_date}}
                        </td>
                        {{--<td>--}}
                            {{--<button class="show-modal btn btn-success" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content="{{$post->address}} -- {{$post->custodian_phone}}-- {{$post->decline_reason}}"--}}
                                    {{--data-assign="{{$post->ce_name}}" data-status="{{$post->ce_status}}" data-timer="{{$post->ce_arrival_time}}">--}}
                                {{--<span class="glyphicon glyphicon-eye-open"></span> Show</button>--}}
                            {{--<button class="edit-modal btn btn-warning" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content="{{$post->vendor_request_status}}">--}}
                                {{--<span class="glyphicon glyphicon-trash"></span> Decline</button>--}}
                            {{--<button class="delete-modal btn btn-primary" data-id="{{$post->id}}" data-title="{{$post->terminal_id}}" data-content="{{$post->content}}">--}}
                                {{--<span class="glyphicon glyphicon-edit"></span> Accept</button>--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.panel-body -->
    </div><!-- /.panel panel-default -->
</div><!-- /.col-md-8 -->


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