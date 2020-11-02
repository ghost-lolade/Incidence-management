@extends('categories.base')

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
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new Category</div>
                    @include('includes.form-error')
                    <div class="panel-body">

                        {!! Form::open(['method'=>'POST', 'action'=> 'CategoriesController@store','files'=>true]) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}
                        </div>

                    {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
