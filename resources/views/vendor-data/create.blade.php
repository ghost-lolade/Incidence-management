@extends('atmreport.base')
@section('action-content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Vendor Data</div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'POST', 'action'=> 'VendorDataController@store','files'=>true]) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Vendor Name:') !!}
                            <select class="form-control" name="vendor_id" required>
                                <option value="">Select Vendor</option>
                                @foreach ($cedata as $cedata)
                                    <option value="{{$cedata->id}}">{{$cedata->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Full Name:') !!}
{{--                            {!! Form::text('name', null, ['class'=>'form-control'])!!}--}}
                            <input type="text" class="form-control" name="name"  placeholder="Full Name" required>
                        </div><div class="form-group">
                            {!! Form::label('mobile', 'Mobile No:') !!}
                            <input type="text" class="form-control" name="phone"  placeholder="Eg: 0803" required>
                        </div>

                       <div class="form-group">
                            {!! Form::label('email', 'Email Address:') !!}
                           <input type="text" class="form-control" name="email"  placeholder="email@email.com" required>
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
                            {!! Form::submit('Add Record', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
