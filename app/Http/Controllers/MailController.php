<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function send_basic_email()
    {
        $data = array('name'=> 'Gazi Adib');

       Mail::send(['text'=> 'mail'],$data ,function($message){
        $message->to('madjiguened835@gmail.com','Gazi Adib') ->subject('laravel youtube tutorial on email');
        $message->from('madjiguened835@gmail.com','Great Adib');
       });
       echo "Email is sent"; 
    }


//attachements

public function send_attach_email()
{
    $data = array('name'=> 'Gazi Adib');

   Mail::send('mail',$data ,function($message){
    $message->to('madjiguened835@gmail.com','Gazi Adib') ->subject('laravel youtube tutorial on email attachement');
    $message->attach("C:\Users\USER\Documents\Easymail\public\uploads\picture.png");
    $message->from('madjiguened835@gmail.com','Great Adib');
   });
   echo "Email is sent"; 
}

//basic HTML email

public function send_html_email()
{
    $data = array('name'=> 'Gazi Adib');

   Mail::send('mail',$data ,function($message){
    $message->to('madjiguened835@gmail.com','Gazi Adib') ->subject('laravel youtube tutorial on email');
    $message->from('madjiguened835@gmail.com','Great Adib');
   });
   echo "Email is sent"; 
}


}
