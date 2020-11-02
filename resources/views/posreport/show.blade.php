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

                                    <th width="20%" rowspan="1" colspan="1">Picture</th>
                                    <td><img src="../{{$patient->picture }}" width="80px" height="80px"/></td>
                                </tr>
                                <tr>
                                   <th width="20%" rowspan="1" colspan="1">Patient ID</th>
                                    <td>{{ $patient->id }}</td>
                                </tr><tr>
                                   <th width="20%" rowspan="1" colspan="1">Patient Name</th>
                                    <td>{{ $patient->surname }} {{ $patient->firstname }}</td>
                                </tr><tr>    <th width="20%" rowspan="1" colspan="1">Address</th>
                                    <td>{{ $patient->address }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">Gender</th>
                                    <td>{{ $patient->gender }}</td>
                                </tr><tr> <th width="20%" rowspan="1" colspan="1">DOB</th>
                                    <td>{{ $patient->birthdate }}</td>
                                </tr><tr>  <th width="20%" rowspan="1" colspan="1">Patient Type</th>
                                    <td>{{$patient->insurance ? $patient->insurance->name : 'No Patient type'}}</td>

                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">Mobile No</th>
                                    <td>{{ $patient->phone }};  {{ $patient->phone2 }}</td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">City</th>
                                    <td>{{ $patient->city->name }}</td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">State</th>
                                    <td>{{ $patient->state->name }}</td>
                                </tr>
                                <tr>   <th width="20%" rowspan="1" colspan="1">Email Address</th>
                                    <td>{{ $patient->email }}</td>
                                </tr>

                                <tr>    <th width="20%" rowspan="1" colspan="1">NOK</th>
                                    <td>{{ $patient->nok }}</td>
                                </tr><tr>   <th width="20%" rowspan="1" colspan="1">NOK Mobile</th>
                                    <td>{{ $patient->nokphone }}</td>
                                </tr>
                                <tr>
                                    <th rowspan="1" colspan="1">Action</th>
                                    <td>
                                        {{--<form class="row" method="POST" action="{{ route('patient-management.destroy', ['id' => $patient->id]) }}" onsubmit = "return confirm('Are you sure?')">--}}
                                            {{--<input type="hidden" name="_method" value="DELETE">--}}
                                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                            <a href="{{ route('patient-management.edit', ['id' => $patient->id]) }}" class="btn btn-warning col-sm-3 col-xs-4 btn-margin">
                                                Update
                                            </a>
                                        {{--</form>--}}

                                        <a href="{{url('patient-management')}}" class="btn btn-success col-sm-3 col-xs-4 btn-margin">Return</a>

                                    </td>

                                </tr>   </thead>
                                <tbody>
                                    <tr role="row" class="odd">

                                        {{--<td>{{$patient->brand ? $patient->brand->name : 'No Brand'}}</td>--}}
                                        {{--<td>{{$patient->category ? $patient->category->name : 'No Category'}}</td>--}}
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
