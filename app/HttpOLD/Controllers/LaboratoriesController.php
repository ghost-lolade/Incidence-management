<?php

namespace App\Http\Controllers;

use App\ConsultantAttendTo;
use App\ConsultantLaboratory;
use App\ConsultantPhamacy;
use App\Department;
use App\LabBloodGroup;
use App\LabBloodMicrofilaria;
use App\LabDiffWhiteBloodCell;
use App\LabErythrocyteSedimentationRate;
use App\LabFee;
use App\LabHaemoglobin;
use App\LabMalarialParasite;
use App\Laboratory;
use App\LaboratoryTest;
use App\LabPregnacyTest;
use App\LabStoolAnalysis;
use App\LabUrinalysis;
use App\LabUrineMicroscopy;
use App\LabVDRL;
use App\LabWhiteBloodCell;
use App\LabWidalTest;
use App\Pvc;
use App\Status;
use App\Stock;
//use Illuminate\Contracts\Session\Session;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaboratoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $statuses = Status::all()->where("laboratory",1)
            ->where("insurance_id", '>',2);
        $attendToPrivates = Laboratory::all()->where("payment_status",'PAID')
            ->where("is_status",1);
        $addResult = Laboratory::all()->where("is_status",4);
        //   return view('shop/proceed');
        $labs= Laboratory::paginate(5);
        return view('laboratory.index', compact('labs','statuses','attendToPrivates','addResult'));

    }

    public function accountLab()
    {
        //
        $attendPrivates = Status::all()->where("laboratory",1)
            ->where("insurance_id", '<',3);
//        $attendPrivates = Laboratory::all()->where("payment_status",'PAID')
//            ->where("is_status",1);
        //   return view('shop/proceed');
        $sales= Laboratory::paginate(5);
        return view('laboratory.account', compact('sales','statuses','attendPrivates'));
    }

