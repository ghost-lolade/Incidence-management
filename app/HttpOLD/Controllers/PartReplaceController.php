<?php

namespace App\Http\Controllers;

use App\PartReplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartReplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $atmparts = PartReplace::Where('delete_by', '=', '')->get();

        return view('partreplaced.index', compact('atmparts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user()->id;

        return view('partreplaced.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request->all();
        $user = Auth::user()->id;

        PartReplace::create([
            'terminal_id' => $request['terminalid'],
            'atm_name' => $request['atmname'],
            'part_name' => $request['part_name'],
            'price' => $request['price'],
            'invoice_no' => $request['invoice_no'],
            'date' => $request['date'],
            'supplier_by' => $request['supplier_by'],
            'approved_by' => $request['approved_by'],
            'user_id' => $user,

        ]);

        return redirect()->intended('partreplace-management');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $atmpart = PartReplace::find($id);
        return view('partreplaced/edit', ['atmpart' => $atmpart]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user()->id;
        $input = [
            'terminal_id' => $request['terminalid'],
            'atm_name' => $request['atmname'],
            'part_name' => $request['part_name'],
            'price' => $request['price'],
            'invoice_no' => $request['invoice_no'],
            'date' => $request['date'],
            'supplier_by' => $request['supplier_by'],
            'approved_by' => $request['approved_by'],
            'user_id' => $user,
        ];


        PartReplace::where('id', $id)
            ->update($input);

        return redirect()->intended('/partreplace-management');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        //THIS IS USE TO ACCEPT STATUS FROM VENDOR
//        $user=Auth::user()->username;
//        $atmpart = PartReplace::findOrFail($id);
//        Brand::where('id', $id)->delete();
//      //  $atmpart=PartReplace::Where('id', '=', $id)->pluck('id');
//
//        // return $open[0];
//
//        $atmpart->delete_by =$user;
//        $atmpart->deleted_at = date('Y-m-d H:i:s');
//
//        $atmpart->save();
//        return response()->json($atmpart);
//


    public function destroy($id)
    {
        $user=Auth::user()->username;

        $input = [
            'delete_by' => $user,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];


        PartReplace::where('id', $id)
            ->update($input);
        return redirect()->intended('/partreplace-management');



//        //THIS IS USE TO ACCEPT STATUS FROM VENDOR
//        $atmparts = PartReplace::findOrFail($id);
//
//
//        $open = PartReplace::Where('id', '=', $id)->pluck('delete_by');
//
//        // return $open[0];
//
//        if ($open[0] = '') {
//            $atmparts->delete_by = $user;
//            $atmparts->deleted_at = date('Y-m-d H:i:s');
//
//            $atmparts->save();
//            return response()->json($atmparts);
//        } else
//            $atmparts->delete_by = $user;
//        $atmparts->deleted_at = date('Y-m-d H:i:s');
//
//        $atmparts->save();
        return response()->json($atmparts);
    }

}