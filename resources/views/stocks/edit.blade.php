@extends('stocks.base')

@section('action-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Stock</div>
                    <div class="panel-body">

                        {!! Form::model($stock, ['method'=>'PATCH', 'action'=> ['StocksController@update', $stock->id],'files'=>true]) !!}

                        <div class="form-group">
                            {!! Form::label('supplier_id', 'Supplier:') !!}
                            {!! Form::select('supplier_id', $supplier , null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('product_id', 'ATM Part:') !!}
                            {!! Form::select('product_id', $product, null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_id', 'Category:') !!}
                            {!! Form::select('category_id', $category, null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('brand_id', 'Brand:') !!}
                            {!! Form::select('brand_id', $brand, null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('purchased_date', 'Purchased Date:') !!}
                            {!! Form::text('purchased_date', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('unit_price', 'Unit Price (Naira):') !!}
                            {!! Form::text('unit_price', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Update Stock', ['class'=>'btn btn-primary col-sm-2']) !!}
                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
