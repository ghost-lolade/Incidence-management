@extends('atmreport.base')
@section('action-content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new Customer Engineer</div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'POST', 'action'=> 'CustomerEngineerController@store','files'=>true]) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Full Name:') !!}
{{--                            {!! Form::text('name', null, ['class'=>'form-control'])!!}--}}
                            <input type="text" class="form-control" name="name"  placeholder="CE Full Name" required>
                        </div><div class="form-group">
                            {!! Form::label('mobile', 'Mobile No:') !!}
                            <input type="text" class="form-control" name="mobile"  placeholder="Eg: 0803" required>
                        </div>

                       <div class="form-group">
                            {!! Form::label('email_address', 'Email Address:') !!}
                           <input type="text" class="form-control" name="email_address"  placeholder="email@email.com" required>
                        </div>

                       <div class="form-group">
                            {!! Form::label('name', 'Level:') !!}
                           <select class="form-control" name="level" required>
                               <option value="">Select CE Level</option>
                               <option value="Level 1 (Intern)">Level 1 (Intern)</option>
                               <option value="Level 2 CE">Level 2 CE</option>
                               <option value="Level 3 CE">Level 3 CE</option>
                               <option value="Level 4 CE">Level 4 CE</option>
                               <option value="Level 5 CE (Senior Engineer)">Level 5 (Senior Engineer)</option>
                           </select>
                        </div>

                       <div class="form-group">
                            {!! Form::label('state', 'State:') !!}
                           <input type="text" class="form-control" name="state"  placeholder="Region Coverage" required>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Add CE', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
