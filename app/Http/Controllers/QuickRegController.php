<?php

namespace App\Http\Controllers;

use App\QuickReg;
use Illuminate\Http\Request;

use App\Department;
use App\Http\Requests\PatientsCreateRequest;
use App\Patient;
use App\Status;
use App\City;
use App\State;
use App\Country;
use App\Insurance;
use Illuminate\Support\Facades\DB;


class QuickRegController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients= Patient::Where("patient_type","=", "quick")->paginate(5);


        return view('quickreg.index', compact('patients'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $insurances = Insurance::all();
//        $statuses = Status::all();
        $departments = Department::all();
//        $departments = Department::orderBy('name', 'desc')->value("id");
        //    $divisions = Division::all();
//  return view('patients/create');
        return view('quickreg/create');

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
        $quick=  Patient::create($request->all());
        $quick_id = $quick->id;

        if ($request['department'] == '1') {
            Status::create([
                'patient_id' => $quick_id,
                'laboratory' => '1'
            ]);
        }
        return redirect('/quickreg-management');
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
