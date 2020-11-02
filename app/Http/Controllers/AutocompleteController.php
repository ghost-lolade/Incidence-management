<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('autocomplete/index');

        return view('autocomplete/auto');

    }

    public function index2()
    {
        return view('autocomplete/index2');

    }

    public function searchResponse(Request $request){
        $query = $request->get('term','');
        $countries=\DB::table('products');
        if($request->type=='countryname'){
            $countries->where('name','LIKE','%'.$query.'%')->limit(10);
        }
        if($request->type=='country_code'){
            $countries->where('sortname','LIKE','%'.$query.'%');
        }
        $countries=$countries->get();
        $data=array();
        foreach ($countries as $country) {
            $data[]=array('name'=>$country->name,'sortname'=>$country->sortname);
        }
        if(count($data))
            return $data;
        else
            return ['name'=>'','sortname'=>''];
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function ajax(Request $request)
//    {
//        $row_num = $request->get('row_num');
//        $name = $request->get('name_startsWith');
//        $query = Country::where('name_startsWith', 'LIKE', '%'.$name.'%')->get();
//        return response()->json($query);
//    }




public function create()
    {
        //
      //  return view('autocomplete/create');
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
