@extends('atmreport.base')
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
                        {!! Form::open(['method'=>'POST', 'action'=> 'CallLogController@viewReporter', 'target'=>'_blank','files'=>true]) !!}

                        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('patient-management.store') }}" enctype="multipart/form-data">--}}
                            {{ csrf_field() }}

                            <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label">Vendor Name:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <select class="form-control" name="vendor_id">
                                                <option value="">Select Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                @endforeach
                                            </select>       </div>
                                    </div>
 <br/><br/>
                                </div>
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">ATM State:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>

                                            <select class="form-control" name="state_id">
                                                <option value="">ATM State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{$state->name}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>  </div>
                                    </div>
                                                   </div>
                            </div>

                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="phoneNumber" class="col-sm-3 control-label">ATM Status:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-mobile"></i>
                                            </div>

                                            <select class="form-control" name="status">
                                                <option value="">All Call</option>
                                                <option value="open">Open Call</option>
                                                <option value="closed">Closed Call</option>
                                                <option value="suspended">Suspended Call</option>
                                                <option value="deleted">Deleted Call</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>  <br/>        </div>
                                <div class="form-group">

                                    <label for="phoneNumber2" class="col-sm-3 control-label">ATM Region: </label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <select class="form-control" name="region" >
                                                <option value="">All Region</option>
                                                <option value="1">Southern Region</option>
                                                <option value="2">Northern Region</option>
                                            </select>  </div>
                                    </div>
                                </div>


                            </div>

                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label"> From Date: *</label>
                                    <div class="col-sm-9">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="{{ old('date_hired') }}" name="from_date" class="form-control pull-right" id="hiredDate" placeholder="Select Date" required>
                                        </div>
                                    </div>

                                    <br/>  <br/>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="address" class="col-sm-3 control-label">Email Address:</label>--}}
                                    {{--<div class="col-sm-9">--}}
                                        {{--<div class="input-group date">--}}
                                            {{--<div class="input-group-addon">--}}
                                                {{--<i class="fa fa-at"></i>--}}
                                            {{--</div>--}}
                                            {{--<input type="text" class="form-control" id="email" name="email" placeholder="Email Address">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                            </div>

                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">To Date: *</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="{{ old('birthdate') }}" name="to_date" class="form-control pull-right" id="birthDate" placeholder="Select Date" required>
                                        </div> </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="due_date" class="col-sm-3 control-label">Patient type: *</label>--}}
                                    {{--<div class="col-sm-9">--}}
                                        {{--<div class="input-group date">--}}
                                            {{--<div class="input-group-addon">--}}
                                                {{--<i class="fa fa-bed"></i>--}}
                                            {{--</div>--}}
                                            {{--<select class="form-control" name="insurance_id" required>--}}
                                                {{--<option value="">Select Patient Type</option>--}}
                                                {{--@foreach ($insurances as $insurance)--}}
                                                    {{--<option value="{{$insurance->id}}">{{$insurance->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                <br/><br/>                         {{--</div>--}}

                            </div>

                                <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit & Check In
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
