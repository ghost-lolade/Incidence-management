<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Requests\EditProductRequest;
use App\Product;
//use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products= Product::paginate(5000);


        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function htmltopdfview(Request $request)
    {
        $products = Product::all();
        view()->share('products',$products);
        if($request->has('download')){
            $pdf = PDF::loadView('invoices.htmltopdfview');
            return $pdf->download('invoices.htmltopdfview');
        }
        return view('invoices.htmltopdfview');
    }



    public function create()
    {
        //
        $brands= Brand::pluck('name', 'id')->all();

        $categories= Category::pluck('name', 'id')->all();

        return view('products.create', compact('brands','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditProductRequest $request)
    {
        //

        Product::create($request->all());


        return redirect('/product-management');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $product=Product::findOrFail($id);

        $brands=Brand::pluck('name', 'id')->all();
        $categories=Category::pluck('name', 'id')->all();

        return view('products.edit', compact('product', 'brands','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        //
        $product= Product::findOrFail($id);

        $product->update($request->all());

        Session::flash('update_product','The Product has been Updated');

        return redirect('/product-management');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $products= Product::findOrFail($id);
        $products->delete();
        Session::flash('deleted_product','The Product has been deleted');

        return redirect('/product-management');
    }

    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']

        ];

        $products = $this->doSearchingQuery($constraints);
        return view('products/index', ['products' => $products, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Product::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
}
