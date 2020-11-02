@extends('shop.base')

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
                            <a class="btn btn-primary"  href="{{ url('/wishlist') }}">Wishlist ({{ Cart::instance('wishlist')->count(false) }})</a></li>
                            {{--<li class="{{ set_active('cart') }}">--}}
                            <a class="btn btn-primary"    href="{{ url('/cart') }}">Cart ({{ Cart::instance('default')->count(false) }})</a></li>
                        </ul>
                    </div>
                </div>



            </div>

            <!-- /.box-header -->

            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
        </div>
        {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/cart') }}">--}}
        {{--<form action="{{ url('/cart') }}" method="POST" class="side-by-side">--}}
        {{--{!! csrf_field() !!}--}}
        {{--<input type="text" name="id" value="">--}}
        {{--<input type="text" name="name" value="">--}}
        {{--<input type="text" name="unit_price" value="">--}}
        {{--<input type="submit" class="btn btn-success btn-lg" value="Add to Cart">--}}
        {{--</form>--}}

        {{--{!! Form::open(['method'=>'POST', 'action'=> 'StocksController@store','files'=>true]) !!}--}}
        {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('city.store') }}">--}}


        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Dependent country state city dropdown using ajax in PHP Laravel Framework</div>
                {!! Form::open(['method'=>'POST', 'action'=> 'CartController@store','files'=>true]) !!}
                <div class="panel-body">
                    <div class="form-group">
                        <label for="title">Select Product:</label>
                        {{--{!! Form::select('stock', ['' => 'Select'] +$stock,'',array('class'=>'form-control','id'=>'country','style'=>'width:350px;'))!!}--}}
                        {{--{!! Form::select('product_id', [''=>'Select Supplier'] ,$products, null, ['class'=>'form-control'])!!}--}}
                        {{--{{!! Form::select('product_id', $product_array , null, ['class'=>'form-control'])!! }}--}}
                        {!! Form::select('stock',$products,null, ['class'=>'form-control','placeholder'=>'Select Products', 'id'=>'products','style'=>'width:350px;'])!!}
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label for="title">Select Brand:</label>--}}
                    {{--<select name="brand" id="brand" class="form-control" style="width:350px">--}}
                    {{--</select>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <label for="title">Select Supplier:</label>
                        <select name="supplier" id="supplier1" class="form-control" style="width:350px">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Select Price:</label>
                        {!! Form::text('unit_price', null, ['class'=>'form-control','style'=>'width:350px;' ])!!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::submit('Add Cart', ['class'=>'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}


        </div>

@endsection

