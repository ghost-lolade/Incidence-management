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
                        <h4>  {{ $stock->product->name }}</h4>

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

            <div class="col-md-8">

                <h3>  {{ $stock->product->name }}</h3> <h3>&#x20A6 {{ $stock->unit_price }}</h3>
                <form action="{{ url('/cart') }}" method="POST" class="side-by-side">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $stock->id }}">
                    <input type="hidden" name="name" value="{{ $stock->product->name }}">
                    <input type="hidden" name="unit_price" value="{{ $stock->unit_price }}">
                    <input type="submit" class="btn btn-success btn-lg" value="Add to Cart">
                </form>

                <form action="{{ url('/wishlist') }}" method="POST" class="side-by-side">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $stock->id }}">
                    <input type="hidden" name="name" value="{{ $stock->product->name }}">
                    <input type="hidden" name="unit_price" value="{{ $stock->unit_price }}">
                    <input type="submit" class="btn btn-primary btn-lg" value="Add to Wishlist">
                </form>


                <br><br>

                Product Category:<b>  {{ $stock->category->name }}</b><br>
                  Stock Supplier: <b>  {{ $stock->supplier->name }}</b><br>
                Product Brand:<b>  {{ $stock->brand->name }}</b>

            </div> <!-- end col-md-8 -->
        </div> <!-- end row -->

        <div class="spacer"></div>

        <div class="col-md-12">
            <h4>You may also add...</h4>

            @foreach ($interested as $stocks)
                <div class="col-md-2">
                    <div class="thumbnail">
                        <div class="caption text-center">
                            <a href="{{ url('shop/shop', [$stocks->id]) }}"></a>
                            <a href="{{ url('shop/shop', [$stocks->id]) }}"><h3>{{ $stocks->product->name }}</h3>
                            <p> &#x20A6 {{ $stocks->unit_price }}</p>
                            </a>
                        </div> <!-- end caption -->

                    </div> <!-- end thumbnail -->
                </div> <!-- end col-md-3 -->
            @endforeach

        </div> <!-- end row -->

        <div class="spacer"></div>


    </div> <!-- end container -->

@endsection
