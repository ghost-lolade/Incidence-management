@extends('atmreport.basesearch')
@section('action-content')
    <div class="container">
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
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Search ATM Information</div>
                    @include('includes.form-error')
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST', 'action'=> 'CallLogController@viewTerminalReporter', 'target'=>'_blank','files'=>true]) !!}

                        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('patient-management.store') }}" enctype="multipart/form-data">--}}
                            {{ csrf_field() }}

                            {{--<div class="col-sm-6"> <!-- FIRST COLUMN -->--}}
                                <div class="form-group">
                                    <label for="surName" class="col-sm-2 control-label">Terminal ID:</label>
                                    <div class="col-sm-5">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="text" name="terminal_id" class="form-control pull-right"  placeholder="Terminal ID" required>
                                        </div>
                                    </div>
 <br/><br/>
                                </div>
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-2 control-label">Date From:</label>
                                    <div class="col-sm-5">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>

                                            <input type="text" value="{{ old('date_hired') }}" name="from_date" class="form-control pull-right" id="hiredDate" placeholder="Select Date" required>
                                        </div>
                                    </div>
                                    <br/><br/>                            </div>

                        {{--<div class="col-sm-6"> <!-- FIRST COLUMN -->--}}
                                <div class="form-group">
                                    <label for="surName" class="col-sm-2 control-label"> To Date: *</label>
                                    <div class="col-sm-5">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="{{ old('birthdate') }}" name="to_date" class="form-control pull-right" id="birthDate" placeholder="Select Date" required>
                                        </div>
                                    </div>
                                    <br/><br/>            </div>
                            {{--</div>--}}

                         {{--</div>--}}

                            {{--</div>--}}

                                <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
