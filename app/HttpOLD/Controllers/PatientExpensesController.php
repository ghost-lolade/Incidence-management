<?php

namespace App\Http\Controllers;
use App\ConsultantAttendTo;
use App\ConsultantPhamacy;
use App\ConsultFee;
use App\Http\Requests\AccountCreateRequest;
use App\Http\Requests\CreateStoreBillableRequest;
use App\Laboratory;
use App\LaboratoryTest;
use App\Patient;
use App\PatientAccount;
use App\PatientExpense;
use App\Sale;
use App\SaleProduct;
use App\Status;
use App\Stock;
//use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;





class PatientExpensesController extends Controller
{

    protected $redirectTo = '/account-management';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function index()
    {
        $saleselects = Sale::all()->where("is_status",0)
        ->where('insurance_id','<=','2');
        //   return view('shop/proceed');
        $statuses= Status::all()->where('checkout','!=', 2);
//        ->Where('accounting','<=', 1);
        $statusesa= Status::all()->where('checkout','!=', 2)
        ->Where('accounting','<=', 1)
        ->Where('insurance_id','>=', 1);
       // $statusesa= Status::all();
        return view('account.index', compact('statuses','saleselects','statusesa'));
    }


//    public function toPharmAccount(Request $request)
//    {
//        $user=Auth::user()->id;
//        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
//            ->Where('attend_to', '=', 1 )->count();
//
//        if ($consultants == 0){
//            // return $request->all();
//
//            $sale_id=$request['sale_id'];
//            $status_id = DB::table("sales")->where("id", "$sale_id")->pluck("status_id")->first();
//
//
//            $input = [
//                'accounting' => 1,
//            ];
//            Status::where('id', "$status_id")
//                ->update($input);
//
//            $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();
//            $consultant_id = DB::table("statuses")->where("id", "$status_id")->pluck("consultant_id")->first();
//
//            ConsultantAttendTo::create([
//                'patient_id' => $patient_id,
//                'user_id' =>    $request['user_id'],
//                'attend_to' => '1',
//                'status_id' => $status_id,
//            ]);
//
//            $inputPham = ['user_id' => $user, 'is_status' => 1,];
//            Sale::where('is_status', 0)
//                ->where('status_id', "$status_id")
//                ->update($inputPham);
//
//            return redirect('account-management/create');
//        } else
//        {
//            return redirect('account-management')->withErrorMessage('Please check out before attend to next patient! ');
//
////          return redirect('doc-management');
//        }
//    }


