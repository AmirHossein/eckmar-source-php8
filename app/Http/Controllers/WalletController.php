<?php

namespace App\Http\Controllers;
require_once('easybitcoin.php');
use Illuminate\Http\Request;
use Bitcoin;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Product;
use App\Bid;
use App\Purchase;
use DateTime;
class WalletController extends Controller
{

        private $bitcoin;
        private $minc;

         public function __construct()
         {

             $this->bitcoin = new Bitcoin(env('BITCOIND_USERNAME'),env('BITCOIND_PASSWORD'),env('BITCOIND_HOST'),env('BITCOIND_PORT'));
             $this->minc = (integer)env('BITCOIND_MINCONFIRMATIONS');
         }
    public function Test(){

      $auctions = Product::where('sold',0)->where('auction',true)->get();

      foreach ($auctions as $auction) {

        $ends =  new DateTime($auction->end_date);
        $now = new DateTime(date('Y-m-d H:i:s', time()));
        if ($ends < $now) {
          $lastbid = $auction->bids->where('value',$auction->bids->max('value'))->first();
          foreach ($auction->bids as $bid) {
            if ($bid->id == $lastbid->id) {

            } else {
              $bid->user->balance += $bid->value;
              $bid->user->save();
            }
          }
          $auction->buyer_id = $lastbid->user->id;
          $auction->sold = true;
          $auction->save();

          $purchase = new Purchase;
          $purchase->uniqueid = 'PU'.str_random(28);
          $purchase->buyer_id = $lastbid->user->id;
          $purchase->seller_id = $auction->seller->id;
          $purchase->value = $lastbid->value;
          $purchase->product_id = $auction->id;
          $purchase->delivered = false;
          $purchase->save();
        }
      }
    }

    public function NewAddress(){
      if (env('APP_DEMO') == true) {
        session()->flash('errormessage','Not available in demo mode');
        return redirect()->back();
      }
      $user = Auth::user();
      $address = $this->bitcoin->getnewaddress($user->uniqueid);

      return view('profile.newaddress')->with([
        'address'=>$address
      ]);
    }

    public function CheckBalance(){
      if (env('APP_DEMO') == true) {
        session()->flash('errormessage','Not available in demo mode');
        return redirect()->back();
      }
      $user = Auth::user();
      $total_received = $this->bitcoin->getreceivedbyaccount($user->uniqueid,$this->minc)/0.00000001;
      $last_credited = $user->last_credited;
      $to_credit = $total_received-$last_credited;
      if ($to_credit > 0) {
        $user->balance += $to_credit;
        $user->last_credited = $total_received;
        $user->save();
        session()->flash('successmessage','Your balance has beed credited with '.$to_credit*0.00000001.' BTC');
        return redirect()->back();
      }

      session()->flash('successmessage','Balance update successful, no new transactions');
      return redirect()->back();
    }
    public function WithdrawShow(){
        return view('profile.withdraw');
    }
    public function WithdrawPost(Request $request){
      if (env('APP_DEMO') == true) {
        session()->flash('errormessage','Not available in demo mode');
        return redirect()->back();
      }
      $user = Auth::user();

      $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails())
            {
                session()->flash('errormessage','Invalid captcha ');
                return redirect()->back()->withInput();
            }

      if ($request->balance == null) {
        session()->flash('errormessage','Please enter how much you want to withdraw');
        return redirect()->back()->withInput();
      }
      if ($request->address == null) {
        session()->flash('errormessage','Please enter withdraw address');
        return redirect()->back()->withInput();
      }
      if ($request->balance/0.00000001 > $user->balance ) {
        session()->flash('errormessage','You don\'t have enough BTC in your balance');
        return redirect()->back()->withInput();
      }
      if ($request->pin == null) {
        session()->flash('errormessage','PIN is required');
        return redirect()->back()->withInput();
      }

      if ($request->pin == $user->pin) {

      } else {
        session()->flash('errormessage','PIN is incorrect');
        return redirect()->back()->withInput();
      }
      if ($request->password == null ) {
        session()->flash('errormessage','Password is required');
        return redirect()->back()->withInput();
      }
      if (!Hash::check($request->password, $user->password)) {
        session()->flash('errormessage','Password is incorrect');
        return redirect()->back()->withInput();
      }

      $wallet = (string)$user->uniqueid;
      $address = (string)$request->address;
      $amount = $request->balance;
      $response = $this->bitcoin->sendtoaddress($address,$amount);
      if ($response !== false) {
         $user->balance -= $amount/0.00000001;
         $user->save();
            session()->flash('successmessage','Successful withdraw of '.$amount.' BTC, with TXID '.$response);
           return redirect()->route('wallet');
      } else {
          session()->flash('errormessage','Something went wrong');
          return redirect()->back();
      }
    }
}
