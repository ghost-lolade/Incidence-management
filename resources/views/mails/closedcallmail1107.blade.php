
                          <table id="example1" class="table table-bordered table-striped">
			          <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Terminal ID</th>
                                    <th>ATM Name</th>
                                    <th>Error Code</th>
                                    {{--<th>Vendor</th>--}}
                                    <th>Status</th>
                                    <th>Closed Day</th>
                                    <th>Closed Time</th>
                                    {{--<th>Closure Remark</th>--}}
                                    <th>Closure Remark</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($atmreports as $atmreport)
                                    <tr role="row" class="odd">
{{--                                        <td><img src="../{{$atmreport->picture }}" width="50px" height="50px"/></td>--}}
                                        <td>{{ $atmreport->id }}</td>
                                        <td>{{ $atmreport->terminal_id }}</td>
                                        <td>{{ $atmreport->atm_name }}</td>
{{--                                        <td>{{ $atmreport->address }}</td>--}}
                                        <td>{{ $atmreport->error_code}}</td>
{{--                                        <td>{{ $atmreport->vendor_name }}</td>--}}
{{--                                        <td>{{$atmreport->insurance ? $atmreport->insurance->name : 'No atmreport type'}}</td>--}}
                                        <td>{{ $atmreport->request_status }}</td>
                                        <td>{{ $atmreport->close_day }}</td>
                                        <td>{{ $atmreport->close_time }}</td>
                                        {{--<td>{{ $atmreport->suspend_comment }}</td>--}}
                                        <td>{{ $atmreport->closure_comment }}</td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>



    </div>
