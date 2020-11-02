@extends('brands.base')
@section('action-content')
        <!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">List of Vendor</h3>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="{{route('vendor-management.create')}}">Add Vendor</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
{{--            <form method="POST" action="{{ route('brand-management.search') }}">--}}
{{--                {{ csrf_field() }}--}}
{{--                @component('layouts.search', ['title' => 'Search'])--}}
{{--                @component('layouts.two-cols-search-row', ['items' => [ 'Name'],--}}
{{--                'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '', isset($searchingVals) ? $searchingVals['name'] : '']])--}}
{{--                @endcomponent--}}
{{--                @endcomponent--}}
{{--            </form>--}}
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="brand: activate to sort column ascending">S/N</th>
                                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="brand: activate to sort column ascending">Vendor Name</th>
                                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $brand)
                                <tr role="row" class="odd">
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <form class="row" method="POST" action="{{ route('vendor-management.destroy', ['id' => $brand->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('vendor-management.edit', ['id' => $brand->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
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
                                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="brand: activate to sort column ascending">S No</th>
                                <th width="20%" rowspan="1" colspan="1">Vendor Name</th>
                                <th rowspan="1" colspan="2">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($brands)}} of {{count($brands)}} entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            {{ $brands->links() }}
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