//    public function toPharmacy(Request $request)
    public function toLabFee(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
        $stat=$request['status_id'];
        if ($consultants == 0){
            // return $request->all();
            $status_id=$request['status_id'];
            $input = [
                'laboratory' => 2,
            ];
            Status::where('id', "$status_id")
                ->update($input);

            $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();
            $consultant_id = DB::table("statuses")->where("id", "$status_id")->pluck("consultant_id")->first();

            ConsultantAttendTo::create([
                'patient_id' => $patient_id,
                'user_id' => $request['user_id'],
                'attend_to' => '1',
                'status_id' => $stat,
            ]);

            $inputLab = ['user_id' => $user, 'is_status' => 1,];
            ConsultantLaboratory::where('consultant_id', "$consultant_id")
                ->where('patient_id', "$patient_id")
                ->update($inputLab);

            return redirect('labshop-management');
        } else
        {
            return redirect('labaccount-management')->withErrorMessage('Please check out before attend to next patient! ');

//           return redirect('doc-management/create');
//           Session::flash('error_message','You have one patient yet to attend!!!');
//           return redirect('doc-management');
        }
    }

    public function getLabList()
    {

        //Tracking Cart items
        $user=Auth::user()->id;
        $count = DB::table("laboratory_tests")->where("status", 0)
            ->where("user_id", $user)->count();

        $pharm = ConsultantLaboratory::all()->Where('is_status', '=', 1)
        ->Where('user_id', '=', $user);
        $quick = ConsultantAttendTo::all()->Where('attend_to', '=', 1)
        ->Where('user_id', '=', $user);

        // Check new items is avaliable
        $stocks = Stock::all()->Where('quantity', '>', 'quantity_used');
        // $stock = DB::table("stocks")->pluck("product_id");
      //  $stock = DB::table("stocks")->pluck("product_id", "product_id")->all();
        $products = DB::table("lab_fees")->pluck("name","id");

        return view('laboratory.labshop')->with([
            'stocks'   => $stocks,
            'products' => $products,
            'pharm' => $pharm,
            'count' => $count,
            'quick' => $quick
        ]);
        //   return $products;
    }

    public function getLabPriceList(Request $request)
    {
        $unit_price = DB::table("lab_fees")
            ->where("id",$request->labtest_id)
            ->pluck("amount");
        //  $unit_prices = DB::table("suppliers")->whereIn('id', $unit_price)->pluck("unit_price","unit_price");
        return response()->json($unit_price);
    }


    public function addCart(Request $request)
    {
//return $request->all();
//            $tax= $total_price*0.05;

            $user= Auth::user()->id;
            LaboratoryTest::create([
                'status' => 0,
                'user_id' =>   $user,
                'amount' => $request['unit_price'],
                'lab_fee_id' => $request['labtest_id'],

            ]);
        return redirect('labshop-management')->withSuccessMessage('Lab Test was added!');
//        return redirect('/shop-management');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Insurance Function for Lab

    public function create()
    {
//        $doc = LabFee::find(1);
        $user=Auth::user()->id;
        $pharm = ConsultantLaboratory::all()->Where('user_id', '=', $user)
            ->Where('is_status', '=', 1);
        $quick = ConsultantAttendTo::all()->Where('attend_to', '=', 1)
            ->Where('user_id', '=', $user);



        $lab = LaboratoryTest::all()->Where('status', '=', '0' )
            ->Where('user_id', '=', $user);

        $total_sum = DB::table('laboratory_tests')
            ->selectRaw('sum(amount)  as totalPrice')
            ->Where('status', '=', '0' )
            ->Where('user_id', '=', $user)
            ->pluck('totalPrice');

        //  $total_sum[0];

        return view('laboratory.create')->with([
            'lab'    => $lab,
            'pharm'    => $pharm,
            'quick'    => $quick,
            'total_sum'    => $total_sum,
        ]);

    }

    public function storeLabPayment (Request $request) {

      // return $request->all();
        $deposit=  $request['deposit'];
        $patient_id =$request['patient_id'];
//     return $request->all();
        $user=Auth::user()->id;
        $count = DB::table("laboratory_tests")->where("status",0)
            ->Where('user_id', '=', $user)->count();

        if($count > 0 ){
            $total_sum = DB::table('laboratory_tests')
                ->selectRaw('sum(amount)  as totalPrice')
                ->Where('status', '=', '0' )
                ->Where('user_id', '=', $user)
                ->pluck('totalPrice');

            $total_sum[0];
//                for ($i = 0; $i < $counter; $i++) {
            $grand_total =  $total_sum[0];;

            $sale_id = Laboratory::create([
                'patient_id' => $patient_id,
                'status_id' => $request['status_id'],
                'total_price' => $grand_total,
                'payment_status'=>'PAID',
                'amount_deposit'=> $deposit,
                'user_id' => $user,
                'is_status' => 1,
            ]);

            \DB::table('patient_expenses')
                ->where('status_id', $request['status_id'])->increment('laboratory', $grand_total);


            $lastSaleId = $sale_id->id;
            $update = [
                'laboratory_id' => $lastSaleId,
                'status'   => 1,
            ];
//        return  $update;
            \DB::table('laboratory_tests')->where('status', '0')
                ->Where('user_id', '=', $user)->update($update);

            $patient_id=$request['patient_id'];
            $input = [
                'is_status' => 2,
            ];
            ConsultantLaboratory::where('patient_id', $patient_id)
                ->where('user_id', $user)
                ->update($input);

            $input = ['attend_to' => 2,];
            ConsultantAttendTo::where('patient_id', $patient_id)
                ->where('user_id', $user)
                ->update($input);


            return redirect('lab-management')->withSuccessMessage('Successfully Sent!');
        }
        else{

            return redirect('lab-management/create')->withErrorMessage('Failed, empty test field!');

        }
    }

    public function toLabFeeInsurance(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
        $stat=$request['status_id'];
        if ($consultants == 0){
            // return $request->all();
            $status_id=$request['status_id'];
            $input = [
                'laboratory' => 2,
            ];
            Status::where('id', "$status_id")
                ->update($input);

            $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();
            $consultant_id = DB::table("statuses")->where("id", "$status_id")->pluck("consultant_id")->first();

            ConsultantAttendTo::create([
                'patient_id' => $patient_id,
                'user_id' => $request['user_id'],
                'attend_to' => '1',
                'status_id' => $stat,
            ]);

            $inputLab = ['user_id' => $user, 'is_status' => 1,];
            ConsultantLaboratory::where('consultant_id', "$consultant_id")
                ->where('patient_id', "$patient_id")
                ->update($inputLab);

            return redirect('labshopins-management');
        } else
        {
            return redirect('lab-management')->withErrorMessage('Please check out before attend to next patient! ');

//           return redirect('doc-management/create');
//           Session::flash('error_message','You have one patient yet to attend!!!');
//           return redirect('doc-management');
        }
    }

    public function getLabListInsurnace()
    {

        //Tracking Cart items
        $user=Auth::user()->id;
        $count = DB::table("laboratory_tests")->where("status", 0)
            ->where("user_id", $user)->count();

        $pharm = ConsultantLaboratory::all()->Where('is_status', '=', 1)
            ->Where('user_id', '=', $user);

        $products = LabFee::select(DB::raw('concat (name," ",code) as full_name,id'))->orderBy('name')->pluck('full_name', 'id');



        return view('laboratory.labInsurance')->with([
         //   'stocks'   => $stocks,
            //  'stock'    => $stock,
            'products' => $products,
            'pharm' => $pharm,
            'count' => $count
        ]);
        //   return $products;
    }

    public function getLabPriceListInsurance(Request $request)
    {
        $unit_price = DB::table("lab_fees")
            ->where("id",$request->labtest_id)
            ->where("insurance_id",$request->insurance_id)
            ->pluck("amount");
        return response()->json($unit_price);
    }


    public function addCartInsurance(Request $request)
    {
//return $request->all();
//            $tax= $total_price*0.05;

        $user= Auth::user()->id;
        LaboratoryTest::create([
            'status' => 0,
            'user_id' =>   $user,
            'amount' => $request['unit_price'],
            'lab_fee_id' => $request['labtest_id'],

        ]);
        return redirect('labshopins-management')->withSuccessMessage('Lab Test was added!');
//        return redirect('/shop-management');
    }

    public function createInsurnace()
    {
//        $doc = LabFee::find(1);
        $user=Auth::user()->id;
        $pharm = ConsultantLaboratory::all()->Where('user_id', '=', $user)
            ->Where('is_status', '=', 1);
        $lab = LaboratoryTest::all()->Where('status', '=', '0' )
            ->Where('user_id', '=', $user);

        $total_sum = DB::table('laboratory_tests')
            ->selectRaw('sum(amount)  as totalPrice')
            ->Where('status', '=', '0' )
            ->Where('user_id', '=', $user)
            ->pluck('totalPrice');

        //  $total_sum[0];

        return view('laboratory.createInsurance')->with([
            'lab'    => $lab,
            'pharm'    => $pharm,
            'total_sum'    => $total_sum,
        ]);

    }

    public function storeLabInsurnace (Request $request) {

        //  return $request->all();
        $status_id=  $request['status_id'];
        $patient_id =$request['patient_id'];
//     return $request->all();
        $user=Auth::user()->id;
        $count = DB::table("laboratory_tests")->where("status",0)
            ->Where('user_id', '=', $user)->count();

        if($count > 0 ){
            $total_sum = DB::table('laboratory_tests')
                ->selectRaw('sum(amount)  as totalPrice')
                ->Where('status', '=', '0' )
                ->Where('user_id', '=', $user)
                ->pluck('totalPrice');

            $total_sum[0];
//                for ($i = 0; $i < $counter; $i++) {
            $grand_total =  $total_sum[0];;

            $sale_id = Laboratory::create([
                'patient_id' => $patient_id,
                 'status_id' => $status_id,
                'total_price' => $grand_total,
                'payment_status'=>'UNPAID',
                'amount_deposit'=> 0,
                'user_id' => $user,
                'is_status' => 3,
            ]);
            $input = [
                'laboratory' => 3,
            ];
            Status::where('id', "$status_id")
                ->update($input);


            \DB::table('patient_expenses')
                ->where('status_id', $request['status_id'])->increment('laboratory', $grand_total);


//Please check this later

            $lastSaleId = $sale_id->id;
            $update = [
                'laboratory_id' => $lastSaleId,
                'status'   => 1,
            ];
//        return  $update;
            \DB::table('laboratory_tests')->where('status', '0')
                ->Where('user_id', '=', $user)->update($update);

            $patient_id=$request['patient_id'];
            $input = [
                'is_status' => 2,
            ];
            ConsultantLaboratory::where('patient_id', $patient_id)
                ->where('user_id', $user)
                ->update($input);

//            $input = ['attend_to' => 1,];
//            ConsultantAttendTo::where('patient_id', $patient_id)
//                ->where('user_id', $user)
//                ->update($input);

            return redirect('labdotest-management')->withSuccessMessage('Successfully Sent!');
        }
        else{

            return redirect('lab-management/create')->withErrorMessage('Failed, empty test field!');

        }
    }


    //Complete Lab Test

    public function completeLab(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
//        $attendToPrivates = Laboratory::all()->where("payment_status",'PAID')
//            ->where("is_status",1);


        $stat=$request['lab_id'];
        $status_id = DB::table("laboratories")->where("id", "$stat")->pluck("status_id")->first();
        $patient_id = DB::table("laboratories")->where("id", "$stat")->pluck("patient_id")->first();

         if ($consultants == 0) {
             // return $request->all();
           //  $status_id = $request['status_id'];
             $input = [
                 'laboratory' => 3,
             ];
             Status::where('id', "$status_id")
                 ->update($input);

//Please check this later
             $inputLab = [
                 'is_status' => 3,
             ];
             Laboratory::where('status_id', "$status_id")
                 ->update($inputLab);

//               $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();
             // $consultant_id = DB::table("statuses")->where("id", "$status_id")->pluck("consultant_id")->first();
             ConsultantAttendTo::create([
                 'attend_to' => 1,
                 'user_id' =>   $user,
                 'patient_id' => $patient_id,
                 'status_id' => $status_id,

             ]);

             return redirect('labdotest-management');// ->withSuccessMessage('Please check out before attend patient! ');

             //     return redirect('lab-management')->withSuccessMessage('Lab Test Completed! ');
         }
         else
        {
            return redirect('lab-management')->withErrorMessage('Please check out before attend patient! ');
      }
    }

    public function createLabToConduct()
    {
        $user=Auth::user()->id;
        $pharm = Laboratory::all()->Where('user_id', '=', $user)
            ->Where('is_status', '=', 3);
        $patient_id = Laboratory::Where('user_id', '=', $user)
            ->Where('is_status', '=', 3)->pluck('patient_id')->first();
//        $lab = Laboratory::all()->Where('is_status', '=', '2' )
//            ->Where('user_id', '=', $user);
       // return     $pharm[11]->patient_id;
        $lab_id = DB::table("laboratories")->Where('is_status', '=', '3' )
            ->Where('user_id', '=', $user)->pluck("id")->first();

        $lab = LaboratoryTest::all()->Where('laboratory_id', '=', $lab_id )
                                        ->Where('status','=', 1);
//
//        $today = Carbon::now()->toDateString();
//
//         $lab_pvc = Pvc::Where('is_status', '=', '2' )
//            ->Where('user_id', '=', $user)->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();
//
//         $lab_haemoglobin = LabHaemoglobin::Where('is_status', '=', '2' )
//            ->Where('user_id', '=', $user)->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();
//
//        $viewpvc = Pvc::all()->Where('is_status', '=', '2' )
//                        ->Where('patient_id', '=', $patient_id );
////            ->where('created_at', '>=', Carbon::today());
//        $viewhb = LabHaemoglobin::all()->Where('is_status', '=', '2' )
//                     ->Where('patient_id', '=', $patient_id );
////                ->where('created_at', '>=', Carbon::today());

        return view('laboratory.createLabToConduct')->with([
            'lab'    => $lab,
            'pharm'    => $pharm,
//            'viewpvc'    => $viewpvc,
//            'lab_pvc'    => $lab_pvc,
//            'viewhb'    => $viewhb,
//            'lab_haemoglobin'    => $lab_haemoglobin,
        ]);

    }


    public function labTestConducted(Request $request)
    {
        // return $request->all();
        $user=Auth::user()->id;
//        $lab_id=$request['lab_id'];
        $status_id=$request['status_id'];
        $patient_id=$request['patient_id'];

        $input = [
            'is_status' => 4,
        ];
        Laboratory::Where('status_id', '=', $status_id)
            ->Where('is_status', '=', 3)
            ->Where('patient_id', '=', $patient_id)
            ->update($input);

        $input = ['attend_to' => 2,];
        ConsultantAttendTo::where('patient_id', $patient_id)
            ->where('user_id', $user)
            ->update($input);


        return redirect('lab-management')->withSuccessMessage('Successful! ');
    }

    public function labTestCompleted(Request $request)
    {
//         return $request->all();
        $user=Auth::user()->id;
//        $lab_id=$request['lab_id'];
        $status_id=$request['status_id'];
        $patient_id=$request['patient_id'];

        $input = [
            'is_status' => 6,
        ];
        Laboratory::Where('status_id', '=', $status_id)
            ->Where('is_status', '=', 5)
            ->Where('patient_id', '=', $patient_id)
            ->update($input);

        $laboratory= Laboratory::Where('status_id', '=', $status_id)
            ->Where('is_status', '=', 6)
            ->Where('patient_id', '=', $patient_id)->pluck('id');

//return $laboratory[0];
        $input = [
            'status' => 2,
        ];
        LaboratoryTest::Where('laboratory_id', '=', $laboratory[0])
            ->Where('status', '=', 1)
            ->update($input);

        $input = ['attend_to' => 2,];
        ConsultantAttendTo::where('patient_id', $patient_id)
            ->where('user_id', $user)
            ->update($input);


        if ($request['department'] == '1') {

            $input = [
                'nurse' => 1,
                'laboratory' => 6,

            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);

        }

        if ($request['department'] == '2') {

            $input = [
                'dental' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);

        }

        if ($request['department'] == '3') {

            $input = [
                'laboratory' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);
        }

        if ($request['department'] == '4') {

            $input = [
                'consulting' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);
        }

        if ($request['department'] == '5') {


            $input = [
                'pharmacy' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);
        }

        if ($request['department'] == '6') {

            $input = [
                'accounting' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);
        }

        if ($request['department'] == '7') {

            $input = [
                'gynaecology' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);
        }

        if ($request['department'] == '8') {

            $input = [
                'antenatal' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);

        }

        if ($request['department'] == '9') {

            $input = [
                'physiotherapy' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);

        }

        if ($request['department'] == '10') {

            $input = [
                'cardiology' => 1,
                'laboratory' => 6,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('laboratory', 5)
                ->update($input);
        }

        return redirect('lab-management')->withSuccessMessage('Successful! ');
    }




    public function addLabResult(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
        $stat=$request['lab_id'];
        $status_id = DB::table("laboratories")->where("id", "$stat")->pluck("status_id")->first();
        $patient_id = DB::table("laboratories")->where("id", "$stat")->pluck("patient_id")->first();

        if ($consultants == 0) {
            // return $request->all();
            //  $status_id = $request['status_id'];
            $input = [
                'laboratory' => 5,
            ];
            Status::where('id', "$status_id")
                ->update($input);

//Please check this later
            $inputLab = [
                'is_status' => 5,
            ];
            Laboratory::where('status_id', "$status_id")
                ->update($inputLab);

//               $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();
            // $consultant_id = DB::table("statuses")->where("id", "$status_id")->pluck("consultant_id")->first();
            ConsultantAttendTo::create([
                'attend_to' => 1,
                'user_id' =>   $user,
                'patient_id' => $patient_id,
                'status_id' => $status_id,

            ]);

            return redirect('labresult-management');// ->withSuccessMessage('Please check out before attend patient! ');

            //     return redirect('lab-management')->withSuccessMessage('Lab Test Completed! ');
        }
        else
        {
            return redirect('lab-management')->withErrorMessage('Please check out before attend patient! ');
        }
    }

//    public function labTestConducted(Request $request)
//    {
//        // return $request->all();
//        $user=Auth::user()->id;
////        $lab_id=$request['lab_id'];
//        $status_id=$request['status_id'];
//        $patient_id=$request['patient_id'];
//
//        $input = [
//            'is_status' => 4,
//        ];
//        Laboratory::Where('status_id', '=', $status_id)
//            ->Where('is_status', '=', 3)
//            ->Where('patient_id', '=', $patient_id)
//            ->update($input);
//
//        $input = ['attend_to' => 2,];
//        ConsultantAttendTo::where('patient_id', $patient_id)
//            ->where('user_id', $user)
//            ->update($input);
//
//
//        return redirect('lab-management')->withSuccessMessage('Successful! ');
//    }
//
//    public function labTestCompleted(Request $request)
//    {
//        // return $request->all();
//        $user=Auth::user()->id;
////        $lab_id=$request['lab_id'];
//        $status_id=$request['status_id'];
//        $patient_id=$request['patient_id'];
//
//        $input = [
//            'is_status' => 4,
//        ];
//        Laboratory::Where('status_id', '=', $status_id)
//            ->Where('is_status', '=', 3)
//            ->Where('patient_id', '=', $patient_id)
//            ->update($input);
//
//        $input = ['attend_to' => 2,];
//        ConsultantAttendTo::where('patient_id', $patient_id)
//            ->where('user_id', $user)
//            ->update($input);
//
//
//        return redirect('lab-management')->withSuccessMessage('Successful! ');
//    }
//


    public function createLabComplete()
    {

        $user=Auth::user()->id;
        $departments =Department::all();
        $pharm = Laboratory::all()->Where('user_id', '=', $user)
            ->Where('is_status', '=', 5);
        $patient_id = Laboratory::Where('user_id', '=', $user)
            ->Where('is_status', '=', 5)->pluck('patient_id')->first();
        $lab_id = DB::table("laboratories")->Where('is_status', '=', '5' )
            ->Where('user_id', '=', $user)->pluck("id")->first();

        $lab = LaboratoryTest::all()->Where('laboratory_id', '=', $lab_id )
            ->Where('status', '=', 1 )
            ->Where('user_id', '=', $user );

        $today = Carbon::now()->toDateString();

         $lab_pvc = Pvc::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
             ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

         $lab_haemoglobin = LabHaemoglobin::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
             ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();
        $lab_wbc = LabWhiteBloodCell::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

    $lab_dwbc = LabDiffWhiteBloodCell::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewdwbc  = LabDiffWhiteBloodCell::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());

        $lab_esr = LabErythrocyteSedimentationRate::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewesr  = LabErythrocyteSedimentationRate::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());

        $lab_mp = LabMalarialParasite::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();
        $viewmp  = LabMalarialParasite::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());



        $lab_wt = LabWidalTest::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewmt  = LabWidalTest::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());



        $lab_bg = LabBloodGroup::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewbg  = LabBloodGroup::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());

        $lab_vdrl = LabVDRL::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();
        $viewvdrl  = LabVDRL::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());

        $lab_bm = LabBloodMicrofilaria::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();
        $viewvbm  = LabBloodMicrofilaria::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());




        $lab_um = LabUrineMicroscopy::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewum  = LabUrineMicroscopy::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());

        $lab_ua = LabUrinalysis::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewua  = LabUrinalysis::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());

        $lab_pt = LabPregnacyTest::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewpt  = LabPregnacyTest::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());


        $lab_sa = LabStoolAnalysis::Where('is_status', '=', '2' )
            ->Where('user_id', '=', $user)
            ->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        $viewsa  = LabStoolAnalysis::all()->Where('is_status', '=', '2' )
            ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());



        $viewpvc = Pvc::all()->Where('is_status', '=', '2' )
                        ->Where('patient_id', '=', $patient_id )
            ->where('created_at', '>=', Carbon::today());
        $viewhb = LabHaemoglobin::all()->Where('is_status', '=', '2' )
                     ->Where('patient_id', '=', $patient_id )
                ->where('created_at', '>=', Carbon::today());
        $viewwbc = LabWhiteBloodCell::all()->Where('is_status', '=', '2' )
                     ->Where('patient_id', '=', $patient_id )
                ->where('created_at', '>=', Carbon::today());


        return view('laboratory.createLabComplete')->with([
            'lab'    => $lab,
            'pharm'    => $pharm,
            'viewpvc'    => $viewpvc,
            'lab_pvc'    => $lab_pvc,
            'lab_wbc'    => $lab_wbc,
            'viewhb'    => $viewhb,
            'viewwbc'    => $viewwbc,
            'lab_dwbc'    => $lab_dwbc,
            'viewdwbc'    => $viewdwbc,
            'lab_esr'    => $lab_esr,
            'viewesr'    => $viewesr,
            'lab_mp'    => $lab_mp,
            'viewmp'    => $viewmp,
            'lab_wt'    => $lab_wt,
            'viewmt'    => $viewmt,
            'lab_bg'    => $lab_bg,
            'viewbg'    => $viewbg,
            'lab_vdrl'    => $lab_vdrl,
            'viewvdrl'    => $viewvdrl,
            'lab_bm'    => $lab_bm,
            'viewvbm'    => $viewvbm,
            'lab_um'    => $lab_um,
            'viewum'    => $viewum,
            'lab_ua'    => $lab_ua,
            'viewua'    => $viewua,
            'lab_pt'    => $lab_pt,
            'viewpt'    => $viewpt,
            'lab_sa'    => $lab_sa,
            'viewsa'    => $viewsa,
              'lab_haemoglobin'    => $lab_haemoglobin,
            'departments' =>$departments,
        ]);

    }


    public function toLabPCV(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

      //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        Pvc::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'pcv' => $request['pcv'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('PCV Added Successfully! ');
    }


    public function toLabHB(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabHaemoglobin::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'hb' => $request['hb'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('PCV Added Successfully! ');
    }



    public function toLabWBC(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabWhiteBloodCell::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'wbc' => $request['wbc'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('PCV Added Successfully! ');
    }

    public function toLabDifferentialWBC(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabDiffWhiteBloodCell::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'dwbc' => $request['dwbc'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('PCV Added Successfully! ');
    }


    public function toLabESR(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabErythrocyteSedimentationRate::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'esr' => $request['esr'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('PCV Added Successfully! ');
    }

    public function toLabMalarialParasite(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabMalarialParasite::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'mp' => $request['mp'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('PCV Added Successfully! ');
    }

    public function toLabWidalTest(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabWidalTest::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'wt' => $request['wt'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('Widal Test Added Successfully! ');
    }

    public function toLabBloodGrouping(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabBloodGroup::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'bg' => $request['bg'],
            'bg2' => $request['bg2'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('Blood group added Successfully! ');
    }

    public function toLabVDRL(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabVDRL::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'vdrl' => $request['vdrl'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('VDRL added Successfully! ');
    }

    public function toLabBloodMicrofilaria(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabBloodMicrofilaria::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'bm' => $request['bm'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('VDRL added Successfully! ');
    }

    public function toLabUrineMicroscopy(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabUrineMicroscopy::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'um' => $request['um'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('Urine Microscopy added Successfully! ');
    }

    public function toLabUrinalysis(Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabUrinalysis::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'ua' => $request['ua'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('Urinalysis Test added Successfully! ');
    }



    public function toLabPregnancyTestUrine (Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabPregnacyTest::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'pt' => $request['pt'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('Pregnancy Test added Successfully! ');
    }

    public function toLabStoolAnalysis  (Request $request)
    {
//return $request->all();
        $user=Auth::user()->id;

        //  $lab_id = $request['lab_id'];
        $laboratory_id = $request['lab_id'];
        $patient_id = $request['patient_id'];

        LabStoolAnalysis::create([
            'is_status' => 2,
            'user_id' => $user,
            'laboratory_test_id' => $laboratory_id,
            'patient_id' => $patient_id,
            'sa' => $request['sa'],
            'note' => $request['note'],
        ]);

        return redirect('labresult-management')->withSuccessMessage('Stool Analysis  Test added Successfully! ');
    }





    public function toLabTest(Request $request)
    {

        $user = Auth::user()->id;
        $lab_id = $request['lab_id'];
        $laboratory_id = $request['laboratory_id'];
        $patient_id = $request['patient_id'];


        if ($lab_id == 1) {

            $counter = Pvc::all()->Where('patient_id', '=', $patient_id)
                ->Where('temperature', '=', '')->count();
            if ($counter == 0) {

                Pvc::create([
                    'is_status' => 1,
                    'user_id' => $user,
                    'laboratory_test_id' => $laboratory_id,
                    'patient_id' => $patient_id,

                ]);
                return redirect('labpvc');
            } else {

                return redirect('labpvc');
            }
        }


        if ($lab_id == 2) {

            $counter = LabHaemoglobin::all()->Where('patient_id', '=', $patient_id)
                ->Where('temperature', '=', '')->count();
            if ($counter == 0) {

                LabHaemoglobin::create([
                    'is_status' => 1,
                    'user_id' => $user,
                    'laboratory_test_id' => $laboratory_id,
                    'patient_id' => $patient_id,

                ]);

                return redirect('labhaemoglobin');
            } else {

                return redirect('labhaemoglobin');
            }
        }
    }

    public function getLabTestPVC()
    {
        $user=Auth::user()->id;
        $pvc = Pvc::all()->Where('is_status', '=', 1)
            ->Where('user_id', '=', $user);


        return view('laboratory.test.pvc')->with([
            'pvc' => $pvc
        ]);

    }

    public function storePVC(Request $request)
    {
        //
        $user=Auth::user()->id;
        $patient_id=$request['patient_id'];
        $inputPVC = [
            'is_status' => 2,
            'temperature' => $request['temperature'],
            'pulse' => $request['pulse'],
            'bloodpressure' => $request['bloodpressure'],
            'weight' => $request['weight'],
            'height' => $request['height'],
            'bloodgroup' => $request['bloodgroup'],
        ];
        Pvc::where('is_status', '=', 1)
            ->Where('user_id', '=', $user)
            ->Where('patient_id', '=', $patient_id)
            ->update($inputPVC);

        return redirect('labdotest-management');
    }

    public function getLabTestHaemoglobin()
    {
        $user=Auth::user()->id;
        $pvc = LabHaemoglobin::all()->Where('is_status', '=', 1)
            ->Where('user_id', '=', $user);


        return view('laboratory.test.haemoglobin')->with([
            'pvc' => $pvc
        ]);
    }

    public function storeHaemoglobin(Request $request)
    {
        //
        $user=Auth::user()->id;
        $patient_id=$request['patient_id'];
        $inputPVC = [
            'is_status' => 2,
            'temperature' => $request['temperature'],
            'pulse' => $request['pulse'],
            'bloodpressure' => $request['bloodpressure'],
            'weight' => $request['weight'],
            'height' => $request['height'],
            'bloodgroup' => $request['bloodgroup'],
        ];
        LabHaemoglobin::where('is_status', '=', 1)
            ->Where('user_id', '=', $user)
            ->Where('patient_id', '=', $patient_id)
            ->update($inputPVC);

        return redirect('labdotest-management');



    }

//
//    public function completeLabTest(Request $request)
//    {
//        $user=Auth::user()->id;
//        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
//            ->Where('attend_to', '=', 1 )->count();
//        $stat=$request['lab_id'];
//        $status_id = DB::table("laboratories")->where("id", "$stat")->pluck("status_id")->first();
//        $patient_id = DB::table("laboratories")->where("id", "$stat")->pluck("patient_id")->first();
//
//      //  if ($consultants == 0) {
//               $input = [
//                'laboratory' => 4,
//            ];
//            Status::where('id', "$status_id")
//                ->update($input);
//
////Please check this later
//            $inputLab = [
//                'is_status' => 4,
//            ];
//            Laboratory::where('status_id', "$status_id")
//                ->update($inputLab);
//
//
//            $input = ['attend_to' => 2,];
//            ConsultantAttendTo::where('patient_id', $patient_id)
//                ->where('attend_to', '1')
//                ->update($input);
//
//            return redirect('lab-management');// ->withSuccessMessage('Please check out before attend patient! ');
//
//            //     return redirect('lab-management')->withSuccessMessage('Lab Test Completed! ');
////        }
////        else
////        {
////            return redirect('lab-management')->withErrorMessage('Please check out before attend patient! ');
////
////
//////           return redirect('doc-management/create');
//////           Session::flash('error_message','You have one patient yet to attend!!!');
//////           return redirect('doc-management');
////        }
//    }
//

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $laboratory = Laboratory::findOrFail($id);
        $LabTest =  LaboratoryTest::where('laboratory_id', '=', $laboratory->id)
            ->Where('status', '=', 2)->get();
        $viewpvc =  Pvc::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewhb =  LabHaemoglobin::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewwbc =  LabWhiteBloodCell::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewdwbc =  LabDiffWhiteBloodCell::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewesr =  LabErythrocyteSedimentationRate::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewmp =  LabMalarialParasite::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewwt =  LabWidalTest::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewbg =  LabBloodGroup::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewvdrl =  LabVDRL::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewbm =  LabBloodMicrofilaria::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewum =  LabUrineMicroscopy::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewua =  LabUrinalysis::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewpt =  LabPregnacyTest::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
        $viewsa =  LabStoolAnalysis::where('patient_id', '=', $laboratory->patient_id)->orderBy('id', 'desc')->first();
//

//                return    $pcvs =  Pvc::where('laboratory_test_id', '=', $LabTest->id)->get();


        return view('laboratory.show', compact('laboratory','LabTest','viewpvc','viewhb','viewwbc',
            'viewdwbc','viewesr','viewmp','viewwt','viewbg','viewvdrl','viewum','viewua','viewpt','viewsa','viewbm'

            ));
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

        $lab = LaboratoryTest::findOrFail($id);

        $lab_id = DB::table("laboratory_tests")->where("id", "$lab->id")->pluck("laboratory_id")->first();
        $amount = DB::table("laboratory_tests")->where("id", "$lab->id")->pluck("amount")->first();

        $status = DB::table("laboratory_tests")->where("status", 0)
            ->where("id", "$lab->id")->pluck("id")->first();
//return $status;
        if ($status > 0) {

            $lab->delete();
            Session::flash('deleted_stock', 'The Cart has been deleted');

        } else {

            $laboratory = Laboratory::where('id', '=', $lab_id)->first();
            if ($laboratory) {
                $laboratory->decrement('amount', $amount);
            } else {
                // Stock::create($request->all());
            }

            $laboratory->delete();
            Session::flash('deleted_stock', 'The Cart has been deleted');

        }

        return redirect()->back()->withErrorMessage('Lab Test Deleted!');
    }



}
