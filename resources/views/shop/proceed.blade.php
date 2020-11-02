@extends('shop.base')
@section('action-content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div class="panel-heading">Customer Detail</div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="table-image"></th>
                                <th>Part Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Tax</th>
                                <th>Sub Total</th>
                                <th class="column-spacer"></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                        <div class="panel-body">
                            @if (sizeof(Cart::content()) > 0)
                                {!! Form::open(['method'=>'POST', 'action'=> 'SalesController@store','files'=>true]) !!}
                                {!! Form::hidden('counter', $counter=Cart::content()->groupBy('id')->count(),  ['class'=>'form-control'])!!}
                                <?php $idx = 0; ?>
                                @foreach (Cart::content() as $item)
                                    <tr>
                                        <td class="table-image"><a href="{{ url('shop/shop', [$item->model->id]) }}"> </a>
                                            {{--<img src="{{ asset('img/' . $item->model->image) }}" alt="product" class="img-responsive cart-image"></a></td>--}}
                                        <td>{{$item->name }}</td>
                                        <td>{{ $item->qty}}</td>
                                        <td>&#x20A6 {{ $item->price }}</td>
                                         <td>&#x20A6 {{ $tax_sum=$item->tax * $item->qty }}</td>
                                          <td>&#x20A6 {{ $item->subtotal }}</td>
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("stock_id[$idx]", 'StockID:') !!}--}}
                                        {!! Form::hidden("stock_id[$idx]", $item->id,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("product_name[$idx]", 'Product Name:') !!}--}}
                                        {!! Form::hidden("product_name[$idx]", $item->name,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("quantity[$idx]", 'Quantity:') !!}--}}
                                        {!! Form::hidden("quantity[$idx]", $item->qty,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("unit_price[$idx]", 'Unit Price:') !!}--}}
                                        {!! Form::hidden("unit_price[$idx]", $item->price,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("rowId[$idx]", 'Row ID:') !!}--}}
                                        {!! Form::hidden("rowId[$idx]", $item->rowId,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("tax[$idx]", 'Tax:') !!}--}}
                                        {!! Form::hidden("tax[$idx]", $tax_sum,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--{!! Form::label("total_price[$idx]", 'Sub Total:') !!}--}}
                                        {!! Form::hidden("total_price[$idx]", $item->subtotal,  ['class'=>'form-control'])!!}
                                    {{--</div>--}}
                                    <?php $idx++; ?>
                                @endforeach

                                {{--<tr>--}}
                                    {{--<td class="table-image"></td>--}}
                                    {{--<td></td>--}}
                                    {{--<td class="small-caps table-bg" style="text-align: right">Subtotal</td>--}}
                                    {{--<td>${{ $subtotal= Cart::instance('default')->subtotal() }}</td>--}}
                                    {{--<td></td>--}}
                                    {{--<td></td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td class="table-image"></td>
                                    <td></td>
                                    <td class="small-caps table-bg" style="text-align: right">Tax</td>
                                    <td>&#x20A6 {{ Cart::instance('default')->tax() }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="table-image"></td>
                                    <td></td>
                                    <td class="small-caps table-bg" style="text-align: right">Your Total</td>
                                    <td class="table-bg"><b>&#x20A6 {{ Cart::total() }}</b></td>
                                    <td class="column-spacer"></td>
                                    <td></td>
                                </tr>
                            </div>
                            </tbody>
                        </table>
                            @endif

                         <h2>Dynamic Tabs</h2>
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home">Not Billable</a></li>
                                <li><a href="#menu1">Billable/Sale to Customer</a></li>
                                <li><a href="#menu2">Stock 4 CE </a></li>

                            </ul>

                        <script type="text/javascript">
                            $(function() {
                                $('input[name="sale_date"]').daterangepicker({
                                            singleDatePicker: true,
                                            showDropdowns: true
                                        },
                                        function(start, end, label) {
                                            var years = moment().diff(start, 'years');
                                          //  alert("You are " + years + " years old.");
                                        });
                            });
                        </script>


                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <h4>Not Billable: This part is use for the Bank at UHL expense</h4>
                                    <div class="form-group">
                                        {!! Form::label('terminal', 'Terminal ID:') !!}
                                        {!! Form::text('terminal', null, ['class'=>'form-control'])!!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('note', 'Short Note/Reason :') !!}
                                        {!! Form::text('note', null,  ['class'=>'form-control'])!!}
                                    </div>

                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <h4>Billable/Sale Part: This part is sold for client/Bank</h4>
                                    <div class="form-group">
                                        {!! Form::label('customer_name', 'Customer/Company Name:') !!}
                                        {!! Form::text('customer_name', null,  ['class'=>'form-control'])!!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('terminal_id', 'Terminal ID:') !!}
                                        {!! Form::text('terminal_id', null, ['class'=>'form-control'])!!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('customer_address', 'Customer/Company Address:') !!}
                                        {!! Form::text('customer_address', null, ['class'=>'form-control'])!!}
                                    </div>

                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <h4>Stock 4 CE : Part given to the CE for Keep</h4>
                                    <div class="form-group">
                                        {!! Form::label('ce_name', 'C E Name:') !!}
                                        {!! Form::text('ce_name', null, ['class'=>'form-control'])!!}
                                    </div>
                                    {{--<div class="form-group">--}}
                                    {{--{!! Form::label('customer_name', 'Customer Name:') !!}--}}
                                    {{--{!! Form::text('customer_name', null,  ['class'=>'form-control'])!!}--}}
                                    {{--</div>--}}


                                </div>
                            </div>
                        <script>
                            $(document).ready(function(){
                                $(".nav-tabs a").click(function(){
                                    $(this).tab('show');
                                });
                            });
                        </script>
                        <div class="form-group">
                            {!! Form::label('sale_date', 'Sale Date:') !!}
                            {!! Form::text('sale_date', null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Check Out', ['class'=>'btn btn-primary']) !!}
                        </div>
                            {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
