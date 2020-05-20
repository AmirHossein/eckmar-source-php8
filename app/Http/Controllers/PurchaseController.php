<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Product;
use Auth;
use App\User;
use App\Feedback;
use App\Settings;

class PurchaseController extends Controller
{
    public function DeliverShow($uniqueid){

      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null || $sale->seller_id !== Auth::user()->id || $sale->state !== 0) {
        return redirect()->route('sales');
      }
      return view('product.deliver')->with([
        'sale'=>$sale
      ]);

    }
    public function DeliverPost($uniqueid,Request $request){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null || $sale->seller_id !== Auth::user()->id || $sale->state !== 0) {
        return redirect()->route('sales');
      }
      if ($request->goods == null) {
         session()->flash('errormessage','You must deliver something');
         return redirect()->back();
      }
      $sale->state = 1;
      $sale->goods = $request->goods;
      $sale->delivered = true;
      $sale->save();
      return redirect()->route('sales');
    }

    public function GoodsShow($uniqueid){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null  || $sale->state == 0) {
        return redirect()->route('profile');
      }
      if ($sale->seller_id !== Auth::user()->id && $sale->buyer_id !== Auth::user()->id) {
        return redirect()->route('profile');
      }
      return view('product.goods')->with([
        'sale'=>$sale
      ]);
    }

    public function ConfirmDelivery($uniqueid){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null  || $sale->state == 0) {
        return redirect()->route('profile');
      }
      if ($sale->buyer_id !== Auth::user()->id) {
        return redirect()->route('purchases');
      }
      $sale->state = 2;
      $sale->save();
      $settings = Settings::first();
      $fee = (100 - $settings->fee)/100;
      if ($sale->product->auction == true) {
         $sale->seller->balance += $sale->value*$fee;
         $sale->seller->save();

         $settings->collected_fee += $sale->value - $sale->value*$fee;
         $settings->save();
      } else {
        $sale->seller->balance += $sale->value*$fee;
        $sale->seller->save();

        $settings->collected_fee += $sale->value - $sale->value*$fee;
        $settings->save();
      }
      return redirect()->route('purchases');
    }

    public function NewFeedback($uniqueid,$u){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();

      if ($sale == null  || $sale->state == 0 || $sale->state == 1 || $sale->state == 3) {
        return redirect()->route('profile');
      }
      if ($u !== 'seller' && $u !== 'buyer') {
        return redirect()->route('purchases');
      }

      if ($u == 'seller' && $sale->buyer_id !== Auth::user()->id) {
        return redirect()->route('purchases');
      }

      if ($u == 'buyer' && $sale->seller_id !== Auth::user()->id) {
        return redirect()->route('purchases');
      }

      if ($sale->feedback()->where('from',Auth::user()->id)->first() !== null) {
          return redirect()->route('purchases');
      }
      if ($u == 'seller') {
        $user = $sale->seller;
      } else {
        $user = $sale->buyer;
      }
      return view('product.newfeedback')->with([
        'sale'=>$sale,
        'u'=>$u,
        'user'=>$user
      ]);
    }
    public function NewFeedbackPost($uniqueid,$u,Request $request){
      $sale = Purchase::where('uniqueid',$uniqueid)->first();
      if ($sale == null  || $sale->state == 0 || $sale->state == 1 || $sale->state == 3) {
        return redirect()->route('profile');
      }
      if ($u !== 'seller' && $u !== 'buyer') {
        return redirect()->route('purchases');
      }
      if ($u == 'seller' && $sale->buyer_id !== Auth::user()->id) {
        return redirect()->route('purchases');
      }
      if ($u == 'buyer' && $sale->seller_id !== Auth::user()->id) {
        return redirect()->route('purchases');
      }
      if ($sale->feedback()->where('from',Auth::user()->id)->first() !== null) {
          return redirect()->route('purchases');
      }
      if ($request->comment == null) {
         session()->flash('errormessage','Comment is required');
         return redirect()->back();
      }

      if ($request->feedback !== 'positive' && $request->feedback !== 'negative') {
        session()->flash('errormessage','Feedback is required');
        return redirect()->back();
      }
      if ($request->feedback == 'positive') {
         $positive = true;
      } else {
         $positive = false;
      }

      $feedback = New Feedback;
      $feedback->uniqueid = 'FD'.str_random(28);
      $feedback->active = true;
      $feedback->positive = $positive;
      $feedback->purchase_id = $sale->id;
      $feedback->comment = $request->comment;
      if (Auth::user()->id == $sale->buyer_id) {
        $feedback->for = $sale->seller_id;
        $feedback->from = $sale->buyer_id;
      }else {
        $feedback->for = $sale->buyer_id;
        $feedback->from = $sale->seller_id;
      }
      $feedback->seller_id = $sale->seller_id;
      $feedback->buyer_id = $sale->buyer_id;
      $feedback->save();
      return redirect()->route('purchases');
    }
}
