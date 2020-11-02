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
        @foreach ($stocks->chunk(4) as $items)
            <div class="row">
                @foreach ($items as $stock)
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <div class="caption text-center">
                                <a href="{{ url('shop/shop', [$stock->id]) }}"><img src="{{ asset('img/' . $stock->quantity) }}" alt="product" class="img-responsive"></a>
                                <a href="{{ url('shop/shop', [$stock->id]) }}"><h3>{{ $stock->product->name }}</h3>
                                     <p>&#x20A6 {{ $stock->unit_price }}</p>
                                </a>
                            </div> <!-- end caption -->
                        </div> <!-- end thumbnail -->
                    </div> <!-- end col-md-3 -->
                @endforeach
            </div> <!-- end row -->
        @endforeach
    </div> <!-- end container -->
@endsection