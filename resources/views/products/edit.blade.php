@extends('products.base')

@section('action-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Product</div>
                    <div class="panel-body">

                        {!! Form::model($product, ['method'=>'PATCH', 'action'=> ['ProductsController@update', $product->id],'files'=>true]) !!}

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
                            {!! Form::select('brand_id', $brands, null, ['class'=>'form-control'])!!}

                        </div>

                        <div class="form-group">
                            {!! Form::label('category_id', 'Category:') !!}
                            {!! Form::select('category_id', $categories , null, ['class'=>'form-control'])!!}

                        </div>

                        <div class="form-group">
                            {!! Form::submit('Update User', ['class'=>'btn btn-primary col-sm-2']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
