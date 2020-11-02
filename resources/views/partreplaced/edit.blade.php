@extends('partreplaced.base')
@section('action-content')
    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if (session()->has('error_message'))
            <div class="alert alert-danger">
                {{ session()->get('error_message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Cash & Charge Record</div>
                    @include('includes.form-error')
                    <div class="panel-body">
                        {!! Form::model($atmpart, ['method'=>'PATCH', 'action'=> ['PartReplaceController@update', $atmpart->id],'files'=>true]) !!}

                        {{ csrf_field() }}

                        <table class="table" id="tableauto">
                            <tr>
                                <th>Terminal ID</th>
                                <th>ATM Name</th>
                            </tr>
                            <tr class="test">
                                <td> <input class="form-control autocomplete_txt" type='text' data-type="terminalid" value='{{ $atmpart->terminal_id }}' name='terminalid' placeholder="Terminal ID" required/></td>
                                <td> <input class="form-control autocomplete_txt" type='text' data-type="atmname" value='{{ $atmpart->atm_name }}' name='atmname' placeholder="ATM Name" required/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Part Name:</b> <input class="form-control" type='text' data-type="part_name" value='{{ $atmpart->part_name }}'  name='part_name' placeholder="Part Name" required/></td>
                                <td><b>Price:</b> <input class="form-control" type='text' data-type="price" value='{{ $atmpart->price }}' name='price' placeholder="1000"/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Invoice No:</b><input class="form-control" type='text' data-type="invoice_no" value='{{ $atmpart->invoice_no }}' name='invoice_no' placeholder="Invoice No" required/></td>
                                <td><b>Date: </b>
                                    {{--<input type="text" value="{{ old('date_hired') }}" name="from_date" class="form-control pull-right" id="hiredDate" placeholder="Select Date" required>--}}

                                    <input class="form-control" type='text' data-type="date" id='hiredDate' name='date' value='{{ $atmpart->date }}' placeholder="Select Date" required/> </td>
                            </tr>
                            <tr class="test">
                                <td><b>Supplier By:</b><input class="form-control" type='text' data-type="supplier_by" value='{{ $atmpart->supplier_by }}' name='supplier_by' placeholder="Supplier Name" required/></td>
                                <td><b>Approved By:</b><input class="form-control" type='text' data-type="approved_by" value='{{ $atmpart->approved_by }}' name='approved_by' placeholder="Approval By" required/> </td>
                            </tr>
                        </table>
<br/>

                        <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Record
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
