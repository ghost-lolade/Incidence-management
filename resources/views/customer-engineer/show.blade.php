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

                                    <th width="20%" rowspan="1" colspan="1">Picture</th>
                                    <td><img src="../{{$cedata->picture }}" width="80px" height="80px"/></td>
                                </tr>
                                <tr>
                                   <th width="20%" rowspan="1" colspan="1">CE ID</th>
                                    <td>{{ $cedata->id }}</td>
                                </tr><tr>
                                   <th width="20%" rowspan="1" colspan="1">CE Name</th>
                                    <td>{{ $cedata->name }} {{ $cedata->firstname }}</td>
                                </tr><tr>    <th width="20%" rowspan="1" colspan="1">Email Address</th>
                                    <td>{{ $cedata->email_address }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">Mobile No</th>
                                    <td>{{ $cedata->mobile }}</td>
                                </tr><tr> <th width="20%" rowspan="1" colspan="1">Level</th>
                                    <td>{{ $cedata->level }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">State</th>
                                    <td>{{$cedata->state}}</td>

                                </tr>
                                {{--<tr>   <th width="20%" rowspan="1" colspan="1">Mobile No</th>--}}
                                    {{--<td>{{ $cedata->phone }};  {{ $cedata->phone2 }}</td>--}}
                                {{--</tr>--}}
                                {{--<tr>   <th width="20%" rowspan="1" colspan="1">City</th>--}}
                                    {{--<td>{{ $cedata->city->name }}</td>--}}
                                {{--</tr>--}}
                                {{--<tr>   <th width="20%" rowspan="1" colspan="1">State</th>--}}
                                    {{--<td>{{ $cedata->state->name }}</td>--}}
                                {{--</tr>--}}
                                {{--<tr>   <th width="20%" rowspan="1" colspan="1">Email Address</th>--}}
                                    {{--<td>{{ $cedata->email }}</td>--}}
                                {{--</tr>--}}

                                {{--<tr>    <th width="20%" rowspan="1" colspan="1">NOK</th>--}}
                                    {{--<td>{{ $cedata->nok }}</td>--}}
                                {{--</tr><tr>   <th width="20%" rowspan="1" colspan="1">NOK Mobile</th>--}}
                                    {{--<td>{{ $cedata->nokphone }}</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <th rowspan="1" colspan="1">Action</th>
                                    <td>
                                        {{--<form class="row" method="POST" action="{{ route('patient-management.destroy', ['id' => $cedata->id]) }}" onsubmit = "return confirm('Are you sure?')">--}}
                                            {{--<input type="hidden" name="_method" value="DELETE">--}}
                                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                        <a href="{{ route('engineer-management.edit', ['id' => $cedata->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                            Update
                                        </a>
                                        {{--</form>--}}

                                        <a href="{{url('engineer-management')}}" class="btn btn-success col-sm-3 col-xs-4 btn-margin">Return</a>

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