    public function createPatientExpenses(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
        if ($consultants == 0){

            // return $request->all();
            $status_id=$request['status_id'];
            $input = [
                'accounting' => 2,
            ];
            Status::where('id', "$status_id")
                ->update($input);

            $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();

            ConsultantAttendTo::create([

                'patient_id' => $patient_id,
                'user_id' => $request['user_id'],
                'attend_to' => '1',
                'status_id' => $request['status_id'],
            ]);
            return redirect('account-management/create');
        } else
        {
            return redirect('account-management')->withErrorMessage('You have one patient form yet to commplete! ');

//           return redirect('doc-management/create');
//           Session::flash('error_message','You have one patient yet to attend!!!');
//           return redirect('doc-management');
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 );
        $consultants[0]->patient_id;

        $statuses=Status::all()->where('accounting','==', 2)
                        ->Where('patient_id','==',$consultants[0]->patient_id );
//        $pharm = ConsultantPhamacy::all()->Where('user_id', '=', $user)
//            ->Where('is_status', '=', 1);
//        $sales = Sale::all()->Where('is_status', '=', '1' )
//            ->Where('user_id', '=', $user);
// $sales = Sale::all()->Where('is_status', '=', '1' )
//            ->Where('user_id', '=', $user);

        return view('account.create')->with([
//            'sales'    => $sales,
//            'pharm'    => $pharm,
            'statuses'    => $statuses,
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

    public function storeCredit (AccountCreateRequest $request) {

//         return $request->all();
        $user=Auth::user()->id;

//        $request['deposit'];
//        $request['status_id'];
        $patient_id=$request['patient_id'];

        PatientAccount::create([
            'patient_id' => $request['patient_id'],
            'credit' => $request['credit'],
            'paymentmode' => $request['paymentmode'],
            'status_id' => $request['status_id'],
            'debit' => $request['debit'],
            'discount' => $request['discount'],
//            'status_id' => $request['status_id'],
            'user_id' => $user,

        ]);

//
            $input = ['attend_to' => 2,];
            ConsultantAttendTo::where('patient_id', $patient_id)
                ->where('user_id', $user)
                ->update($input);

        $input = ['accounting' => 3,];
        Status::where('id', $request['status_id'])
            ->update($input);

            return redirect('account-management')->withSuccessMessage('Successfully Sent!');
//        }
//        else{
//
//            return redirect('account-management/create')->withErrorMessage('Failed, you have empty cart!');
//
//        }
    }

//            });
//        }
    //Billable/Sale Part: This part is sold for client/Bank



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
                $status = Status::findOrFail($id);
     //return $status->id;
              $patient = Patient::where('id','=', $status->patient_id)->first();
           $count = DB::table("statuses")->where("patient_id", $patient->id)->count();

            $lab = Laboratory::where('status_id','=', $status->id)->first();
            $registration  = ConsultFee::where('name','=', 'Registration')->first();
            $consulting  = ConsultFee::where('name','=', 'Consultancy Fee')->first();
           $sale = Sale::where('status_id','=', $status->id)->first();

           $patientAccount= PatientAccount::where('status_id','=', $status->id)->first();




        if ($sale != '' && $lab != '') {
            $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            $labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
            return view('account.show', compact('status', 'lab','patient','count','labTest','sale','saleProduct','registration','consulting','patientAccount'));
        }
        elseif ($sale == '' && $lab != '') {
          //  return 'Empty Lab';
          //  $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            $labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
            return view('account.show', compact('status', 'lab','patient','count','labTest','sale','registration','consulting','patientAccount'));
        }

        elseif($sale != '' && $lab == '') {
          //  return 'Empty Sale';
                $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            //$labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
           return view('account.show', compact('status', 'lab','patient','count','labTest','sale','saleProduct','registration','consulting','patientAccount'));
        }

        else  {
           // return 'Empty Sale and Lab';
            $registration  = ConsultFee::where('name','=', 'Registration')->first();
            $consulting  = ConsultFee::where('name','=', 'Consultancy Fee')->first();
        //    $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            //$labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
            return view('account.show', compact('status', 'lab','patient','count','labTest','sale','saleProduct','registration','consulting','patientAccount'));
        }

    }
    public function showQuick($id)
    {
        //
                $status = Status::findOrFail($id);
     //return $status->id;
              $patient = Patient::where('id','=', $status->patient_id)->first();
           $count = DB::table("statuses")->where("patient_id", $patient->id)->count();

            $lab = Laboratory::where('status_id','=', $status->id)->first();
            $registration  = ConsultFee::where('name','=', 'Registration')->first();
            $consulting  = ConsultFee::where('name','=', 'Consultancy Fee')->first();
           $sale = Sale::where('status_id','=', $status->id)->first();

        if ($sale != '' && $lab != '') {
            $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            $labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
            return view('account.show', compact('status', 'lab','patient','count','labTest','sale','saleProduct','registration','consulting'));
        }
        elseif ($sale == '' && $lab != '') {
          //  return 'Empty Lab';
          //  $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            $labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
            return view('account.show', compact('status', 'lab','patient','count','labTest','sale','registration','consulting'));
        }

        elseif($sale != '' && $lab == '') {
          //  return 'Empty Sale';
                $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            //$labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
           return view('account.show', compact('status', 'lab','patient','count','labTest','sale','saleProduct','registration','consulting'));
        }

        else  {
           // return 'Empty Sale and Lab';
            $registration  = ConsultFee::where('name','=', 'Registration')->first();
            $consulting  = ConsultFee::where('name','=', 'Consultancy Fee')->first();
        //    $saleProduct = SaleProduct::where('sale_id','=', $sale->id)->get();
            //$labTest = LaboratoryTest::where('laboratory_id','=', $lab->id)->get();
            return view('account.showQuick', compact('status', 'lab','patient','count','labTest','sale','saleProduct','registration','consulting'));
        }

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
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'website' => $request['website'],
            'contact_name' => $request['contact_name'],
            'state' => $request['state'],
            'lga' => $request['lga'],
            'country' => $request['country']

        ];

        $this->validateInput($request, $input);
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
//    public function destroyCart($id)
//    {
//        $sales= Sale::findOrFail($id)->delete();
//
////        $sales->delete();
//        Session::flash('deleted_stock','The Cart has been deleted');
//        return redirect('/sale-management');
//    }

    public function destroy($id)
    {
        $stocks = PatientExpense::findOrFail($id);

        $stock_id = DB::table("sale_products")->where("id", "$stocks->id")->pluck("stock_id")->first();
        $quantity_used = DB::table("sale_products")->where("id", "$stocks->id")->pluck("quantity")->first();

        $status = DB::table("sale_products")->where("status", 0)
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
