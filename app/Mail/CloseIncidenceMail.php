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
class CloseIncidenceMail extends Mailable
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

        $atmreports = CallLog::Where('vendor_request_status', '=', 'Closed')
            ->Where('call_closer_username', '=', $username)
            ->orderBy('updated_at', 'desc')->limit(1)->get();
//            ->latest('updated_at')
//            ->first();

 $subject =  $atmreports[0]->terminal_id .': '. $atmreports[0]->subject;
    //    $subject =  $atmreports[0]->terminal_id .':'. $atmreport->subject ;
//        $atmreports=  CallLog::latest('datetime')->first();
//            ->order_by('updated_at', 'desc')
//            ->limit(1)->get();


        return $this->view('mails.closedcallmail', compact('atmreports'))
            ->subject($subject);


//        return view('atmreport.index', compact('atmreports'));
    }
}



