<?php

namespace App\Http\Controllers;

use App\ConsultantAppointment;
use App\Patient;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultantAppointmentController extends Controller
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
       // $suppliers = Status::all()->where("consulting",1);
        //$statuses= Status::where("department_id",3)->all();
        $appoints= ConsultantAppointment::get();


        return view('appointment.index', compact('appoints', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
      $patient=  Patient::all();
        return view('appointment/create', compact('patient') );
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
     //   return $request->all();
        $user = Auth::user()->id;

        ConsultantAppointment::create([
            'patient_id' => $request['patient_id'],
            'subject' => $request['subject'],
            'scheduler_date' => $request['scheduler_date'],
            'schedule_notes' => $request['schedule_notes'],
            'user_id' => $user
        ]);

        return redirect('appointment-management');
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
        $appoint = ConsultantAppointment::find($id);

        return view('appointment/edit', ['appoint' => $appoint]);
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
       // return $request->all();
        $user = Auth::user()->id;

     //   $appoint = ConsultantAppointment::findOrFail($id);
        // $this->validateInput($request);
        $appoint = [
            'subject' => $request['subject'],
            'scheduler_date' => $request['scheduler_date'],
            'schedule_notes' => $request['schedule_notes'],
            'user_id' => $user
        ];

       // $this->validateInput($request, $appoint);
        ConsultantAppointment::where('id', $id)
            ->update($appoint);

        return redirect()->intended('/appointment-management');

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
        ConsultantAppointment::where('id', $id)->delete();
        return redirect()->intended('/appointment-management');
    }


    private function validateInput($request) {
        $this->validate($request, [


            'subject' => 'required|max:60',
            'scheduler_date' => 'required|',
            'schedule_notes' => 'required|max:60',
            'user_id' => 'required|max:60',


        ]);
    }
}
