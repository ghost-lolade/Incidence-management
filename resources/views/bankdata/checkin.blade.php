@extends('patients.base')
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
                    <div class="panel-heading">Update Patient Record</div>
                    @include('includes.form-error')
                    <div class="panel-body">
{{--                        {!! Form::model($patients, ['method'=>'PATCH', 'action'=> ['PatientsController@updateCheckIn', $patients->id],'files'=>true]) !!}--}}
                        {!! Form::open(['method'=>'POST', 'action'=> 'PatientsController@updateCheckIn','files'=>true]) !!}

                        {{ csrf_field() }}
                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                            <div class="form-group">
                                <label for="surName" class="col-sm-3 control-label">Surname:</label>
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <input type="text" class="form-control" id="surname"  readonly placeholder="Surname" value="{{ $patients->surname }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6"> <!-- FIRST COLUMN -->

                            <div class="form-group">
                                <label for="otherName" class="col-sm-3 control-label">Other Name:</label>
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <input type="text" class="form-control" readonly id="firstname" placeholder="Other Name" value="{{ $patients->firstname }}" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br/>
                        <br/>
                        <div class="col-sm-6"> <!-- Second COLUMN -->
                            <div class="form-group">
                                <label for="otherName" class="col-sm-3 control-label">Patient Type</label>
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="disable" value="{{ $patients->insurance->name }}" name="insurancename" readonly class="form-control pull-right" placeholder="insurance ID"  required>
                                        <input type="hidden" value="{{ $patients->insurance->id }}" name="insurance_id"  class="form-control pull-right" placeholder="insurance ID"  required>
                                        <input type="hidden" value="{{ $patients->id }}" name="patient_id" class="form-control pull-right" placeholder="patient ID"  required>
                                    </div> </div>
                            </div>
                            <div class="form-group">
                                <label for="otherName" class="col-sm-3 control-label">Consultancy Fee</label>
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="consultfee" name="consultfee" placeholder="Enter Consulting Fee" required >

                                        {{--<select class="form-control" name="consultfee" required>--}}
                                            {{--<option value="">Amount Paid</option>--}}
                                            {{--<option value="1500">NHIS</option>--}}
                                            {{--<option value="1000">HMO</option>--}}
                                            {{--<option value="500">&#x20A6 500</option>--}}
                                            {{--<option value="100">&#x20A6 1,000</option>--}}
                                            {{--<option value="1500">&#x20A6 1,500</option>--}}
                                        {{--</select>  --}}
                                    </div> </div>
                            </div>

                            <div class="form-group">
                                <label for="due_date" class="col-sm-3 control-label">Check-In:</label>
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-bed"></i>
                                        </div>

                                        <select class="form-control" name="department">
                                            @foreach ($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/>
                        <br/>
                        <br/>
                        <br/>

                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update Record
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
