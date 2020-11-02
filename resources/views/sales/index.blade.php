@extends('sales.base')
@section('action-content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">List of Sales</h3>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="{{ route('sale-management.create') }}">Add New Sales</a>
                    <div class="col-sm-4">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('reportSale.excel') }}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                            <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                            <button type="submit" class="btn btn-primary">
                                Export to Excel
                            </button>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('reportSale.pdf') }}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                            <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                            <button type="submit" class="btn btn-info">
                                Export to PDF
                            </button>
                        </form>
                 </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <form method="POST" action="{{ url('reportSale.search') }}">
                    {{ csrf_field() }}
                    @component('layouts.search', ['title' => 'Search'])
                        @component('layouts.two-cols-date-search-row', ['items' => ['From', 'To'],
                        'oldVals' => [isset($searchingVals) ? $searchingVals['from'] : '', isset($searchingVals) ? $searchingVals['to'] : '']])
                        @endcomponent
                    @endcomponent
                </form>
            </div>

         {{--<form method="POST" action="{{ route('sale-management.search') }}">--}}
                {{--{{ csrf_field() }}--}}
                {{--@component('layouts.search', ['title' => 'Search'])--}}
                {{--@component('layouts.two-cols-search-row', ['items' => ['Terminal ID', 'Part Name'],--}}
                {{--'oldVals' => [isset($searchingVals) ? $searchingVals['terminal_id'] : '', isset($searchingVals) ? $searchingVals['product_name'] : '']])--}}
                {{--@endcomponent--}}
                {{--<p></p>--}}
                {{--@component('layouts.two-cols-search-row', ['items' => ['CE Name', 'Customer Name'],--}}
                {{--'oldVals' => [isset($searchingVals) ? $searchingVals['ce_name'] : '', isset($searchingVals) ? $searchingVals['customer_name'] : '']])--}}
                {{--@endcomponent--}}
                {{--@endcomponent--}}
            {{--</form>--}}

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

                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">

                                <table id="example1" class="table table-bordered table-striped">
								<thead>
                                    <tr role="row">
									
                                        <th>Terminal ID</th>
                                        <th>Part Name</th>
                                        <th>Supplier Name</th>

                                        <th>Qty</th>
                                        {{--<th width="0%" class="sorting" tabindex="0">Unit Price</th>--}}
                                        <th>Total Price</th>

                                        <th>Sale Date</th>
                                        <th>Note</th>
                                        <th>Action</th>
										
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($notsales as $notsale)
                                        <tr role="row" class="odd">

                                            <td>{{$notsale->terminal_id}}</td>
                                           <td>{{$notsale->product->name}}</td>
{{--                                            <td>{{$sale->ce_name}}</td>--}}
                                            <td>{{$notsale->supplier ? $notsale->supplier->name : 'No Suppliers'}}</td>
{{--                                            <td>{{$sale->customer_name ? $sale->customer_name : 'No Customer'}}</td>--}}
{{--                                            <td>{{$sale->brand_name}}</td>--}}
                                            <td>{{$notsale->quantity}}</td>
                                            {{--<td>{{$sale->unit_price}}</td>--}}
                                            {{--{{number_format($invoice->grand_total, 2)}}--}}
{{--                                            <td>&#x20a6 {{number_format($notsale->unit_price, 2)}}</td>--}}
                                            <td> &#x20a6 {{number_format($notsale->total_price, 2)}}</td>

                                            <td> {{$notsale->sale_date}}</td>
                                            <td> {{$notsale->note}}</td>

                                            <td>
                                                <form class="row" method="POST" action="{{ route('sale-management.destroy', ['id' => $notsale->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <a href="{{ route('sale-management.edit', ['id' => $notsale->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                                        Update
                                                    </a>

                                                    <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Terminal ID</th>
                                        <th>Part Name</th>
                                        <th>Supplier Name</th>

                                        <th>Qty</th>
                                        {{--<th width="0%" class="sorting" tabindex="0">Unit Price</th>--}}
                                        <th>Total Price</th>

                                        <th>Sale Date</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                      
                    </div>
                </div>





                <div id="menu1" class="tab-pane fade">
                    <h4>Billable/Sale Part: This part is sold for client/Bank</h4>

                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">

                             
                             <table id="example2" class="table table-bordered table-striped">  
							 <thead>
                                    <tr role="row">
                                        <th>Terminal ID</th>
                                        <th>Product Name</th>
                                        <th>Supplier Name</th>
                                        <th>Customer Name</th>
                                        <th>Customer Address</th>
                                        {{--<th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="100" colspan="1">Customer Address</th>--}}
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Tax</th>
                                        <th>Sale Date</th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($forsales as $forsale)
                                        <tr role="row" class="odd">

                                            <td>{{$forsale->terminal_id}}</td>
                                            <td>{{$forsale->product->name}}</td>
{{--                                            <td>{{$forsale->ce_name}}</td>--}}
                                            <td>{{$forsale->supplier ? $forsale->supplier->name : 'No Suppliers'}}</td>
                                            <td>{{$forsale->customer_name ? $forsale->customer_name : 'No Customer'}}</td>
                                            <td>{{$forsale->customer_address}}</td>
                                            <td>{{$forsale->quantity}}</td>
                                            
                                            <td> &#x20a6 {{number_format($forsale->unit_price,2)}}</td>
                                            <td> &#x20a6 {{number_format($forsale->total_price,2)}}</td>
                                            <td> &#x20a6 {{number_format($forsale->tax,2)}}</td>
                                            <td>{{$forsale->created_at}}</td>

                                            <td>
                                                <form class="row" method="POST" action="{{ route('sale-management.destroy', ['id' => $forsale->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <a href="{{ route('sale-management.edit', ['id' => $forsale->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                                        Update
                                                    </a>

                                                    <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Terminal ID</th>
                                        <th>Part Name</th>
                                        <th>Customer Name</th>
                                        <th>Customer Address</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Tax</th>
                                        <th>Sale Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <div id="menu2" class="tab-pane fade">
                    <h4>Stock 4 CE : Part given to the CE for Keep</h4>

                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">

                              <table id="example3" class="table table-bordered table-striped"> 
                         <thead>
                                    <tr role="row">
                                        <th>Terminal ID</th>
                                        <th>Product Name</th>
                                        <th>CE Name</th>
                                        <th>Supplier Name</th>
                                        {{--<th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="100" colspan="1">Customer Address</th>--}}
                                        <th>Qty</th>
                                        {{--<th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Unit Price</th>--}}
                                        <th>Total Price</th>
                                        <th>Note</th>
                                        <th>Dispatch Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cestocks as $cestock)
                                        <tr role="row" class="odd">

                                            <td>{{$cestock->terminal_id}}</td>
                                            <td>{{$cestock->product->name}}</td>
                                            <td>{{$cestock->ce_name}}</td>
                                            <td>{{$cestock->supplier ? $cestock->supplier->name : 'No Suppliers'}}</td>
{{--                                            <td>{{$cestock->customer_name ? $sale->customer_name : 'No Customer'}}</td>--}}
                                            {{--<td>{{$sale->customer_address}}</td>--}}
                                            <td>{{$cestock->quantity}}</td>
                                            {{--<td>{{$sale->unit_price}}</td>--}}
                                            <td> &#x20a6 {{number_format($cestock->total_price, 2)}}</td>
{{--                                            <td> &#x20a6 {{number_format($cestock->tax, 2)}}</td>--}}
                                            <td>{{$cestock->note}}</td>
                                            <td>{{$cestock->created_at}}</td>

                                            <td>
                                                <form class="row" method="POST" action="{{ route('sale-management.destroy', ['id' => $cestock->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <a href="{{ route('sale-management.edit', ['id' => $cestock->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                                        Update
                                                    </a>

                                                    <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Terminal ID</th>
                                        <th>Part Name</th>
                                        <th>CE Name</th>
                                        <th>Supplier Name</th>
                                        <th>Customer Name</th>
                                        <th>Qty</th>
                                        <th>Total Price</th>
                                        <th>Note</th>
                                        <th>Used Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                       
                    </div>


                </div>
            </div>

			
 <script>
            $(function () {
                $('#example1').DataTable()
                $('#example2').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                })
                $('#example3 ').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                })
            })
        </script>
			
			
            <script>
                $(document).ready(function(){
                    $(".nav-tabs a").click(function(){
                        $(this).tab('show');
                    });
                });
            </script>


        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->
</div>
@endsection