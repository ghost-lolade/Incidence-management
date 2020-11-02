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
class SuspendMail extends Mailable
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
       // $subject = 'Suspend Call ' . '-' . $when;
        $atmreports = CallLog::Where('suspend_comment', '!=', '')
        ->orderBy('updated_at', 'desc')->limit(1)->get();

        $subject =  $atmreports[0]->terminal_id .':'. $atmreports[0]->request_status  . '---' . $atmreports[0]->suspend_day . ' at '. $atmreports[0]->suspend_time;
//
        return $this->view('mails.suspendcallmail', compact('atmreports'))
//        return $this->view('incidence_status.suspendcallmail', compact('atmreports'))
            ->subject($subject);


//        return view('atmreport.index', compact('atmreports'));
    }
}



