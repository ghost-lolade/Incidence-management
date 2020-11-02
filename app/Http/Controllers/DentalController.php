<?php

namespace App\Http\Controllers;

use App\Consultant;
use App\ConsultantAppointment;
use App\ConsultantAttendTo;
use App\Dental;
use App\Laboratory;
use App\LaboratoryTest;
use App\NurseTest;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DentalController extends Controller
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


    public function index()
    {
        //
        $statuses = Status::all()->where("dental",1);
        // $suppliers = Status::all()->where("consulting",1);
        //$statuses= Status::where("department_id",3)->all();
        $appoints= Dental::get();


        return view('dental.index', compact('appoints', 'statuses'));
    }


    public function toBeAttendedTo(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
        if ($consultants == 0){

            // return $request->all();
            $status_id=$request['status_id'];
            $input = [
                'dental' => 2,
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
            return redirect('dental-management/create');
        } else
        {
            return redirect('dental-management')->withErrorMessage('You have one patient form yet to commplete! ');

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
        //
        $user=Auth::user()->id;
       // $patient=  Dental::all();
        $patient_id = DB::table("consultant_attend_tos")->where("user_id", $user)
            ->where("attend_to", 1)->pluck("patient_id")->first();

         $nurses = NurseTest::Where('patient_id', '=', $patient_id)->orderBy('created_at', 'desc')->first();
        $pastconsults = Consultant::Where('patient_id', '=', $patient_id)
            ->orderBy('created_at', 'desc')->get();

        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user)
            ->Where('attend_to', '=', 1);


        $lab = Laboratory::Where('patient_id', '=', $patient_id)->first();
        //    return   $lab->id;
        if ($lab != '') {

            $LabTests = LaboratoryTest::Where('laboratory_id', '=', $lab->id)->orderBy('created_at', 'desc')->get();
            return view('dental.create', compact('consultants', 'nurses', 'pastconsults', 'LabTests' ));
        } else {
            return view('dental.create', compact('consultants', 'nurses', 'pastconsults', 'LabTests','lab'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      return  $request->all();
        $user = Auth::user()->id;

        $lastInsertedId=    Dental::create([
            'patient_id' => $request['patient_id'],
            'subject' => $request['subject'],
            'scheduler_date' => $request['scheduler_date'],
            'schedule_notes' => $request['schedule_notes'],
            'user_id' => $user
        ]);

        if ($request['scheduler_date'] != '') {
            ConsultantAppointment::create([
                'consultant_id' => $lastInsertedId,
                'patient_id' => $request['patient_id'],
                'scheduler_date' => $request['scheduler_date'],
                'schedule_notes' => $request['schedule_notes'],
                'user_id' => $request['user_id']
            ]);
        }
        $to_attend = $request['to_attend'];
        $input = [
            'attend_to' => 2,
        ];
        ConsultantAttendTo::where('id', "$to_attend")
            ->update($input);

        $status_id = $request['status_id'];
        $input = [
            'dental' => 2,
        ];
        Status::where('id', "$status_id")
            ->update($input);

        return redirect('dental-management');
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
        $appoint = Dental::find($id);

        return view('dental/edit', ['appoint' => $appoint]);
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
        $user = Auth::user()->id;

        //   $appoint = Dental::findOrFail($id);
        // $this->validateInput($request);
        $appoint = [
            'subject' => $request['subject'],
            'scheduler_date' => $request['scheduler_date'],
            'schedule_notes' => $request['schedule_notes'],
            'user_id' => $user
        ];

        // $this->validateInput($request, $appoint);
        Dental::where('id', $id)
            ->update($appoint);

        return redirect()->intended('/dental-management');
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
        Dental::where('id', $id)->delete();
        return redirect()->intended('/dental-management');
    }
}
