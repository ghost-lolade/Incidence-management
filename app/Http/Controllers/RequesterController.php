<?php

namespace App\Http\Controllers;

use App\BankData;
use App\Requester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequesterController extends Controller
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
        $vendor_id=Auth::user()->user_no;
        $cedatas= Requester::get();
        return view('requester.index', compact('cedatas'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requester/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //  $vendor_id=Auth::user()->user_no;

        Requester::create([
            'name' => $request['name'],
            'requester_phone' => $request['mobile'],
            'email' => $request['email_address'],
           // 'vendor_id' => $vendor_id,
            'requester_dept' => $request['requester_dept'],
         //   'state' => $request['state'],
             ]);
       // CustomerEngineer::create($request->all());

        return redirect()->intended('requester-management');


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
        $cedata = Requester::findOrFail($id);

        return view('requester.show', compact('cedata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cedata = Requester::find($id);
        // Redirect to user list if updating user wasn't existed


        return view('requester/edit', ['cedata' => $cedata]);


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
        $input = [
            'name' => $request['name'],
            'requester_phone' => $request['mobile'],
            'email' => $request['email'],
            // 'vendor_id' => $vendor_id,
            'requester_dept' => $request['requester_dept'],
        ];

        Requester::where('id', $id)
            ->update($input);
        return redirect()->intended('requester-management');
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
