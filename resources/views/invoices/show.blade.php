@extends('invoices.base')
@section('action-content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix">
                <span class="panel-title">Invoice</span>
                <div class="pull-right">
                    <a href="{{route('invoices.index')}}" class="btn btn-default">Back</a>
                    <a href="{{route('invoices.edit', $invoice)}}" class="btn btn-primary">Edit</a>
                    <form class="form-inline" method="post"
                        action="{{route('invoices.destroy', $invoice)}}"
                        onsubmit="return confirm('Are you sure?')"
                    >
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                    {{--<a href="{{ route('pdfview',['download'=>'pdf']) }}">Download PDF</a>--}}
                    <a href="{!! url('invoices/getPDF', $invoice->id) !!}" target="_blank" >Print</a>

                    {!! $invoice->property!!}

                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Invoice No.</label>
                        <p>{{$invoice->invoice_no}}</p>
                    </div>
                    <div class="form-group">
                        <label>Contact Person</label>
                        <p>{{$invoice->contact_person}}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Client</label>
                        <p>{{$invoice->client}}</p>
                    </div>
                    <div class="form-group">
                        <label>Client Address</label>
                        <pre class="pre">{{$invoice->client_address}}</pre>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Title</label>
                        <p>{{$invoice->title}}</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Invoice Date</label>
                            <p>{{$invoice->invoice_date}}</p>
                        </div>
                        <div class="col-sm-6">
                            <label>Due Date</label>
                            <p>{{$invoice->due_date}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->products as $product)
                        <tr>
                            <td class="table-qty">{{$product->qty}}</td>
                            <td class="table-name">{{$product->name}}</td>
                            <td class="table-price">&#x20A6 {{number_format($product->price, 2)}}</td>
                            <td class="table-total text-right">&#x20A6 {{number_format($product->qty * $product->price, 2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Sub Total</td>
                        <td class="table-amount">&#x20A6 {{number_format($invoice->sub_total, 2)}}</td>
                    </tr>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Discount</td>
                        <td class="table-amount">&#x20A6 {{number_format($invoice->discount, 2)}}</td>
                    </tr>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Grand Total</td>
                        <td class="table-amount">&#x20A6 {{number_format($invoice->grand_total, 2)}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection