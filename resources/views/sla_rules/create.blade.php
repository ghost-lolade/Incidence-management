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
                        {!! Form::open(['method'=>'POST', 'action'=> 'RulesController@store', 'files'=>true]) !!}

                        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('patient-management.store') }}" enctype="multipart/form-data">--}}
                        {{ csrf_field() }}

                        {{--<div class="col-sm-6"> <!-- FIRST COLUMN -->--}}
                        <div class="form-group">
                            <label for="surName" class="col-sm-2 control-label">Vendor Name:</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <select class="form-control" name="vendor_id" required>
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br/><br/>
                        </div>
                        <div class="form-group">
                            <label for="surName" class="col-sm-2 control-label">State/Location :</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <select class="form-control" name="state_id" required>
                                        <option value="">Select Location</option>
                                        @foreach ($states as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <br/><br/>
                        </div>
                        <div class="form-group">
                            <label for="otherName" class="col-sm-2 control-label">Response Time:</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time"></i>
                                    </div>
                                    <select class="form-control" name="response_time" required>
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
                                    </div>
                            </div>
                            <br/><br/>                            </div>

                        {{--<div class="col-sm-6"> <!-- FIRST COLUMN -->--}}
                        <div class="form-group">
                            <label for="surName" class="col-sm-2 control-label"> Repair Time: *</label>
                            <div class="col-sm-5">

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <select class="form-control" name="repair_time" required>
                                        <option value="">Select Repair Time</option>
                                        <option value="4">4 hour</option>
                                        <option value="5">5 hour</option>
                                        <option value="6">6 hour</option>
                                        <option value="7">7 hour</option>
                                        <option value="8">8 hour</option>
                                        <option value="9">9 hour</option>
                                        <option value="10">10 hour</option>
                                        <option value="11">11 hour</option>
                                        <option value="12">12 hour</option>
                                        <option value="13">13 hour</option>
                                        <option value="14">14 hour</option>
                                        <option value="15">15 hour</option>

                                    </select>        </div>
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
