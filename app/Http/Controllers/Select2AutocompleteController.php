<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Select2AutocompleteController extends Controller
{
    /**
     * Show the application layout.
     *
     * @return \Illuminate\Http\Response
     */
    public function layout()
    {
        return view('categories/select2');
    }

    /**
     * Show the application dataAjax.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataAjax(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("categories")
                ->select("id","name")
                ->where('name','LIKE',"%$search%")
                ->get();
        }

        return response()->json($data);
    }
}