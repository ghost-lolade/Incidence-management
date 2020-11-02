<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->name }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; }
    </style>
</head>
<body>
<div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:250pt;">
        <img class="img-rounded" height="90px" src="{{ asset("/bower_components/AdminLTE/dist/img/logo.png")  }}">
{{--        <img src="{{ asset("/bower_components/AdminLTE/dist/img/logo.jpg")  }}" >--}}
    </div>


    {{--<div style="position:absolute; left:0pt; width:250pt;">--}}
        {{--<img class="img-rounded" height="{{ $invoice->logo_height }}" src="{{ $invoice->logo }}">--}}
    {{--</div>--}}
    <div style="margin-left:300pt;">
{{--        <b>Date: </b> {{ $invoice->date->formatLocalized('%A %d %B %Y') }}<br />--}}
        <b>Date: </b> {{ $invoice->invoice_date }}<br />
        @if ($invoice->invoice_no)
            <b>Invoice #: </b> {{ $invoice->invoice_no }}
        @endif
        <br />
    </div>
</div>
<br />
<h3>  {{ $invoice->title }}   {{ $invoice->invoice_no ? '#' . $invoice->invoice_no : '' }}</h3>
<div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:250pt;">
        <h4>Customer Details:</h4>
        <div class="panel panel-default">
            <div class="panel-body">

                {{ $invoice->client }}<br />
                {{ $invoice->client_address }}<br />



                {{--{{ $invoice->business_details->get('location') }}<br />--}}
                {{--{{ $invoice->business_details->get('zip') }} {{ $invoice->business_details->get('city') }}--}}
                {{--{{ $invoice->business_details->get('country') }}<br />--}}

            </div>
        </div>
    </div>
    <div style="margin-left: 300pt;">
        <h4>Business Details:</h4>
        <div class="panel panel-default">
            <div class="panel-body">
               <b> UNIVERSAL HORIZON LTD</b> <br/>
                Block A4, Suite 18 <br/>
                Sura Shopping Complex,<br/>
                Simpson Street <br/>
                Lekki Phase 1<br/>
                Lagos
            </div>
        </div>
    </div>
</div>
<h4>Items:</h4>
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
            <td class="table-price"><span style="font-family: DejaVu Sans;">&#x20A6;</span> {{number_format($product->price, 2)}}</td>
            <td class="table-total text-right"><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{number_format($product->qty * $product->price)}}</td>
        </tr>
    @endforeach
    </tbody>

</table>


<div style="clear:both; position:relative;">
    <div style="position:absolute; left:0pt; width:250pt;">
        <h5>PAYMENT INSTRUCTION. Please Credit:</h5>
        <div class="panel panel-default">
            <div class="panel-body">
                UNIVERSAL HORIZON LTD <br/>
                {{$invoice->banker}}
            </div>
        </div>
    </div>
    <div style="margin-left: 300pt;">
        <h4>Total:</h4>
        <table class="table table-bordered">
            <tbody>

            <tr>

                <td class="table-label">Sub Total</td>
                <td class="table-amount"><span style="font-family: DejaVu Sans;">&#x20A6;</span>{{number_format($invoice->sub_total, 2)}}</td>
            </tr>
            <tr>
{{--@if {{$invoice->discount <=0}}   {--}}

                {{--} @else{--}}
                {{--<td class="table-label">Discount</td>--}}
                {{--<td class="table-amount"><span style="font-family: DejaVu Sans;">&#x20A6;</span> {{$invoice->discount}}</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--}--}}
{{--@endif--}}
                <td class="table-label">Tax</td>
                <td class="table-amount"><span style="font-family: DejaVu Sans;">&#x20A6;</span> {{number_format($invoice->tax, 2)}}</td>
            </tr>
            <tr>

                <td class="table-label">Grand Total</td>
                <td class="table-amount"><span style="font-family: DejaVu Sans;">&#x20A6;</span> {{number_format($invoice->grand_total +$invoice->tax, 2) }}</td>
            </tr>



            </tbody>
        </table>
    </div>
</div>
{{--@if ($invoice->footnote)--}}
    {{--<br /><br />--}}
    {{--<div class="well">--}}
        {{--{{ $invoice->footnote }}--}}
    {{--</div>--}}
{{--@endif--}}
</body>
</html>