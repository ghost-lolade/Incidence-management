<?php

namespace App\Mail;

use App\CallLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class LogCallMail extends Mailable
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

    //    $atmreports = CallLog::Where('vendor_request_status', '=', 'Open')
      //      ->where('created_at', '<', Carbon::now()->addMinutes(1)->toDateTimeString())->orderBy('created_at', 'desc')->get()->first();
         
         
              $atmreport = DB::table('call_logs')->latest()->first();


        $subject =  $atmreport->terminal_id .': '. $atmreport->subject . ' ' . Carbon::now();
//        $atmreports=  CallLog::latest('datetime')->first();
//            ->order_by('updated_at', 'desc')
//            ->limit(1)->get();


        return $this->view('mails.logcallmail', compact('atmreport'))
            ->subject($subject);


//        return view('atmreport.index', compact('atmreports'));
    }
}







