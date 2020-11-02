@extends('stocks.base')
@section('action-content')
        <!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">List of Product</h3>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="{{ route('stock-management.create') }}">Add New Stock</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <form method="POST" action="{{ route('stock-management.search') }}">
                {{ csrf_field() }}
                @component('layouts.search', ['title' => 'Search Part'])
                @component('layouts.two-cols-search-row', ['items' => ['Name'],
                'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '']])
                @endcomponent
                @endcomponent
            </form>
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">

                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="0" colspan="0">Product Name</th>
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="0" colspan="1">Supplier</th>
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="0" colspan="1">Brand</th>
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="100" colspan="1">Category</th>
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Quantity</th>
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Unit Price</th>
                                <th width="0%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Purchased Date</th>

                                <th tabindex="10" aria-controls="example2" rowspan="0" colspan="0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($stocks as $stock)
                                <tr role="row" class="odd">

                                    <td>{{$stock->product->name}}</td>
                                    <td>{{$stock->supplier ? $stock->supplier->name : 'No Suppliers'}}</td>
                                    <td>{{$stock->brand ? $stock->brand->name : 'No Brand'}}</td>
                                    <td>{{$stock->category ? $stock->category->name : 'No Category'}}</td>
                                    <td>{{$stock->quantity}}</td>
                                    <td>{{$stock->unit_price}}</td>
                                    <td>{{$stock->purchased_date}}</td>
                                    <td>
                                        <form class="row" method="POST" action="{{ route('stock-management.destroy', ['id' => $stock->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('stock-management.edit', ['id' => $stock->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
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
                                <th width="0%" rowspan="1" colspan="1">Product Name</th>
                                <th width="0%" class="sorting" tabindex="0">Supplier</th>
                                <th width="0%" class="sorting" tabindex="0">Brand</th>
                                <th width="0%" rowspan="1" colspan="1">Category</th>
                                <th width="0%" rowspan="1" colspan="1">Quantity</th>
                                <th width="0%" rowspan="1" colspan="1">Unit Price</th>
                                <th width="0%" rowspan="1" colspan="1">Purchased Date</th>
                                <th rowspan="0" colspan="0">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($stocks)}} of {{count($stocks)}} entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            {{ $stocks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->
</div>
@endsection