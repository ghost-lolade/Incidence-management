<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateStoreBillableRequest;
use App\Http\Requests\CreateStoreNotBillableRequest;
use App\Http\Requests\CreateStoreStockCERequest;
use App\Http\Requests\SalesCreateRequest;
use App\Sale;
use App\Stock;
use App\Product;
use App\Category;
use App\Supplier;
use \Cart as Cart;
//use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Database;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //   return view('shop/proceed');
        $sales= Sale::paginate(5);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sales = Sale::all()->Where('status', '=', '0' );

        return view('sales.create')->with([
            'sales'    => $sales,
        ]);
    }

//    public function getCart()
//    {
//        $sales = Sale::all()->Where('status', '=', '0' );
//
//        //  $stocks = Stock::all()->Where('quantity', '>', '0');
//        // $stock = DB::table("stocks")->pluck("product_id");
//        // $stock = DB::table("stocks")->where("brand_id",1)->pluck("product_id", "product_id")->all();
//        //$products = DB::table("products")->whereIn('id', $stock)->pluck("name","id");
//        return view('shop.test')->with([
//            'sales'    => $sales,
//        ]);
//        //   return $products;
//    }

    // Stock 4 CE : Part given to the CE for Keep
    public function storeStockCE (CreateStoreStockCERequest $request)
    {
        $count = DB::table("sales")->where("status", 0)->count();
        $sales = DB::table("sales")->where("status", 0)->pluck("stock_id")->all();
        $quantity = DB::table("sales")->where("status", 0)->pluck("quantity")->all();

        for ($i = 0; $i < $count; $i++) {
            $stock = Stock::where([
                ['id', '=', $sales[$i]],])->first();
            if ($stock) {
                $stock->increment('quantity_used', $quantity[$i]);
            } else {
                // Stock::create($request->all());
            }
        }
        $update = [
            'ce_name' => Input::get('ce_name'),
            'serialno' => Input::get('serialno'),
            'note' => Input::get('note'),
            'status' => 1,

        ];
//        return  $update;
        \DB::table('sales')->where('status', '0')->update($update);
        return redirect('shop-management')->withSuccessMessage('PPK successfully send to CE!');
//        return redirect('shop-management');
    }

    public function storeNotBillable (CreateStoreNotBillableRequest $request) {

        $count = DB::table("sales")->where("status",0)->count();
        $sales = DB::table("sales")->where("status",0)->pluck("stock_id")->all();
        $quantity = DB::table("sales")->where("status",0)->pluck("quantity")->all();

        for ($i = 0; $i < $count; $i++) {
            $stock = Stock::where([
                ['id', '=', $sales[$i]],])->first();
            if ($stock) {
                $stock->increment('quantity_used', $quantity[$i]);
//                return $stock;
            } else {
                // Stock::create($request->all());
            }
        }
//                for ($i = 0; $i < $counter; $i++) {
        $update = [
            'terminal_id' => Input::get('terminal'),
            'status'   => 1,
            'note' => Input::get("note"),
            'sale_date' => Input::get("sale_date"),
            'serialno' => Input::get("serialno"),
        ];

//        return  $update;
        \DB::table('sales')->where('status', '0')->update($update);

        return redirect('shop-management')->withSuccessMessage('Not Billable Part successfully Sent!');
    }
//            });
//        }
    //Billable/Sale Part: This part is sold for client/Bank

    public function storeBillable (CreateStoreBillableRequest $request) {
        $count = DB::table("sales")->where("status",0)->count();
        $sales = DB::table("sales")->where("status",0)->pluck("stock_id")->all();
        $quantity = DB::table("sales")->where("status",0)->pluck("quantity")->all();

        for ($i = 0; $i < $count; $i++) {
            $stock = Stock::where([
                ['id', '=', $sales[$i]],])->first();
            if ($stock) {
                $stock->increment('quantity_used', $quantity[$i]);
            } else {
                // Stock::create($request->all());
            }
        }
        $update = [
            'terminal_id' => Input::get('terminal_id'),
            'status'   => 1,
            'customer_name' => Input::get("customer_name"),
            'customer_address' => Input::get("customer_address"),
            'serialno' => Input::get("serialno"),
        ];
        \DB::table('sales')->where('status', '0')->update($update);
//               }
//           });
//       }
        return redirect('shop-management')->withSuccessMessage('Billable Part taken from Stock!');
//     Cart::destroy();
//        return redirect('shop-management');
    }
