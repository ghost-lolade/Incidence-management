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
                            {{--<a class="btn btn-primary"  href="{{ url('/wishlist') }}">Wishlist ({{ Cart::instance('wishlist')->count(false) }})</a></li>--}}
                            {{--<li class="{{ set_active('cart') }}">--}}
                            <a class="btn btn-primary"    href="{{ url('shop-management') }}">Back to Shop</a></li>
                        </ul>
                    </div>
                </div>
      </div>
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">

                        <table id="example2" class="table table-responsive" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th width="0%" rowspan="1" colspan="1">#</th>
                                <th width="0%" rowspan="1" colspan="1">Product Name</th>
                                <th width="0%" class="sorting" tabindex="0">Supplier</th>
                                <th width="0%" class="sorting" tabindex="0">Brand</th>
                                <th width="1%">Quantity</th>
                                <th width="0%" rowspan="1" colspan="1">Unit Price</th>
                                <th width="0%" rowspan="1" colspan="1">Tax</th>
                                <th width="0%" rowspan="1" colspan="1">Total Price</th>
                                {{--<th width="0%" rowspan="1" colspan="1">Purchased Date</th>--}}
                                <th tabindex="10" aria-controls="example2" rowspan="0" colspan="0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{$i=1}}
                            @foreach ($sales as $sale)
                                <tr role="row" class="odd">

                                    <td>{{$i++}}</td>
                                    <td>{{$sale->product? $sale->product->name : 'No Product'}}</td>
                                    <td>{{$sale->supplier ? $sale->supplier->name : 'No Suppliers'}}</td>
                                    <td>{{$sale->brand ? $sale->brand->name : 'No Brand'}}</td>
                                    {{--<td>{{$stock->category ? $stock->category->name : 'No Category'}}</td>--}}
                                    <td>{{$sale->quantity}}</td>
                                    <td>&#x20A6 {{$sale->unit_price}}</td>
                                    <td>&#x20A6 {{$sale->tax}}</td>
                                    <td>&#x20A6 {{$sale->total_price}}</td>
                                    <td>
                                        <form class="row" method="POST" action="{{ route('sale-management.destroy', ['id' => $sale->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            {{--<a href="{{ route('sale-management.edit', ['id' => $sale->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">--}}
                                                {{--Update--}}
                                            {{--</a>--}}
                                            <button type="submit" class="btn btn-danger col-sm-7 col-xs-5 btn-margin">
                                                Delete Cart
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
{{--                            {{ $sales->links() }}--}}
                        </div>
                    </div>
                </div>




            <!-- /.box-header -->
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2" >
                    <div class="panel panel-default">

                <div class="panel-heading"><strong>Payment Mode- Select your payment mode</strong></div>
                {{--<div class="title"><strong>Payment Mode- Select your payment mode</strong></div>--}}
                        @include('includes.form-error')
                        <div class="panel-body">
                <input type="radio" id="radio1" name="radios" value="radio1" checked>
                <label for="radio1">Not Billable</label>

                <input type="radio" id="radio2" name="radios" value="radio2">
                <label for="radio2">Billable/Sale Part</label>

                <input type="radio" id="radio3" name="radios"value="radio3">
                <label for="radio3">Stock 4 CE</label>


                {!! Form::open(['method'=>'POST', 'id'=>'notbillable', 'action'=> 'SalesController@storeNotBillable','files'=>true]) !!}

                <h5>Not Billable: This part is use for the Bank at UHL expense</h5>
                <div class="form-group">
                    {!! Form::label('terminal', 'Terminal ID:') !!}
                    {!! Form::text('terminal', null, ['class'=>'form-control','style'=>'width:350px;'])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('note', 'Short Note/Reason :') !!}
                    {!! Form::text('note', null,  ['class'=>'form-control','style'=>'width:350px;'])!!}
                </div>
                            <div class="form-group">
                                {!! Form::label('sale_date', 'Sale/Used Date:') !!}
                            </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                    <input type="text" value="{{ old('birthdate') }}" name="sale_date" class="form-control pull-right" id="birthDate" placeholder="Sale/Used Date" required>
{{--                    {!! Form::text('sale_date', null, ['class'=>'form-control','style'=>'width:350px;'])!!}--}}
                </div>
                    </div>
                </div>
                            <br/><br/>
                <div class="form-group">
                    {!! Form::label('serialno', 'List Serial No:') !!}
                    {!! Form::text('serialno', null, ['class'=>'form-control','style'=>'width:350px;', 'placeholder' => 'Serial No Separate with Comma'])!!}
                    {{--{!! Form::text('ce_name', null, ['class'=>'form-control','style'=>'width:350px;'])!!}--}}
                </div>
                <div class="form-group">
                    {!! Form::submit('Check Out', ['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}


                {{--<form method="post" id="billable">--}}

                    {!! Form::open(['method'=>'POST', 'id'=>'billable', 'action'=> 'SalesController@storeBillable','files'=>true]) !!}


                    <h5>Billable/Sale Part: This part is sold for client/Bank</h5>
                    <div class="form-group">
                        {!! Form::label('customer_name', 'Customer/Company Name:') !!}
                        {!! Form::text('customer_name', null,  ['class'=>'form-control','style'=>'width:350px;'])!!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('terminal_id', 'Terminal ID:') !!}
                        {!! Form::text('terminal_id', null, ['class'=>'form-control','style'=>'width:350px;'])!!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('customer_address', 'Customer Address:') !!}
                        {!! Form::text('customer_address', null, ['class'=>'form-control','style'=>'width:350px;'])!!}
                    </div>
                <div class="form-group">
                    {!! Form::label('serialno', 'List Serial No:') !!}
                    {!! Form::text('serialno', null, ['class'=>'form-control','style'=>'width:350px;', 'placeholder' => 'Serial No Separate with Comma'])!!}
                </div>
                    <div class="form-group">
                        {!! Form::submit('Check Out', ['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}


                    {!! Form::open(['method'=>'POST', 'id'=>'cestock', 'action'=> 'SalesController@storeStockCE','files'=>true]) !!}

                    <h5>Stock 4 CE : Part given to the CE for Keep</h5>
                    <div class="form-group">
                        {!! Form::label('ce_name', 'C E Name:') !!}
                        {!! Form::text('ce_name', null, ['class'=>'form-control','style'=>'width:350px;'])!!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('serialno', 'List Serial No:') !!}
                        {!! Form::text('serialno', null, ['class'=>'form-control','style'=>'width:350px;', 'placeholder' => 'Serial No Separate with Comma'])!!}
                    </div>
                <div class="form-group">
                    {!! Form::label('note', 'Short Note/Reason :') !!}
                    {!! Form::text('note', null,  ['class'=>'form-control','style'=>'width:350px;'])!!}
                </div>
                            <div class="form-group">
                                {!! Form::label('sale_date', 'Sale/Used Date:') !!}
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" value="{{ old('date_hired') }}" name="sale_date" class="form-control pull-right" id="hiredDate" placeholder="Sale/Used Date" required>
                                        {{--<input type="text" value="{{ old('hire_date') }}" name="sale_date" class="form-control pull-right" id="hireDate" placeholder="Sale/Used Date" required>--}}
                                        {{--                    {!! Form::text('sale_date', null, ['class'=>'form-control','style'=>'width:350px;'])!!}--}}
                                        {{--<input type="text" value="{{ old('date_hired') }}" name="date_hired" class="form-control pull-right" id="hiredDate" required>--}}
                                    </div>
                                </div>
                            </div>
                            <br/><br/>

                    <div class="form-group">
                        {!! Form::submit('Check Out', ['class'=>'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}

    </div>
            </div>
            </div>
            </div>

            </div>

        </div> <!-- end container -->
    </div>
    <script>
        var radios = document.getElementsByName("radios");
        var notbillable =  document.getElementById("notbillable");
        var billable =  document.getElementById("billable");
        var cestock =  document.getElementById("cestock");
        notbillable.style.display = 'block';   // show
        billable.style.display = 'none';   // hide
        cestock.style.display = 'none';// hide
        for(var i = 0; i < radios.length; i++) {
            radios[i].onclick = function() {
                var val = this.value;
                if(val == 'radio1'){
                    notbillable.style.display = 'block';
                    billable.style.display = 'none';
                    cestock.style.display = 'none';
                }
                else if(val == 'radio3'){
                    notbillable.style.display = 'none';
                    billable.style.display = 'none';
                    cestock.style.display = 'block';
                }
                else if(val == 'radio2'){
                    notbillable.style.display = 'none';
                    billable.style.display = 'block';
                    cestock.style.display = 'none';
                }

            }
        }


    </script>
@endsection

