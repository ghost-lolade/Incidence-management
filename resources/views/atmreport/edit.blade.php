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
                    <div class="panel-heading">Update ATM Record</div>
                    @include('includes.form-error')
                    <div class="panel-body">
                        {!! Form::model($patient, ['method'=>'PATCH', 'action'=> ['PatientsController@update', $patient->id],'files'=>true]) !!}

                        {{ csrf_field() }}

                            <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label">Surname:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>

                                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" value="{{ $patient->surname }}" required>
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

                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Other Name" value="{{ $patient->firstname }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

<br/>
<br/>
                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="phoneNumber" class="col-sm-3 control-label">Mobile No:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-mobile"></i>
                                            </div>

                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Mobile Number" value="{{ $patient->phone }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="phoneNumber2" class="col-sm-3 control-label">Phone No:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>

                                            <input type="text" class="form-control" name="phone2" id="phone2" placeholder="Phone Number" value="{{ $patient->phone2 }}" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label">Patient Address:</label>
                                    <div class="col-sm-9">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-map"></i>
                                            </div>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Patient Address" value="{{ $patient->address }}" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Email Address:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i>
                                            </div>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ $patient->email }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">Birthday:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="{{ $patient->birthdate }}" name="birthdate" class="form-control pull-right" id="birthDate" placeholder="Date of Birth"  required>
                                        </div> </div>
                                </div>
                                <div class="form-group">
                                    <label for="due_date" class="col-sm-3 control-label">Patient type:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-bed"></i>
                                            </div>

                                            <select class="form-control" name="insurance_id">
                                                @foreach ($insurances as $insurance)
                                                    <option {{$insurance->insurance_id == $insurance->id ? 'selected' : ''}} value="{{$insurance->id}}">{{$insurance->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label">State:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-map-o"></i>
                                            </div>
                                            <select class="form-control" name="state_id">
                                                @foreach ($states as $state)
                                                    <option {{$state->insurance_id == $state->id ? 'selected' : ''}} value="{{$state->id}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>                                </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="clientAddress" class="col-sm-3 control-label">Country:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-map-o"></i>
                                            </div>
                                            <select class="form-control" name="country_id">
                                                @foreach ($countries as $country)
                                                    <option {{$country->insurance_id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
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
                            <div class="col-sm-6"> <!-- Second COLUMN -->
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">City:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-map-o"></i>
                                            </div>
                                            <select class="form-control" name="city_id">
                                                @foreach ($cities as $city)
                                                    <option {{$city->insurance_id == $city->id ? 'selected' : ''}} value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div> </div>
                                </div>
                                <div class="form-group">
                                    <label for="due_date" class="col-sm-3 control-label">Gender:</label>
                                    <div class="col-sm-9">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-map-o"></i>
                                            </div>
                                            <select class="form-control" name="gender">
                                                <option value="{{ $patient->gender }}">{{ $patient->gender }}</option
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div> </div>
                                </div>

                            </div>

                            <div class="col-sm-6"> <!-- FIRST COLUMN -->
                                <div class="form-group">
                                    <label for="surName" class="col-sm-3 control-label">Next of Kin:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <input type="text" class="form-control" id="nok" name="nok" placeholder="Next of kin Name" value="{{ $patient->nok }}" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="otherName" class="col-sm-3 control-label">NOK Mobile No:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" id="nokphone" name="nokphone" placeholder="Next of kin Phone Number" value="{{ $patient->nokphone }}" required>
                                        </div> </div>
                                </div>
                            </div>


                            <div class="form-group">

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
