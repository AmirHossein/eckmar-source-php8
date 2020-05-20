<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use Auth;
use App\User;
use App\Dispute;
use App\DisputeReply;
use App\Settings;
class DisputeController extends Controller
{
    public function Create($uniqueid){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null) {
         return redirect()->route('purchases');
      }

      if (Auth::user()->id !== $sale->buyer->id) {
        return redirect()->route('purchases');
      }

      if ($sale->state !== 1) {
        return redirect()->route('purchases');
      }

      return view('dispute.create')->with([
        'sale'=>$sale
      ]);
    }

    public function CreatePost($uniqueid,Request $request){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null) {
         return redirect()->route('purchases');
      }

      if (Auth::user()->id !== $sale->buyer->id) {
        return redirect()->route('purchases');
      }

      if ($sale->state !== 1) {
        return redirect()->route('purchases');
      }
      if ($request->message == null) {
        session()->flash('errormessage','You must describe your problem');
        return redirect()->back();
      }

      $dispute = new Dispute;
      $dispute->uniqueid = 'DI'.str_random(28);
      $dispute->purchase_id = $sale->id;
      $dispute->seller_id = $sale->seller->id;
      $dispute->buyer_id = $sale->buyer->id;
      $dispute->save();

      $dr = new DisputeReply;
      $dr->uniqueid = 'DR'.str_random(28);
      $dr->user_id = Auth::user()->id;
      $dr->dispute_id = $dispute->id;
      $dr->message = $request->message;
      $dr->save();
      $sale->state = 3;
      $sale->save();
      return redirect()->route('purchases');
    }
    public function Resolved(){
      if(!session()->has('resolved')){
        return redirect()->back();
      }
      return view('dispute.resolved');
    }
    public function View($uniqueid){
      $dispute = Dispute::where('uniqueid',$uniqueid)->first();
      if ($dispute == null) {
        return redirect()->route('purchases');
      }
      if ($dispute->resolved == true && Auth::user()->admin == false) {
          session()->flash('resolved',true);
         return redirect()->route('resolved');
      }
      if (Auth::user()->id !== $dispute->seller->id && Auth::user()->id !== $dispute->buyer->id ) {
          if (Auth::user()->admin == false) {
              return redirect()->route('purchases');
          }
      }

      $purchase = $dispute->purchase;
      $replies = $dispute->replies;
      return view('dispute.view')->with([
        'purchase'=>$purchase,
        'replies'=>$dispute->replies,
        'dispute'=>$dispute
      ]);
    }
    public function AddReply($uniqueid,Request $request){

      $dispute = Dispute::where('uniqueid',$uniqueid)->first();
      if ($dispute == null) {
        return redirect()->route('purchases');
      }
      if ($dispute->resolved == true) {
          session()->flash('resolved',true);
         return redirect()->route('resolved');
      }
      if (Auth::user()->id !== $dispute->seller->id && Auth::user()->id !== $dispute->buyer->id ) {
          if (Auth::user()->admin == false) {
              return redirect()->route('purchases');
          }
      }
      if ($request->message == null) {
        session()->flash('errormessage','You must reply something');
        return redirect()->back();
      }
      if ($dispute->replies()->where('user_id',Auth::user()->id)->count() >= 3 && $dispute->replies()->where('adminreply',true)->count() == 0 && $request->adminbtn !== 'adminbtn') {
        session()->flash('errormessage','You cannot reply more than 3 times on this dispute until admin adds his reply');
        return redirect()->back();
      }
        $dr = new DisputeReply;
      if ((Auth::user()->admin == true && Auth::user()->id == $dispute->buyer->id) || (Auth::user()->admin == true && Auth::user()->id == $dispute->seller->id) || Auth::user()->admin == true) {
         if ($request->adminbtn == 'adminbtn') {
           $dr->adminreply = true;
         }
      }

      $dr->uniqueid = 'DR'.str_random(28);
      $dr->user_id = Auth::user()->id;
      $dr->dispute_id = $dispute->id;
      $dr->message = $request->message;
      $dr->save();
      session()->flash('successmessage','New reply added to dispute');
      return redirect()->back();


    }

    public function Resolve($uniqueid,Request $request){
      $dispute = Dispute::where('uniqueid',$uniqueid)->first();
      if ($dispute == null) {
        return redirect()->route('purchases');
      }
      if ($dispute->resolved == true) {
          session()->flash('resolved',true);
         return redirect()->route('resolved');
      }

      if (Auth::user()->admin == false) {
        return redirect()->back();
      }

      if ($request->resolve !== 'buyer' && $request->resolve !== 'seller') {
          return redirect()->back();
      }

      $settings = Settings::first();
      $fee = (100 - $settings->fee)/100;
      if ($request->resolve == 'buyer') {
          $dispute->resolved = true;
          $dispute->winner = 2;
          $dispute->purchase->state = 4;
          $dispute->purchase->buyer->balance += $dispute->purchase->value*$fee;
          $dispute->purchase->buyer->save();
      } elseif ($request->resolve == 'seller') {
          $dispute->resolved = true;
          $dispute->winner = 1;
          $dispute->purchase->state = 2;
          $dispute->purchase->seller->balance += $dispute->purchase->value*$fee;
          $dispute->purchase->seller->save();
      }else {
        return redirect()->back();
      }

        $dispute->save();
        $dispute->purchase->save();

        if (Auth::user()->id == $dispute->seller->id) {
          return redirect()->route('sales');
        } elseif (Auth::user()->id == $dispute->buyer->id) {
          return redirect()->route('purchases');
        } else {
          return redirect()->route('profile');
        }
    }
}
