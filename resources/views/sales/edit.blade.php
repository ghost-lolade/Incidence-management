@extends('sales.base')

@section('action-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Sales</div>
                    <div class="panel-body">

                        {!! Form::model($sale, ['method'=>'PATCH', 'action'=> ['SalesController@update', $sale->id],'files'=>true]) !!}

                        <div class="form-group">
                            {!! Form::label('terminal_id', 'Terminal ID:') !!}
                            {!! Form::text('terminal_id', null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('ce_name', 'CE Name:') !!}
                            {!! Form::text('ce_name', null, ['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('customer_name', 'Customer Name:') !!}
                            {!! Form::text('customer_name', null, ['class'=>'form-control'])!!}

                        </div> <div class="form-group">
                            {!! Form::label('customer_address', 'Customer Address:') !!}
                            {!! Form::text('customer_address', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('product_name', 'Product Name:') !!}
                            {!! Form::text('product_name', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('tax', 'Tax:') !!}
                            {!! Form::text('tax', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('quantity', 'Quantity:') !!}
                            {!! Form::text('quantity', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('sale_date', 'Sales Date:') !!}
                            {!! Form::text('sale_date', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('unit_price', 'Unit Price (Naira):') !!}
                            {!! Form::text('unit_price', null, ['class'=>'form-control'])!!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('note', 'Note:') !!}
                            {!! Form::text('note', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('total_price', 'Total Price (Naira):') !!}
                            {!! Form::text('total_price', null, ['class'=>'form-control'])!!}
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
