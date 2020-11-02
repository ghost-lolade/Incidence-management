@extends('atmreport.base')

@section('action-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">View Data</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                <tr role="row">
                                <tr>
                                   <th width="20%" rowspan="1" colspan="1">CE ID</th>
                                    <td>{{ $cedata->id }}</td>
                                </tr><tr>
                                   <th width="20%" rowspan="1" colspan="1">CE Name</th>
                                    <td>{{ $cedata->name }} {{ $cedata->firstname }}</td>
                                </tr><tr>    <th width="20%" rowspan="1" colspan="1">Email Address</th>
                                    <td>{{ $cedata->email }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">Mobile No</th>
                                    <td>{{ $cedata->phone }}</td>
                                </tr><tr> <th width="20%" rowspan="1" colspan="1">Level</th>
                                    <td>{{ $cedata->level }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">State</th>
                                    <td>{{$cedata->brand[0]->name}}</td>

                                </tr>
                                <tr>
                                    <th rowspan="1" colspan="1">Action</th>
                                    <td>
                                        {{--<form class="row" method="POST" action="{{ route('patient-management.destroy', ['id' => $cedata->id]) }}" onsubmit = "return confirm('Are you sure?')">--}}
                                            {{--<input type="hidden" name="_method" value="DELETE">--}}
                                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                        <a href="{{ route('vendordata-management.edit', ['id' => $cedata->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                            Update
                                        </a>
                                        {{--</form>--}}

                                        <a href="{{url('vendordata-management')}}" class="btn btn-success col-sm-3 col-xs-4 btn-margin">Return</a>

                                    </td>

                                </tr>   </thead>
                                <tbody>
                                    <tr role="row" class="odd">

                                        {{--<td>{{$cedata->brand ? $cedata->brand->name : 'No Brand'}}</td>--}}
                                        {{--<td>{{$cedata->category ? $cedata->category->name : 'No Category'}}</td>--}}
                                                                            </tr>
                                </tbody>



                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
