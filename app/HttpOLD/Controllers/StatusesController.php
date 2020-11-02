<?php

namespace App\Http\Controllers;

use App\ConsultantAttendTo;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        $statuses  = Status::paginate(5);
        $statuses = Status::where('checkout', '!=', '2')
           ->paginate(5);

        return view('status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCheckOut(Request $request)
    {

        $status_id=$request['status_id'];

        $input = [
            'checkout' => 2,
        ];
        Status::where('id', "$status_id")
            ->update($input);

        $input = [
            'attend_to' => 2,
        ];
        ConsultantAttendTo::where('status_id', "$status_id")
            ->update($input);


        return redirect('status-management')->withSuccessMessage('Dispensed Successfully! ');
    }



    public function create()
    {
        //
    }

    public function goToStatus()
    {
        //

        $user=Auth::user()->id;

        $patient_id = DB::table("consultant_attend_tos")->where("user_id", $user)
            ->where("attend_to", 1)->pluck("patient_id")->first();

        if ($patient_id == 0){
//            return redirect('admission-management');
            return redirect('status-management')->withErrorMessage('No awaiting patient');
        }


        $consultants = Status::Where('patient_id', '=', $patient_id )->orderBy('id', 'desc')->first();


           if ($consultants->pharmacy == 2){
               return redirect('shop-management');
           }
        if ($consultants->nurse == 2){
            return redirect('nurse-management/create');
        }

        if ($consultants->laboratory == 2){
            return redirect('lab-management/create');
        }

        if ($consultants->laboratory == 3){
            return redirect('lab-management/create');
        }
        if ($consultants->laboratory == 5){
            return redirect('labresult-management');
        }

        if ($consultants->consulting == 2){
            return redirect('doc-management/create');
        }

        if ($consultants->dental == 2){
            return redirect('dental-management');
        }

        if ($consultants->accounting == 2){
            return redirect('accounting-management');
        }

        if ($consultants->antenatal == 2){
            return redirect('antenateal-management');
        }

        if ($consultants->admission == 2){
            return redirect('admission-management');
        }

        if ($consultants->count()==0){

            return redirect('status-management')->withErrorMessage('No awaiting patient');

        }


//            ->Where('attend_to', '=', 1 )->count();
     //   $products = LabFee::select(DB::raw('concat (name," ",code) as full_name,id'))->orderBy('name')->pluck('full_name', 'id');

//        $lab_haemoglobin = LabHaemoglobin::Where('is_status', '=', '2' )
//            ->Where('user_id', '=', $user)->orderBy('laboratory_test_id', 'desc')->pluck('laboratory_test_id')->first();

        return redirect('status-management')->withErrorMessage('Something went wrong');

    }

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
    }
}
