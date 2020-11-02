<?php

namespace App\Mail;

use App\Brand;
use App\CallLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
class VendorLogCallMail extends Mailable

{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $username = Auth::user()->username;
        $when = Carbon::now();
        
          $atmreport = DB::table('call_logs')->latest()->first();


        $subject =  $atmreport->terminal_id .': '. $atmreport->subject . ' ' . Carbon::now();


        return $this->view('mails.logcallmail', compact('atmreport'))
            ->subject($subject);


//        return view('atmreport.index', compact('atmreports'));
    }

/*
        $countvendor= Brand::Where('id', '!=', 0)
            ->count();
        for ($i = 0; $i < $countvendor+1; ++$i){
            echo  $i;

                $atmreports = CallLog::Where('vendor_request_status', '=', 'Open')
                 ->where('created_at', '<', Carbon::now()->subMinutes(1)->toDateTimeString())
                ->Where('vendor_id', '=', $i)
                ->orderBy('created_at', 'desc')->get();

            $subject =  'Open Incidence ' . '-' . Carbon::now();


            return $this->view('mails.logcallmail', compact('atmreports'))
                ->subject($subject);
        }

*/

//        $atmreports = CallLog::Where('vendor_request_status', '=', 'Open')
//            ->where('created_at', '<', Carbon::now()->subMinutes(1)->toDateTimeString())
//            //->Where('call_closer_username', '=', $username)
//            ->orderBy('created_at', 'desc')->get();
//
//        return $this->view('mails.logcallmail', compact('atmreports'))
//            ->subject($subject);


//        return view('atmreport.index', compact('atmreports'));
    }







