@extends('products.base')
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
                    <div class="panel-heading">Add new Product</div>
                    @include('includes.form-error')
                    <div class="panel-body">


                        {!! Form::open(['method'=>'POST', 'action'=> 'ProductsController@store','files'=>true]) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Part Name:') !!}
                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('part_number', 'Part Number:') !!}
                            {!! Form::text('part_number', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('brand_id', 'Brand:') !!}
                            {!! Form::select('brand_id', [''=>'Choose Options'] + $brands, null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('category_id', 'Category:') !!}
                            {!! Form::select('category_id', [''=>'Choose Options'] + $categories, null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Add Part', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
