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
                    <div class="panel-heading">Edit Data: Customer Engineer</div>
                    <div class="panel-body">
                        {!! Form::model($cedata, ['method'=>'PATCH', 'action'=> ['VendorDataController@update', $cedata->id],'files'=>true]) !!}
                        {{--{!! Form::open(['method'=>'POST', 'action'=> '@store','files'=>true]) !!}--}}

                        <div class="form-group">
                            {!! Form::label('name', 'Vendor Name:') !!}
                            <select class="form-control" name="vendor_id" required>
                                <option value="">{{$cedata->brand[0]->name}}</option>
                                <option value="">Select Vendor</option>
                                @foreach ($vendor as $vendor)
                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Full Name:') !!}
                            {{--                            {!! Form::text('name', null, ['class'=>'form-control'])!!}--}}
                            <input type="text" class="form-control" id="name" name="name" placeholder="Surname" value="{{ $cedata->name }}" required>
                        </div><div class="form-group">
                            {!! Form::label('mobile', 'Mobile No:') !!}
                            <input type="text" class="form-control" name="phone"  placeholder="Eg: 0803" value="{{ $cedata->phone }}" required>
                        </div>

                        <div class="form-group">
                            {!! Form::label('email_address', 'Email Address:') !!}
                            <input type="text" class="form-control" name="email"  placeholder="email@email.com" value="{{ $cedata->email }}" required>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Level:') !!}
                            <select class="form-control" name="level" required>

                                <option value="">Select Level</option>
                                <option value="1">Helpdesk Member </option>
                                <option value="2">Team Lead</option>
                                <option value="3">Management/CEO</option>
                            </select>
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
