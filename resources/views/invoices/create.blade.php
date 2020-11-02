@extends('invoices.base')
@section('action-content')
    <div class="container">

        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Invoice</div>
                    @include('includes.form-error')
                    <div class="panel-body">

                        {!! Form::open(['method'=>'POST', 'action'=> 'InvoiceController@store','files'=>true]) !!}
                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                            <div class="form-group">
                                <label for="clientName" class="col-sm-4 control-label">Client Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Client Name">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="clientAddress" class="col-sm-4 control-label">Client Address:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client_address" name="client_address" placeholder="Client Address">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                            <div class="form-group">
                                <label for="invoice_date" class="col-sm-4 control-label">Invoice Date:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="invoice_date" id="invoice_date" placeholder="Invoice Date">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="due_date" class="col-sm-4 control-label">Due Date:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="due_date" name="due_date" placeholder="Due Date">
                                </div>
                            </div>
                            <br><br>
                        </div>
                        <div class="col-sm-6"> <!-- FIRST COLUMN -->
                            <div class="form-group">
                                <label for="title" class="col-sm-4 control-label">Invoice Title:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Invoice Title">
                                </div>
                            </div>
                            <br>
                            <br>
                            <br><br>
                        </div>
                        <div class="col-sm-6"> <!-- THIRD COLUMN -->
                            <div class="form-group">
                                <label for="contact_person" class="col-sm-4 control-label">Contact Person:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Contact Person">
                                </div>


                            <br>
                            <br>
                            <br>
                            <br></div>
                        </div>

                        <div class="input_fields_wrap">
                            <button class="add_field_button">Add New Item</button>
                            <div><input type="hidden" name="mytext[]"></div>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
                        <br>
                        <div class="col-sm-6">
                        <div class="form-group">
                            {{--{!! Form::label('discount', 'Discount:') !!}--}}
                            {{--{!! Form::text('discount', null, ['class'=>'form-control'])!!}--}}
                        </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('banker', 'Banker Account:') !!}
                                <select name="banker" class="form-control" style="width:350px">
                                    <option value="">Select</option>
                                    <option value="United Bank for Africa,
                                    A/C NO: 101 675 6853
                                    Lekki Phase 1, Lagos">UBA Bank</option>
                                    <option value="NO Bank Account ">Access Bank</option>
                                    <option value="NO Bank Account">Stanbic IBTC</option>
                                    <option value="NO Bank Account">Stanbic IBTC</option>
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('discount', 'Discount:') !!}
                                {!! Form::text('discount', null, ['class'=>'form-control'])!!}
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                {{--{!! Form::label('discount', 'Discount:') !!}--}}
                                {{--{!! Form::text('discount', null, ['class'=>'form-control'])!!}--}}
                            </div>
                        </div>
                        <br><br>
                        <br><br>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::submit('Submit Invoice', ['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>


                        <div class="col-sm-8">
                        <div class="form-group">
                        </div>
                        </div>
                    {{--<div class="col-md-8 col-md-offset-2">--}}
                        {{--<div class="form-group">--}}
                            {{--{!! Form::submit('Submit Invoice', ['class'=>'btn btn-primary']) !!}--}}
                        {{--</div>--}}
{{--</div>--}}
                        {!! Form::close() !!}



                </div>
            </div>
        </div>
    </div>
    </div>




    <script>
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $("#rm").remove();

                    $(wrapper).append('<div id="divs" class="form-group"><label class="col-sm-2 control-label"> Item Name:</label><div class="col-sm-8"><input type="text" name="part_name[]" class="form-control" id="part_name[]" placeholder="Part/Item Name"/>'); //add input box
                    $(wrapper).append('<br><div id="divs1" class="form-group"><label class="col-sm-2 control-label">Part Quantity:</label><div class="col-sm-8"><input type="text" name="quantity[]" class="form-control" id="quantity[]" placeholder="Quantity"/>'); //add input box
                    $(wrapper).append('<br><div id="divs2" class="form-group"><label class="col-sm-2 control-label">Unit Price:</label><div class="col-sm-8"><input type="text" name="unit_price[]" class="form-control" id="unit_price[]" placeholder="Unit Price"/><a href="#" id="rm" class="remove_field">Remove</a></div>'); //add input box
                    $(wrapper).append('<br>');
                    $(wrapper).append('<br>');

                }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault();
                $("#divs").remove(); x--;
                $("#divs1").remove(); x--;
                $("#divs2").remove(); x--;
//                $("#divs").remove(); x--;

            })
        });


    </script>




@endsection

















{{--@extends('layouts.master')--}}

{{--@section('content')--}}
    {{--<div id="invoice">--}}
        {{--<div class="panel panel-default" v-cloak>--}}
            {{--<div class="panel-heading">--}}
                {{--<div class="clearfix">--}}
                    {{--<span class="panel-title">Create Invoice</span>--}}
                    {{--<a href="{{route('invoices.index')}}" class="btn btn-default pull-right">Back</a>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
                {{--@include('invoices.form')--}}
            {{--</div>--}}
            {{--<div class="panel-footer">--}}
                {{--<a href="{{route('invoices.index')}}" class="btn btn-default">CANCEL</a>--}}
                {{--<button class="btn btn-success" @click="create" :disabled="isProcessing">CREATE</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}

{{--@push('scripts')--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script>--}}
    {{--<script type="text/javascript">--}}
        {{--Vue.http.headers.common['X-CSRF-TOKEN'] = '{{csrf_token()}}';--}}

        {{--window._form = {--}}
            {{--invoice_no: '',--}}
            {{--client: '',--}}
            {{--client_address: '',--}}
            {{--title: '',--}}
            {{--invoice_date: '',--}}
            {{--due_date: '',--}}
            {{--discount: 0,--}}
            {{--products: [{--}}
                {{--name: '',--}}
                {{--price: 0,--}}
                {{--qty: 1--}}
            {{--}]--}}
        {{--};--}}
    {{--</script>--}}
    {{--<script src="/js/app.js"></script>--}}
{{--@endpush--}}