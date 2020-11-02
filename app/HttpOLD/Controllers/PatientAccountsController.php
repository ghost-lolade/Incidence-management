<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
        $pharm = ConsultantPhamacy::all()->Where('user_id', '=', $user)
            ->Where('is_status', '=', 1);
        $sales = Sale::all()->Where('is_status', '=', '1' )
            ->Where('user_id', '=', $user);
// $sales = Sale::all()->Where('is_status', '=', '1' )
//            ->Where('user_id', '=', $user);

        return view('account.create')->with([
            'sales'    => $sales,
            'pharm'    => $pharm,
            'statuses'    => $statuses,
        ]);
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
