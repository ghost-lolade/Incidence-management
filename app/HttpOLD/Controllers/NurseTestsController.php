<?php

namespace App\Http\Controllers;

use App\ConsultantAttendTo;
use App\Department;
use App\NurseTest;
use App\Sale;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NurseTestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $statuses = Status::all()->where("nurse",1);
        //   return view('shop/proceed');

        $nurses= NurseTest::all()->sortByDesc("created_at");

      //  $nurses= NurseTest::paginate(5);
        return view('nurses.index', compact('nurses','statuses'));
    }

    public function toNurse(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();

        if ($consultants == 0){
            // return $request->all();
            $status_id=$request['status_id'];
            $input = [
                'nurse' => 2,
            ];
            Status::where('id', "$status_id")
                ->update($input);

            $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();
          //  $consultant_id = DB::table("statuses")->where("id", "$status_id")->pluck("consultant_id")->first();

            ConsultantAttendTo::create([
                'patient_id' => $patient_id,
                'user_id' => $user,
                'attend_to' => '1',
                'status_id' => $request['status_id'],
            ]);

//            $inputPham = ['user_id' => $user, 'is_status' => 1,];
//            NurseTest::where('consultant_id', "$consultant_id")
//                ->where('patient_id', "$patient_id")
//                ->update($inputPham);

            return redirect('nurse-management/create');
        } else
        {
            return redirect('nurse-management')->withErrorMessage('Please check out before attend to next patient! ');

//            return redirect('doc-management');
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {
        //
        $user=Auth::user()->id;
        $statuses = ConsultantAttendTo::all()->Where('user_id', '=', $user)
            ->Where('attend_to', '=', 1);
//        $sales = SaleProduct::all()->Where('status', '=', '0' )
//            ->Where('user_id', '=', $user);

        $departments=Department::all();
        return view('nurses/create',['departments' => $departments,
            'statuses' => $statuses]);
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
       // return $request->all();
        NurseTest::create($request->all());
        $user=Auth::user()->id;
        $input = [
            'attend_to' => 2,
        ];
        ConsultantAttendTo::where('user_id', $user)
            ->Where('attend_to', 1)
            ->update($input);

        if ($request['department'] == '1') {

            $input = [
                'nurse' => 1,

            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);

        }

        if ($request['department'] == '2') {

            $input = [
                'dental' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);

        }

        if ($request['department'] == '3') {

            $input = [
                'laboratory' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);
        }

        if ($request['department'] == '4') {

            $input = [
                'consulting' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);
        }

        if ($request['department'] == '5') {


            $input = [
                'pharmacy' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);
        }

        if ($request['department'] == '6') {

            $input = [
                'accounting' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);
        }

        if ($request['department'] == '7') {

            $input = [
                'gynaecology' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);
        }

        if ($request['department'] == '8') {

            $input = [
                'antenatal' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);

        }

        if ($request['department'] == '9') {

            $input = [
                'physiotherapy' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);

        }

        if ($request['department'] == '10') {

            $input = [
                'cardiology' => 1,
                'nurse' => 3,
            ];
            Status::where('patient_id', $request['patient_id'])
                ->Where('nurse', 2)
                ->update($input);
        }

        return redirect('nurse-management');


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
        $nurse = NurseTest::find($id);
        return view('nurses/edit', ['nurse' => $nurse]);
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

        $nurse = NurseTest::findOrFail($id);
        $input = [
            'bloodgroup' => $request['bloodgroup'],
            'height' => $request['height'],
            'weight' => $request['weight'],
            'bloodpressure' => $request['bloodpressure'],
            'pulse' => $request['pulse'],
            'temperature' => $request['temperature'],

        ];
        $this->validate($request, [
            'temperature' => 'required',


        ]);
        NurseTest::where('id', $id)
            ->update($input);

        return redirect()->intended('nurse-management');






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
        $nurse = NurseTest::findOrFail($id);
        $nurse->delete();
       // Session::flash('deleted_stock', 'Successfully deleted');
        return redirect('nurse-management')->withSuccessMessage('Successfully deleted! ');

    }
}
