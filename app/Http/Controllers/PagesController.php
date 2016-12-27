<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller {

    public function getIndex() {
        $posts = Post::orderBy('created_at', 'DESC')->limit(4)->get();
        return view('pages.welcome')->with('posts', $posts);
    }

    public function getAbout() {
        $first = "Alex";
        $last = "Curtis";

        $full = $first . ' ' . $last;
        $email = 'jidemustapha2013@gmail.com';

        $data = [];
        $data['fullname'] = $full;
        $data['email'] = $email;

        return view('pages.about')->withData($data);
    }

    public function getContact() {
        return view('pages.contact');
    }

    public function postContact(Request $request) {

        $this->validate($request, [
           'email' => 'required | email',
            'subject' => 'min:3',
            'message' => 'min:10'
        ]);

        $data = [
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message,
        ];

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('jidemustapha2013@gmail.com');
            $message->subject($data['bodyMessage']);
        });

        Session::flash('success', 'Your email was sent');

        return redirect('contact');

    }

}