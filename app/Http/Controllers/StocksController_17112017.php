<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\CreateCartRequest;
use App\Http\Requests\CreateStockRequest;
use App\Stock;
use App\Sale;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Product;
use App\Category;
use App\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Query\Builder;


class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data2 = Product::select("name as name")->where("name","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data2);
    }


    public function index()
    {
        $stocks= Stock::paginate(50);
        return view('stocks.index', compact('stocks'));
    }


//    public function shop()
//    {
//       // $stocks = Stock::all();
//        $stocks = Stock::all()->Where('quantity', '>', '0' );
//        return view('shop.shop')->with('stocks', $stocks);
//    }

    public function show($id)
    {
        $stock = Stock::where('id', $id)->firstOrFail();
        $interested = Stock::where('id', '!=', $id)->get()->random(4);

        return view('shop/product')->with(['stock' => $stock, 'interested' => $interested]);

    }


    public function getStockList()
    {
        $count = DB::table("sales")->where("status", 0)->count();

        $stocks = Stock::all()->Where('quantity', '>', 'quantity_used');
       // $stock = DB::table("stocks")->pluck("product_id");
        $stock = DB::table("stocks")->pluck("product_id", "product_id")->all();
        $products = DB::table("products")->whereIn('id', $stock)->pluck("name","id");

        return view('shop.shop')->with([
            'stocks'   => $stocks,
            'stock'    => $stock,
            'products' => $products,
            'count' => $count
        ]);
     //   return $products;
    }

    public function getBrandList(Request $request)
    {
        $brand = DB::table("stocks")
            ->where("product_id",$request->product_id)
            ->pluck("brand_id","brand_id");
        $brands = DB::table("brands")->whereIn('id', $brand)->pluck("name","id");
        return response()->json($brands);
    }
    public function getSupplierList(Request $request)
    {
        $supplier = DB::table("stocks")
            ->where("brand_id",$request->brand_id)
           ->where("product_id",$request->product_id)
            ->pluck("supplier_id","supplier_id");
        $suppliers = DB::table("suppliers")->whereIn('id', $supplier)->pluck("name","id");
        return response()->json($suppliers);
    }

    public function getPriceList(Request $request)
    {
        $unit_price = DB::table("stocks")
            ->where("brand_id",$request->brand_id)
            ->where("product_id",$request->product_id)
            ->where("supplier_id",$request->supplier_id)
            ->pluck("unit_price")->first();
       // $unit_prices = DB::table("suppliers")->whereIn('id', $unit_price)->pluck("unit_price","unit_price");
        return response()->json($unit_price);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {

        $products= Product::orderBy('name', 'asc')->pluck('name', 'id' )->all();
        $categories= Category::pluck('name', 'id')->all();
        $suppliers= Supplier::pluck('name', 'id')->all();
        $brands= Brand::pluck('name', 'id')->all();

        return view('stocks.create', compact('products','categories','suppliers','brands'));
    }


    public function create1(Request $request)
    {
//        $count = DB::table("sales")->where("status", 0)->count();
//
//        $stocks = Stock::all()->Where('quantity', '>', 'quantity_used');
//        // $stock = DB::table("stocks")->pluck("product_id");
//        $stock = DB::table("stocks")->pluck("product_id", "product_id")->all();
//        $products = DB::table("products")->whereIn('id', $stock)->pluck("name","id");
        $products= Product::orderBy('name', 'asc')->pluck('name', 'id' )->all();

        return view('stocks.create_with_ajax')->with([
            'products' => $products

        ]);

//        $products= Product::orderBy('name', 'asc')->pluck('name', 'id' )->all();
//        $categories= Category::pluck('name', 'id')->all();
//        $suppliers= Supplier::pluck('name', 'id')->all();
//        $brands= Brand::pluck('name', 'id')->all();
//
//        return view('stocks.create', compact('products','categories','suppliers','brands'));
    }

/*
    public function getList(Request $request)
    {
        $brand = DB::table("products")
            ->where("id",$request->product_id)
            ->pluck("brand_id","brand_id");
        $brands = DB::table("brands")->whereIn('id', $brand)->pluck("name","id");
        return response()->json($brands);
    }
    public function getCategoryList(Request $request)
    {
        $supplier = DB::table("products")
            ->where("brand_id",$request->brand_id)
            ->where("id",$request->product_id)
            ->pluck("category_id","category_id");
        $suppliers = DB::table("categories")->whereIn('id', $supplier)->pluck("name","id");
        return response()->json($suppliers);
    }

*/
//    public function getBrand(Request $request)
//    {
//        $brand = DB::table("stocks")
//            ->where("product_id",$request->product_id)
//            ->pluck("brand_id","brand_id");
//        $brands = DB::table("brands")->whereIn('id', $brand)->pluck("name","id");
//        return response()->json($brands);
//
////        $brand = DB::table("products")
////            ->where("id",$request->product_id)
////            ->pluck("brand_id","brand_id");
////        $brands = DB::table("brands")->whereIn('id', $brand)->pluck("name","id");
////        return response()->json($brands);
//    }
//    public function getCategoryList1(Request $request)
//    {
//        $supplier = DB::table("stocks")
//            ->where("brand_id",$request->brand_id)
//            ->where("product_id",$request->product_id)
//            ->pluck("supplier_id","supplier_id");
//        $suppliers = DB::table("suppliers")->whereIn('id', $supplier)->pluck("name","id");
//        return response()->json($suppliers);
//
////        $supplier = DB::table("products")
////            ->where("brand_id",$request->brand_id)
////            ->where("id",$request->product_id)
////            ->pluck("category_id","category_id");
////        $suppliers = DB::table("categories")->whereIn('id', $supplier)->pluck("name","id");
////        return response()->json($suppliers);
//    }
//


    public function store(CreateStockRequest $request)
    {
        Stock::create($request->all());
//        $stock = Stock::where([
//            ['id', '=', $request->product_id],
//            ['supplier_id', '=', $request->supplier_id]
//        ])->first();
//
//        if ($stock) {
//            $stock->increment('quantity', $request->quantity);
//        } else {
       // Stock::create($request->all());
        // }
//        return $request->all();
        return redirect('/stock-management');
    }


    public function addCart(CreateCartRequest $request)
    {
        //Get Stock ID
        $beforeAdd = DB::table("stocks")
            ->where("brand_id",$request->brand_id)
            ->where("product_id",$request->product_id)
            ->where("supplier_id",$request->supplier_id)
            ->whereRaw('quantity > quantity_used')
            ->pluck('id','id')->first();
//return $beforeAdd;

//Get Stock Quantity
        $checkQuantity = DB::table("stocks")
            ->where("brand_id",$request->brand_id)
            ->where("product_id",$request->product_id)
            ->where("supplier_id",$request->supplier_id)
            ->whereRaw('quantity > quantity_used')
            ->pluck('quantity','quantity')->first();
//Get Stock Used Quantity
        $checkUsedQuantity = DB::table("stocks")
            ->where("brand_id",$request->brand_id)
            ->where("product_id",$request->product_id)
            ->where("supplier_id",$request->supplier_id)
            ->whereRaw('quantity > quantity_used')
            ->pluck('quantity_used','quantity_used')->first();
//
        $remainQuantity= $checkQuantity -$checkUsedQuantity;


            $quantity =  $request['quantity'];
            $total_price =  $request['unit_price']*$quantity;
            $tax= $total_price*0.05;
     if ( ($remainQuantity - $quantity) >= 0){

        Sale::create([

            'status' => 0,
            'stock_id' => $beforeAdd,
            'unit_price' => $request['unit_price'],
            'supplier_id' => $request['supplier_id'],
            'brand_id' => $request['brand_id'],
            'product_id' => $request['product_id'],
            'tax' => $tax,
            'quantity' => $request['quantity'],
            'total_price' => $total_price
        ]);
//        $stock = Stock::where([
//            ['id', '=', $request->product_id],
//            ['supplier_id', '=', $request->supplier_id]
//        ])->first();
//
//        if ($stock) {
//            $stock->increment('quantity', $request->quantity);
//        } else {
        // Stock::create($request->all());
        // }
//        return $request->all();
     }
        else{
            return redirect('shop-management')->withErrorMessage('Sorry you have '.  $remainQuantity . ' Parts Left in the Stock! ');
        }
        return redirect('shop-management')->withSuccessMessage('Item was added to your cart!');
//        return redirect('/shop-management');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $stock=Stock::findOrFail($id);

        $product= Product::pluck('name', 'id')->all();
        $category= Category::pluck('name', 'id')->all();
        $supplier= Supplier::pluck('name', 'id')->all();
        $brand= Brand::pluck('name', 'id')->all();


        return view('stocks.edit', compact('stock','product','category','supplier','brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $stock= Stock::findOrFail($id);

        $stock->update($request->all());

        Session::flash('update_stock','The Stock has been Updated');

        return redirect('/stock-management');
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
        $stocks= Stock::findOrFail($id);

        $stocks->delete();


        Session::flash('deleted_stock','The Stock has been deleted');


        return redirect('/stock-management');
    }


}
