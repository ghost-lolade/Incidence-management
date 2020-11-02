@extends('stocks.base')
@section('action-content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new Stock</div>
                    @include('includes.form-error')
                    <div class="panel-body">

                        {!! Form::open(['method'=>'POST', 'action'=> 'StocksController@store','files'=>true]) !!}
                        <div class="form-group">
                            {!! Form::label('supplier_id', 'Supplier/Vendor:') !!}
                            {!! Form::select('supplier_id', [''=>'Select Supplier'] + $suppliers, null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('product_id', 'Part Name:') !!}
                            {!! Form::select('product_id', [''=>'Select Part Name'] + $products, null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_id', 'Category:') !!}
                            {!! Form::select('category_id', [''=>'Choose Category'] + $categories, null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('brand_id', 'Brand:') !!}
                            {!! Form::select('brand_id', [''=>'Choose Options'] + $brands, null, ['class'=>'form-control'])!!}
                        </div>
                                               <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', null, ['class'=>'form-control'])!!}
                        </div>
                                               <div class="form-group">
                            {!! Form::label('purchased_date', 'Purchased Date:') !!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{{ old('birthdate') }}" name="purchased_date" class="form-control pull-right" id="birthDate" required>
                            </div>
                        </div> 
                        
                        
                        <div class="form-group">
                            {!! Form::label('unit_price', 'Unit Price (Naira):') !!}
                            {!! Form::text('unit_price', null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Add Stock', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
