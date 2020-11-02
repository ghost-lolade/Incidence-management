@extends('products.base')
@section('action-content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       
        <!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">List of Product</h3>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="{{ route('product-management.create') }}">Add New Product</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
         
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                     <table id="example1" class="table table-bordered table-striped">   
 
                            <thead>
                            <tr role="row">
                                <th>Product Name</th>
                                <th>Part Number</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr role="row" class="odd">
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->part_number }}</td>
                                    <td>{{$product->brand ? $product->brand->name : 'No Brand'}}</td>
                                    <td>{{$product->category ? $product->category->name : 'No Category'}}</td>
                                    <td>
                                        <form class="row" method="POST" action="{{ route('product-management.destroy', ['id' => $product->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('product-management.edit', ['id' => $product->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
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
                                <th>Product Name</th>
                                <th>Part Number</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->
 <script>
            $(function () {
                $('#example1').DataTable()
                $('#example2').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                })
            })
        </script>

    </section>

</div>
@endsection