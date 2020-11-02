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

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Data</div>
                    <div class="panel-body">
                        {!! Form::model($cedata, ['method'=>'PATCH', 'action'=> ['RequesterController@update', $cedata->id],'files'=>true]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Full Name:') !!}
                            <input type="text" class="form-control" id="name" name="name" placeholder="Surname" value="{{ $cedata->name }}" required>
                        </div><div class="form-group">
                            {!! Form::label('mobile', 'Mobile No:') !!}
                            <input type="text" class="form-control" name="mobile"  placeholder="Eg: 0803" value="{{ $cedata->requester_phone }}" required>
                        </div>

                        <div class="form-group">
                            {!! Form::label('email_address', 'Email Address:') !!}
                            <input type="text" class="form-control" name="email"  placeholder="email@email.com" value="{{ $cedata->email }}" required>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--{!! Form::label('name', 'Level:') !!}--}}
                            {{--<select class="form-control" name="level"  required>--}}
                                {{--<option value="{{ $cedata->level }}">{{ $cedata->level }}</option>--}}
                                {{--<option value="">Select CE Level</option>--}}
                                {{--<option value="Level 1 (Intern)">Level 1 (Intern)</option>--}}
                                {{--<option value="Level 2 CE">Level 2 CE</option>--}}
                                {{--<option value="Level 3 CE">Level 3 CE</option>--}}
                                {{--<option value="Level 4 CE">Level 4 CE</option>--}}
                                {{--<option value="Level 5 CE (Senior Engineer)">Level 5 (Senior Engineer)</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            {!! Form::label('state', 'State:') !!}
                            <input type="text" class="form-control" name="requester_dept"  placeholder="Department" value="{{ $cedata->requester_dept }}" required>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Update Record', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
