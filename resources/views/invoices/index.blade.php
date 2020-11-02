{{--@extends('layouts.master')--}}
@extends('sales.base')
@section('action-content')

{{--@section('content')--}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix">
                <span class="panel-title">Invoices</span>
                <a href="{{route('invoices.create')}}" class="btn btn-success pull-right">Create</a>
            </div>
        </div>
        <div class="panel-body">
            @if($invoices->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Grand Total</th>
                        <th>Client</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>

                        <th >Created At</th>
                        <th>Invoice/WHT Payment Status</th>

                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->invoice_no}}</td>
                            <td> &#x20A6 {{number_format($invoice->grand_total, 2)}}</td>
                            <td>{{$invoice->client}}</td>
                            <td>{{$invoice->invoice_date}}</td>
                            <td>{{$invoice->due_date}}</td>
                            <td>{{$invoice->created_at->diffForHumans()}}</td>
                            <td>{{$invoice->status}} '--' {{$invoice->wht}}</td>

                            <td><form class="form-inline" method="post"
                                      action="{{route('invoices.updateStatus', $invoice)}}"
                                      onsubmit="return confirm('Are you sure this invoice has been paid?')"
                                        >
                                    <input type="hidden" name="status" value="PAID">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" value="Invoice Paid" class="btn btn-primary btn-sm">
                                </form><form class="form-inline" method="post"
                                      action="{{route('invoices.updateWHT', $invoice)}}"
                                      onsubmit="return confirm('Are you sure this invoice WHT has been paid?')"
                                        >
                                    <input type="hidden" name="wht" value="WHT_Paid">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" value="WHT Paid" class="btn btn-default btn-sm">
                                </form>



                                {{--<a href="{{route('invoices.updateStatus', $invoice)}}" class="btn btn-primary btn-sm">PAID</a>--}}
                            </td>
                            <td class="text-right">
                                <a href="{{route('invoices.show', $invoice)}}" class="btn btn-default btn-sm">View</a>
                                <a href="{{route('invoices.edit', $invoice)}}" class="btn btn-primary btn-sm">Edit</a>
                                <form class="form-inline" method="post"
                                    action="{{route('invoices.destroy', $invoice)}}"
                                    onsubmit="return confirm('Are you sure?')"
                                >
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $invoices->render() !!}
            @else
                <div class="invoice-empty">
                    <p class="invoice-empty-title">
                        No Invoices were created.
                        <a href="{{route('invoices.create')}}">Create Now!</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection