<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\CreateInvoiceRequest;



use App\Http\Requests;
use App\Invoice;
use App\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use Excel;
use Auth;
use PDF;




class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')
            ->paginate(8);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(CreateInvoiceRequest $request)
    {
//        return $result;
//        return $request->all();


        $quantity = $request['quantity'];
        $counter = count($quantity);
      //  return $counter;
      //  $array = array();
        $total_sum=0;
       FOR  ($i = 0; $i < $counter; ++$i)
        {
            $total_sum += $request['quantity'][$i]*$request['unit_price'][$i];
        }
//        $sumUnitPrice = array_sum($request['unit_price']);
//      return $sumUnitPrice;
        $grand_total = $total_sum - $request['discount'];
        $tax = $grand_total * 0.05;
  $lastInvoiceNO = Invoice::orderBy('id', 'desc')->value("invoice_no");
        $lastInvoiceNO++;
        $wht= 'WHT Pending';
        $status= 'Invoice Pending';
      //  $lastInvoiceID = 2000001;
        Invoice::create([

            'invoice_no' => $lastInvoiceNO,
            'invoice_date' => $request['invoice_date'],
            'discount' => $request['invoice_date'],
            'due_date' => $request['due_date'],
            'title' => $request['title'],
            'client' => $request['client_name'],
            'client_address' => $request['client_address'],
            'sub_total' => $total_sum,
            'status' => $status,
            'wht' => $wht,
            'discount' => $request['discount'],
            'banker' => $request['banker'],
            'contact_person' => $request['contact_person'],
            'grand_total' => $grand_total,
            'tax' => $tax,
        ]);

        $lastInvoiceID = Invoice::orderBy('id', 'desc')->value("id");
        for ($i = 0; $i < $counter; ++$i) {
            InvoiceProduct::create([

                'invoice_id' => $lastInvoiceID,
                'name' => $request['part_name'][$i],
                'qty' => $request['quantity'][$i],
                'price' => $request['unit_price'][$i],
                'total' => $request['unit_price'][$i] * $request['quantity'][$i],

            ]);

        }
       // return view('invoices');
        return redirect()
            ->route('invoices.index');
    }
////
    public function show($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    public function getPDF(Request $request,$id){
//        $student = Invoice::findOrFail($id);
        $invoice = Invoice::with('products')->findOrFail($id);
//        $companyAddress = DB::table("company_account")->where("id", 1)->pluck("address")->first();
        $pdf = PDF::loadView('invoices.pdf',['invoice' => $invoice]);
        return $pdf->stream('pdf.pdf', array('Attachment'=>0));
    }




//    public function pdfview($id)
//    {
////        $invoices = Invoice::with('products')->all();
//        $invoices = Invoice::with('products')->findOrFail($id);
////        $invoices = Invoice::all();
//        view()->share('invoices',$invoices);
////        if($request->has('download')){
//            $pdf = PDF::loadView('pdfview');
//            return $pdf->download('pdfview');
////        }
//        return view('invoices.show', compact('invoices'));
//    }






    public function edit($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'invoice_no' => 'required|alpha_dash|unique:invoices,invoice_no,'.$id.',id',
            'client' => 'required|max:255',
            'client_address' => 'required|max:255',
            'invoice_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'title' => 'required|max:255',
            'discount' => 'required|numeric|min:0',
            'products.*.name' => 'required|max:255',
            'products.*.price' => 'required|numeric|min:1',
            'products.*.qty' => 'required|integer|min:1'
        ]);

        $invoice = Invoice::findOrFail($id);

        $products = collect($request->products)->transform(function($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });

        if($products->isEmpty()) {
            return response()
                ->json([
                    'products_empty' => ['One or more Product is required.']
                ], 422);
        }

        $data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $invoice->update($data);

        InvoiceProduct::where('invoice_id', $invoice->id)->delete();

        $invoice->products()->saveMany($products);

        return response()
            ->json([
                'updated' => true,
                'id' => $invoice->id
            ]);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        InvoiceProduct::where('invoice_id', $invoice->id)
            ->delete();

        $invoice->delete();

        return redirect()
            ->route('invoices.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        // $this->validateInput($request);
        $input = [
            'status' => $request['status'],
            'invoice_at' => Carbon::now(),
//            'status' => 'PAID',

        ];

       // $this->validateInput($request, $input);
        Invoice::where('id', $invoice->id)
            ->update($input);

        return redirect()
            ->route('invoices.index');
    }

    public function updateWHT(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        // $this->validateInput($request);
        $input = [
            'wht' => $request['wht'],
            'wht_at' => Carbon::now(),
//            'status' => 'PAID',

        ];

        // $this->validateInput($request, $input);
        Invoice::where('id', $invoice->id)
            ->update($input);

        return redirect()
            ->route('invoices.index');
    }














    public function htmltopdfview(Request $request )
    {
//        $invoices = Invoice::with('products')->all();
        $invoices = Invoice::all();
        view()->share('invoices',$invoices);
        if($request->has('download')){
            $pdf = PDF::loadView('htmltopdfview.pdf');
            return $pdf->download('htmltopdfview.pdf');
        }
        return view('invoices.htmltopdfview');
    }




}
