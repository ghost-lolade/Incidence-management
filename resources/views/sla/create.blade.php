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
                    <div class="panel-heading">Vendor Daily Report</div>
                    @include('includes.form-error')
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST', 'action'=> 'VendorReportController@viewReporter', 'target'=>'_blank','files'=>true]) !!}

                        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('patient-management.store') }}" enctype="multipart/form-data">--}}
                        {{ csrf_field() }}

                        <div class="col-sm-10"> <!-- FIRST COLUMN -->
                            <div class="form-group">
                                <label for="surName" class="col-sm-2 control-label">Vendor Name:</label>
                                <div class="col-sm-6">
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
                        </div>

                        {{--<div class="col-sm-6"> <!-- FIRST COLUMN -->--}}

                        {{--</div>--}}

                        <div class="col-sm-10"> <!-- Second COLUMN -->
                            <div class="form-group">
                                <label for="otherName" class="col-sm-2 control-label"> Date: *</label>
                                <div class="col-sm-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" value="{{ old('birthdate') }}" name="to_date" class="form-control pull-right" id="birthDate" placeholder="Select Date" required>
                                    </div> </div>
                            </div>
                            <br/><br/>                         {{--</div>--}}

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Generate Report
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
