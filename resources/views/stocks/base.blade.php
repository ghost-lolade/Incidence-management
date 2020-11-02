@extends('layouts.app-template')

@section('content')




  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Stock System
      </h1>
      <ol class="breadcrumb">
        <!-- li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li-->
        <li class="active">Inventory System</li>
      </ol>

    </section>




    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    @yield('extra-css')

            <!-- Favicon and Apple Icons -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <style>

      .spacer {
        margin-bottom: 100px;
      }

      .cart-image {
        width: 100px;
      }

      footer {
        background-color: #f5f5f5;
        padding: 20px 0;
      }

      .table>tbody>tr>td {
        vertical-align: middle;
      }

      .side-by-side {
        display: inline-block;
      }
    </style>


    @yield('action-content')
            <!-- JavaScript -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript">



      $('#product').change(function(){
        var countryID = $(this).val();
        if(countryID){
          $.ajax({
            type:"GET",
            url:"{{url('api/get-brand-list')}}?product_id="+countryID,
            success:function(res){
              if(res){
                $("#brand").empty();
                $("#brand").append('<option>Select</option>');
                $.each(res,function(key,value){
                  $("#brand").append('<option value="'+key+'">'+value+'</option>');
                });

              }else{
                $("#brand").empty();
              }
            }
          });
        }else{
          $("#brand").empty();
          $("#supplier").empty();
        }
      });
      $('#brand').on('change',function(){
        var countryID = $("#product").val();
        var stateID = $(this).val();
        if(stateID){
          $.ajax({
            type:"GET",
            {{--url:"{{url('api/get-city-list')}}?brand_id="+stateID,--}}
            url:"{{url('api/get-category-list')}}?brand_id="+stateID+"&product_id="+countryID,
            success:function(res){
              if(res){
                $("#supplier").empty();
                $.each(res,function(key,value){
                  $("#supplier").append('<option value="'+key+'">'+value+'</option>');
                });
//                            console.log(supplier),
              }else{
                $("#supplier").empty();
              }
            }
          });
        }else{
          $("#supplier").empty();
        }

      });

      {{--$('#supplier').on('change',function(){--}}
      {{--var supplierID = $(this).val();--}}
      {{--var countryID = $(this).val();--}}
      {{--if(supplierID){--}}
      {{--$.ajax({--}}
      {{--type:"GET",--}}
      {{--                    url:"{{url('api/get-price-list')}}?brand_id="+supplierID,--}}
      {{--url:'{!! URL::to('api/get-price-list') !!}}',--}}
      {{--data:{'brand_id':supplierID &'product_id':countryID},--}}
      {{--url:"{{url('api/get-price-list')}}?brand_id="+supplierID"&product_id="+countryID,--}}
      {{--//                    url: 'daterangedetails.php?pt=7&rngstrt=' + range1 + '&rngfin=' + range2,--}}
      {{--url:"{!! URL::to('api/get-price-list') !!}}",--}}
      {{--data:{'brand_id':supplierID, 'product_id':countryID},--}}
      {{----}}
      {{--success:function(res){--}}
      //                        console.log(supplier)
      {{--if(res){--}}
      {{--$("#price").empty();--}}
      {{--$.each(res,function(key,value){--}}
      {{--$("#price").append('<option value="'+key+'">'+value+'</option>');--}}
      {{--});--}}

      {{--}else{--}}
      {{--$("#price").empty();--}}
      {{--}--}}
      {{--}--}}
      {{--});--}}
      {{--}else{--}}
      {{--$("#price").empty();--}}
      {{--}--}}

      {{--});--}}

    </script>
    @yield('extra-js')

            <!-- /.content -->
  </div>
@endsection

