<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/brand-management';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate(5);

        return view('brands/index', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
        Brand::create([
            'name' => $request['name']
        ]);

      //  return back()->with('success','Item created successfully!');

     return redirect('vendor-management')->with('success','Item created successfully!');

       // return redirect()->intended('/vendor-management');
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
        $brand = Brand::find($id);
        // Redirect to user list if updating user wasn't existed
//        if ($brand == null || count($brand) == 0) {
//            return redirect()->intended('/brands-management');
//        }

        return view('brands/edit', ['brands' => $brand]);
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
        $brands = Brand::findOrFail($id);
        // $this->validateInput($request);
        $input = [
            'name' => $request['name']
        ];

        $this->validateInput($request, $input);
        Brand::where('id', $id)
            ->update($input);

        return redirect()->intended('/vendor-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::where('id', $id)->delete();
        return redirect()->intended('/vendor-management');
    }

    /**
     * Search supplier from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name'],
            'contact_name' => $request['contact_name'],
            'country' => $request['country'],
            'state' => $request['state']
        ];

        $brands = $this->doSearchingQuery($constraints);
        return view('brands/index', ['brands' => $brands, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Brand::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
            'name' => 'required|max:120'


        ]);
    }
}
