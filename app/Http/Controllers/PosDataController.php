<?php

namespace App\Http\Controllers;

use App\PosData;
use Illuminate\Http\Request;
use App\CallLog;
use Session;
use Illuminate\Support\Facades\Auth;

class PosDataController extends Controller
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
        $vendor_id=Auth::user()->usertype;
        if( $vendor_id==0){
        $atmreports= PosData::all()->sortByDesc("created_at");

        return view('bankdata.index', compact('atmreports'));

        }
        else
            $atmreports = PosData::Where('vendor_id', '=', $vendor_id)->get();
        return view('bankdata.index', compact('atmreports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\PosData  $posData
     * @return \Illuminate\Http\Response
     */
    public function show(PosData $posData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PosData  $posData
     * @return \Illuminate\Http\Response
     */
    public function edit(PosData $posData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PosData  $posData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosData $posData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PosData  $posData
     * @return \Illuminate\Http\Response
     */
    public function destroy(PosData $posData)
    {
        //
    }
}
