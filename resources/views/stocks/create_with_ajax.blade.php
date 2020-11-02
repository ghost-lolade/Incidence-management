@extends('stocks.base')

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

        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">Available In Stock</h3>

                    </div>
                    <div class="col-sm-4">

                        <ul class="nav navbar-nav navbar-center">
                            {{--<li class="{{ set_active('wishlist') }}">--}}
                            {{--<a class="btn btn-primary"  href="{{ url('/wishlist') }}">Wishlist ({{ Cart::instance('wishlist')->count(false) }})</a></li>--}}
                            {{--<li class="{{ set_active('cart') }}">--}}
                            <a class="btn btn-primary"    href="{{ url('/sale-management/create') }}"> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box-header -->

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">UHL Inventory Store</div>
                    @include('includes.form-error')
                    {!! Form::open(['method'=>'POST', 'action'=> 'StocksController@addCart','files'=>true]) !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="title">Select Product:</label>
                            {{--{!! Form::select('stock', ['' => 'Select'] +$stock,'',array('class'=>'form-control','id'=>'country','style'=>'width:350px;'))!!}--}}
                            {{--{!! Form::select('product_id', [''=>'Select Supplier'] ,$products, null, ['class'=>'form-control'])!!}--}}
                            {{--{{!! Form::select('product_id', $product_array , null, ['class'=>'form-control'])!! }}--}}
                            {!! Form::select('product_id',$products,null, ['class'=>'form-control','placeholder'=>'Select Products', 'id'=>'product','style'=>'width:350px;'])!!}
                        </div>
                        <div class="form-group">
                            <label for="title">Select Brand:</label>
                            <select name="brand_id" id="brand" class="form-control" style="width:350px">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Select Supplier:</label>
                            <select name="supplier_id" id="supplier" class="form-control" style="width:350px">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Unit Price:</label>
                            {!! Form::text('unit_price', null, ['class'=>'form-control','style'=>'width:350px;' ])!!}
                        </div>
                        <div class="form-group">
                            <label for="title">Quantity:</label>
                            {!! Form::text('quantity', null, ['class'=>'form-control','style'=>'width:350px;' ])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('part_number', 'Part Number:') !!}
                            {!! Form::text('part_number', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Add Stock', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div> <!-- end container -->
    </div>

@endsection