//    public function store(Request $request) {
////
////        //
//        return redirect('shop-management');
//    }
//
// public function store(SalesCreateRequest $request) {
//      //  return '<pre>'.print_r(Input::all(), true).'</pre>';
//
//        $terminal_id = Input::get('terminal_id');
//        $customer_name = Input::get('customer_name');
//        $ce_name = Input::get('ce_name');
//        $note = Input::get('note');
//
//        // Stock 4 CE : Part given to the CE for Keep
//        if( $terminal_id == '' && $ce_name != '' ) {
//
//    $counter = Input::get('counter');
//    \DB::transaction(function () use ($counter) {
//        for ($i = 0; $i < $counter; $i++) {
//            Sale::create([
//                'terminal_id' => Input::get("terminal_id"),
//                'customer_name' => Input::get("customer_name"),
//                'unit_price' => Input::get("unit_price")[$i],
//                'total_price' => Input::get("total_price")[$i],
//                'tax' => Input::get("tax")[$i],
//                'ce_name' => Input::get('ce_name'),
//                'quantity' => Input::get("quantity")[$i],
//                'stock_id' => Input::get("stock_id")[$i],
//                'product_name' => Input::get("product_name")[$i],
//                'sale_date' => Input::get("sale_date"),
//                'rowId' => Input::get("rowId")[$i]
//            ]);
//
//            $stock = Stock::where([
//                ['id', '=', Input::get("stock_id")[$i]],
//                //     ['supplier_id', '=', $request->supplier_id]
//            ])->first();
//
//            if ($stock) {
//                $stock->increment('quantity_used', Input::get("quantity")[$i]);
//            } else {
//                // Stock::create($request->all());
//            }
//
//        }
//    });
//}
//        // Not Billable: This part is use for the Bank at UHL expense
//        elseif( $customer_name == ''  && $ce_name=='') {
//            $counter = Input::get('counter');
//            \DB::transaction(function () use ($counter) {
//                for ($i = 0; $i < $counter; $i++) {
//                    Sale::create([
//                        'terminal_id' => Input::get("terminal"),
//                       // 'customer_name' => Input::get("customer_name"),
//                        'unit_price' => Input::get("unit_price")[$i],
//                        'total_price' => Input::get("total_price")[$i],
//                        'tax' => Input::get("tax")[$i],
//                        'quantity' => Input::get("quantity")[$i],
//                        'stock_id' => Input::get("stock_id")[$i],
//                        'product_name' => Input::get("product_name")[$i],
//                        'sale_date' => Input::get("sale_date"),
//                        'note' => Input::get("note"),
//                        'rowId' => Input::get("rowId")[$i]
//                    ]);
//
//                    $stock = Stock::where([
//                        ['id', '=', Input::get("stock_id")[$i]],
//                        //     ['supplier_id', '=', $request->supplier_id]
//                    ])->first();
//
//                    if ($stock) {
//                        $stock->increment('quantity_used', Input::get("quantity")[$i]);
//                    } else {
//                        // Stock::create($request->all());
//                    }
//
//                }
//            });
//        }
//        //Billable/Sale Part: This part is sold for client/Bank
//
//       elseif  (( $ce_name == '' && $note=='')) {
//
//           $counter = Input::get('counter');
//
//           \DB::transaction(function () use ($counter) {
//               for ($i = 0; $i < $counter; $i++) {
//                   Sale::create([
//                       'terminal_id' => Input::get("terminal_id"),
//                       'customer_name' => Input::get("customer_name"),
//                       'unit_price' => Input::get("unit_price")[$i],
//                       'total_price' => Input::get("total_price")[$i],
//                       'tax' => Input::get("tax")[$i],
//                       'quantity' => Input::get("quantity")[$i],
//                       'stock_id' => Input::get("stock_id")[$i],
//                       'product_name' => Input::get("product_name")[$i],
//                       'sale_date' => Input::get("sale_date"),
//                       'customer_address' => Input::get("customer_address"),
//                       'rowId' => Input::get("rowId")[$i]
//                   ]);
//
//                   $stock = Stock::where([
//                       ['id', '=', Input::get("stock_id")[$i]],
//                  //     ['supplier_id', '=', $request->supplier_id]
//                   ])->first();
//
//                   if ($stock) {
//                       $stock->increment('quantity_used', Input::get("quantity")[$i]);
//                   } else {
//                      // Stock::create($request->all());
//                   }
//               }
//           });
//       }
//
//     Cart::destroy();
//        return redirect('shop');
//    }

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
        $sale = Sale::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($sale == null || count($sale) == 0) {
            return redirect()->intended('/sale-management');
        }

        return view('sales/edit', ['sale' => $sale]);
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
        $sale = Sale::findOrFail($id);
        // $this->validateInput($request);
        $input = [
            'terminal_id' => $request['terminal_id'],
            'ce_name' => $request['ce_name'],
            'customer_name' => $request['customer_name'],
            'customer_address' => $request['customer_address'],
            'product_name' => $request['product_name'],
            'tax' => $request['tax'],
            'quantity' => $request['quantity'],
            'sale_date' => $request['sale_date'],
             'note' => $request['note'],
              'total_price' => $request['total_price'],
            'unit_price' => $request['unit_price']

        ];

       // $this->validateInput($request, $input);
        Sale::where('id', $id)
            ->update($input);

        return redirect()->intended('/sale-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCart($id)
    {
        $sales= Sale::findOrFail($id)->delete();

//        $sales->delete();
        Session::flash('deleted_stock','The Cart has been deleted');
        return redirect('/sale-management');
    }

 public function destroy($id)
 {
     $stocks = Sale::findOrFail($id);

     $stock_id = DB::table("sales")->where("id", "$stocks->id")->pluck("stock_id")->first();
     $quantity_used = DB::table("sales")->where("id", "$stocks->id")->pluck("quantity")->first();

     $status = DB::table("sales")->where("status", 0)
         ->where("id", "$stocks->id")->pluck("id")->first();
//return $status;
     if ($status) {

         $stocks->delete();
         Session::flash('deleted_stock', 'The Cart has been deleted');

     } else {

         $stock = Stock::where('id', '=', $stock_id)->first();
         if ($stock) {
             $stock->decrement('quantity_used', $quantity_used);
         } else {
             // Stock::create($request->all());
         }

         $stocks->delete();
         Session::flash('deleted_stock', 'The Cart has been deleted');

     }
     return redirect('/sale-management');
 }


    public function search(Request $request) {
        $constraints = [
            'terminal_id' => $request['username'],
            'product_name' => $request['product_name'],
            'ce_name' => $request['ce_name'],
            'customer_name' => $request['customer_name']
        ];

        $sales = $this->doSearchingQuery($constraints);
        return view('sales/index', ['sales' => $sales, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Sale::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(50);
    }
}
