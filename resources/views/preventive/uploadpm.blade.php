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




            <form action="{{ url('pmcert') }}" class="form-image-upload" method="POST" enctype="multipart/form-data">


                {!! csrf_field() !!}


                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                <div class="row">
                    <div class="col-md-5">
                        <strong>Title:</strong>
                        <input type="text" name="terminal_id" class="form-control" placeholder="Terminal ID">
                    </div>
                    <div class="col-md-5">
                        <strong>Image:</strong>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <br/>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>


            </form>
<br/>
<br/>
<br/>

            <div class="row">
                <div class='list-group gallery'>


                    @if($images->count())
                        @foreach($images as $image)
                            <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                <a class="thumbnail fancybox" rel="ligthbox" href="public/images/{{ $image->image }}">
                                    <img class="img-responsive" alt="" src="public/images/{{ $image->image }}" />
                                    <div class='text-center'>
                                        <small class='text-muted'>{{ $image->terminal_id }}</small>
                                    </div> <!-- text-center / end -->
                                </a>
                                <form action="{{ url('pmcert',$image->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="delete">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="close-icon btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                </form>
                            </div> <!-- col-6 / end -->
                        @endforeach
                    @endif


                </div> <!-- list-group / end -->
            </div> <!-- row / end -->




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