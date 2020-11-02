@if(Session::has('deleted_brand'))

    <p class="bg-danger">{{session('deleted_brand')}}</p>

@endif

@if(Session::has('updated_brand'))

    <p class="bg-danger">{{session('updated_brand')}}</p>

@endif


@if(Session::has('deleted_category'))

    <p class="bg-danger">{{session('deleted_category')}}</p>

@endif

@if(Session::has('update_category'))

    <p class="bg-danger">{{session('update_category')}}</p>

@endif


@if(Session::has('deleted_product'))

    <p class="bg-danger">{{session('deleted_product')}}</p>

@endif


@if(Session::has('update_product'))

    <p class="bg-danger">{{session('update_product')}}</p>

@endif


@if(Session::has('deleted_stock'))

    <p class="bg-danger">{{session('deleted_stock')}}</p>

@endif


@if(Session::has('update_stock'))

    <p class="bg-danger">{{session('update_stock')}}</p>

@endif