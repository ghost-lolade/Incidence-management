@extends('patients.base')

@section('action-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">View Patient Data</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                <tr role="row">


                                   <th width="20%" rowspan="1" colspan="1">Patient ID</th>
                                    <td>{{ $data->id }}</td>
                                </tr><tr>
                                   <th width="20%" rowspan="1" colspan="1">terminal ID</th>
                                    <td>{{ $data->terminal_id }} </td>
                                </tr><tr>    <th width="20%" rowspan="1" colspan="1">Sol ID</th>
                                    <td>{{ $data->sol_id }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">ATM Name</th>
                                    <td>{{ $data->atm_name }}</td>
                                </tr><tr> <th width="20%" rowspan="1" colspan="1">Vendor Name</th>
                                    <td>{{ $data->vendor_name }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">State</th>
                                    <td>{{$data->state}}</td>

                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">ATM brand</th>
                                    <td>{{ $data->brand }}</td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">ATM Model</th>
                                    <td>{{ $data->model }}</td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">Custodian Email</th>
                                    <td>{{ $data->custodian_email }}</td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">Custodian Phone</th>
                                    <td>{{ $data->custodian_phone }}</td>
                                </tr>

                                <tr>    <th width="20%" rowspan="1" colspan="1">ATM Serial No</th>
                                    <td>{{ $data->atm_serial_no }}</td>
                                </tr><tr>   <th width="20%" rowspan="1" colspan="1">Address</th>
                                    <td>{{ $data->address }}</td>
                                </tr>
                                <tr>
                                    <th rowspan="1" colspan="1">Action</th>
                                    <td>
                                        {{--<form class="row" method="POST" action="{{ route('patient-management.destroy', ['id' => $data->id]) }}" onsubmit = "return confirm('Are you sure?')">--}}
                                            {{--<input type="hidden" name="_method" value="DELETE">--}}
                                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                            <a href="{{ route('atmdata-management.edit', ['id' => $data->id]) }}" class="btn btn-warning col-sm-3 col-xs-4 btn-margin">
                                                Update
                                            </a>
                                        {{--</form>--}}

                                        <a href="{{url('atmdata-management')}}" class="btn btn-success col-sm-3 col-xs-4 btn-margin">Return</a>

                                    </td>

                                </tr>   </thead>
                                <tbody>
                                    <tr role="row" class="odd">

                                        {{--<td>{{$data->brand ? $data->brand->name : 'No Brand'}}</td>--}}
                                        {{--<td>{{$data->category ? $data->category->name : 'No Category'}}</td>--}}
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
