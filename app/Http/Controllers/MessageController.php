<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Message;

class MessageController extends Controller
{
    public function SendView($username = null){
      $user = Auth::user();
      $recipient = User::where('username',$username)->first();
      return view('message.send')->with([
        'recipient' => $recipient
      ]);
    }

    public function SendPost(Request $request){
      if ($request->recipient == null) {
         session()->flash('errormessage','You must enter recipient\'s username');
         return redirect()->back()->withInput();
      }
      if ($request->text == null) {
         session()->flash('errormessage','You must send something');
         return redirect()->back()->withInput();
      }
      if ($request->title == null) {
         session()->flash('errormessage','You must enter title');
         return redirect()->back()->withInput();
      }
      $recipient = User::where('username',$request->recipient)->first();
      if ($recipient == null) {
        session()->flash('errormessage','User with that username does not exist');
        return redirect()->back()->withInput();
      }
      if ($recipient->id == Auth::user()->id) {
        session()->flash('errormessage','You cannot send message to yourself');
        return redirect()->back()->withInput();
      }
      $last_msg = Message::where('from',Auth::user()->id)->orderBy('created_at','desc')->first();
      if ($last_msg !== null) {
        $newTime = date("Y-m-d H:i:s",time());
        if (Auth::user()->vendor == false) {
          $last_time = date('Y-m-d H:i:s',strtotime('+1 minute',strtotime($last_msg->created_at)));
          if ($newTime < $last_time) {
            session()->flash('errormessage','You can send message every minute');
            return redirect()->back()->withInput();
          }
        } else {
          $last_time = date('Y-m-d H:i:s',strtotime('+10 seconds',strtotime($last_msg->created_at)));
          if ($newTime < $last_time) {
            session()->flash('errormessage','You can send message every ten seconds');
            return redirect()->back()->withInput();
          }
        }
      }

      $m = new Message;
      $m->uniqueid = 'ME'.str_random(28);
      $m->to = $recipient->id;
      $m->from = Auth::user()->id;
      $m->title = $request->title;
      $m->text = $request->text;
      $m->save();
      return redirect()->route('messages');
    }

    public function ViewReceived(){
      $received = Message::where('to',Auth::user()->id)->orderBy('created_at','desc')->paginate(25);
      return view('message.received')->with([
        'received'=>$received
      ]);
    }

    public function ViewSent(){
      $sent = Message::where('from',Auth::user()->id)->orderBy('created_at','desc')->paginate(25);
      return view('message.sent')->with([
        'sent'=>$sent
      ]);
    }
    public function ViewMessage($uniqueid){
      $message = Message::where('uniqueid',$uniqueid)->first();
      if ($message == null) {
        return redirect()->route('messages');
      }
      if (Auth::user()->id !== $message->to && Auth::user()->id !== $message->from) {
          return redirect()->route('messages');
      }
      if ($message->viewed == false && Auth::user()->id == $message->to) {
         $message->viewed = true;
         $message->save();
      }
      return view('message.view')->with([
         'message'=>$message
      ]);
    }
}
