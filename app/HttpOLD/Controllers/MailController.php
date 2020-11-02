<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\mail\sendMail;

class MailController extends Controller
{
    //
	public function send()
	{
		//Mail::send(new SendMail());
		Mail::send(['text'=>'mail'],['name','Stephen'], function($message){
			$message->to('oladejisteven@gmail.com', 'To Stevo')->subject('Test Email');
			$message->from('helpdesk@gmail.com', 'Steve Baba');
		});
	}
	
	public function email()
	{
		return view('email');
	}
	
}
