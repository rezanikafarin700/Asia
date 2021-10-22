<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function mail()
    {
        $data = [];
        Mail::send([], $data, function (Message $message) {
            $message->to('rezanikafarin700@gmail.com', 'reza nikafarin')
                ->from('rezanikafarin700@gmail.com', 'Taj-Sport')
                ->subject('Test Email');
        });
        dd('gmail');
    }

    public function mail1()
    {
        $data = [];
        Mail::send(['html' => 'emails.mail'],$data,function (Message $message){
            $message
                ->to('rezanikafarin700@gmail.com','Salam Reza Nikafarin')
                ->from('rezanikafarin700@gmail.com','Self Reza Nikafarin')
                ->subject('Test Mail from Reza Program');
        });
        dd('mail');
    }
}
