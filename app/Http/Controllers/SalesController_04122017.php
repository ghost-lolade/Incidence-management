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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Database;
use Excel;
use PDF;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        date_default_timezone_set('asia/ho_chi_minh');
        $format = 'Y/m/d';
        $now = date($format,strtotime("-30 days"));
        $to = date($format);
        $constraints = [
            'from' => $now,
            'to' => $to
        ];

        $sales = $this->getHiredEmployees($constraints);
        return view('sales/index', ['sales' => $sales, 'searchingVals' => $constraints]);
    }

    public function exportSaleExcel(Request $request) {
        $this->prepareExportingData($request)->export('xlsx');
        redirect()->intended('system-management/report');
    }

    public function exportSalePDF(Request $request) {
        $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $sales = $this->getExportingData($constraints);
        $pdf = PDF::loadView('sales/report/pdf', ['sales' => $sales, 'searchingVals' => $constraints]);
        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
        // return view('system-mgmt/report/pdf', ['sales' => $sales, 'searchingVals' => $constraints]);
    }

    private function prepareExportingData($request) {
        $author = Auth::user()->username;
        $sales = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
        return Excel::create('report_from_'. $request['from'].'_to_'.$request['to'], function($excel) use($sales, $request, $author) {

            // Set the title
            $excel->setTitle('List of hired employees from '. $request['from'].' to '. $request['to']);

            // Chain the setters
            $excel->setCreator($author)
                ->setCompany('HoaDang');

            // Call them separately
            $excel->setDescription('The list of hired employees');

            $excel->sheet('Hired_Employees', function($sheet) use($sales) {

                $sheet->fromArray($sales);
            });
        });
    }

    public function search(Request $request) {
        $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];

        $sales = $this->getHiredEmployees($constraints);
        return view('sales/index', ['sales' => $sales, 'searchingVals' => $constraints]);
    }

    private function getHiredEmployees($constraints) {
        $sales = Sale::where('sale_date', '>=', $constraints['from'])
            ->where('sale_date', '<=', $constraints['to'])
            ->get();
        return $sales;
    }



    private function getExportingData($constraints) {
        return DB::table('sales')
            ->leftJoin('products', 'sales.product_id', '=', 'products.id')
            ->leftJoin('brands', 'sales.brand_id', '=', 'brands.id')
            ->leftJoin('suppliers', 'sales.supplier_id', '=', 'suppliers.id')
            // ->leftJoin('country', 'sales.country_id', '=', 'country.id')
            // ->leftJoin('division', 'sales.division_id', '=', 'division.id')
            ->select('sales.sales_type','sales.terminal_id', 'sales.atm_name', 'products.name as product_name',
                'brands.name as brand_name', 'sales.unit_price','sales.quantity',
                'sales.total_price', 'sales.tax', 'sales.ce_name', 'sales.sale_date',
                'sales.customer_name', 'sales.customer_address', 'sales.note', //'sales.ce_name', 'sales.sale_date',
                'suppliers.name as supplier_name')
            ->where('sale_date', '>=', $constraints['from'])
            ->where('sale_date', '<=', $constraints['to'])
            ->orderBy('sales_type', 'asc')
            ->get()
            ->map(function ($item, $key) {
                return (array) $item;
            })
            ->all();
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
            'sales_type' => 'PPK/REWORK',

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
            'sales_type' => 'NOT BILLABLE',
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
            'atm_name' => Input::get("atm_name"),
            'serialno' => Input::get("serialno"),
            'sales_type' => 'BILLABLE',
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
            'note' => $request['note'],
            'sale_date' => $request['sale_date'],
            'serialno' => $request['sales_type'],
            'ce_name' => $request['ce_name'],
            'customer_name' => $request['customer_name'],
            'customer_address' => $request['customer_address'],
            

        ];

      //  $this->validateInput($request, $input);
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
        return redirect('/sale-management/create');
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
        return redirect('/sale-management/create');
    }


//    public function search(Request $request) {
//        $constraints = [
//            'terminal_id' => $request['username'],
//            'product_name' => $request['product_name'],
//            'ce_name' => $request['ce_name'],
//            'customer_name' => $request['customer_name']
//        ];
//
//        $sales = $this->doSearchingQuery($constraints);
//        return view('sales/index', ['sales' => $sales, 'searchingVals' => $constraints]);
//    }
//
//    private function doSearchingQuery($constraints) {
//        $query = Sale::query();
//        $fields = array_keys($constraints);
//        $index = 0;
//        foreach ($constraints as $constraint) {
//            if ($constraint != null) {
//                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
//            }
//
//            $index++;
//        }
//        return $query->paginate(50);
//    }
}
