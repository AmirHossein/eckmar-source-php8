<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\VendorApplication;
use App\Product;
use App\Settings;
use App\Feedback;
use App\User;


class ProfileController extends Controller
{
    public function Index(){
      $user = Auth::user();
      $settings = Settings::first();
      return view('profile.index')->with([
        'user'=>$user,
        'settings'=>$settings
      ]);
    }

    public function VendorApplyShow(){
      if (Auth::user()->application->first() !== null) {
         return redirect()->route('home');
      }
      return view('profile.vendor.apply');
    }

    public function VendorApplyPost(Request $request){
          if (Auth::user()->application->first() !== null) {
             return redirect()->route('home');
          }

        if ($request->offer == null || $request->void == null || $request->other_markets == null) {
          session()->flash('errormessage','You must populate all fields ');
          return redirect()->back()->withInput();
        }
        $va = new VendorApplication;
        $va->uniqueid = 'VA'.str_random(28);
        $va->user_id = Auth::user()->id;
        $va->status = 0;
        $va->offer = $request->offer;
        $va->void = $request->void;
        $va->other_markets = $request->other_markets;
        $va->save();

        session()->flash('vendorapplication',true);
        return redirect()->route('vendorapplysuccess');
    }

    public function VendorApplySuccess(){
      if (!session()->has('vendorapplication')) {
        return redirect()->route('home');
      }
        return view('profile.vendor.applysuccess');
    }

    public function VendorPay(){
      if (Auth::user()->vendor == true) {
          return redirect()->route('profile');
      }
      $settings = Settings::first();
      return view('profile.vendor.pay')->with([
        'settings'=>$settings
      ]);
    }

    public function VendorPayPost(Request $request){
      if (Auth::user()->vendor == true) {
          return redirect()->route('profile');
      }

      $user = Auth::user();
      $settings = Settings::first();
      if ($user->balance < $settings->vendor_price) {
        session()->flash('errormessage','You don\'t have enough bitcoins in your balance' );
        return redirect()->back();
      }
      $user->vendor = true;
      $user->balance -= $settings->vendor_price;
      $user->save();
      $application = $user->application()->first();
      if ($application !== null) {
        $application->status = 3;
        $application->save();
      }

      session()->flash('vendorpaid',true);
      return redirect()->route('vendorpaysuccess');
    }

    public function VendorPaySuccess(){
      if (!session()->has('vendorpaid')) {
        return redirect()->route('home');
      }
      return view('profile.vendor.paysuccess');
    }

    public function ShowProducts(){
      $products = Auth::user()->products()->orderBy('created_at','desc')->paginate(20);
      return view('profile.products')->with([
        'products'=>$products
      ]);
    }

    public function EditProduct($uniqueid){
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null || $product->seller->id !== Auth::user()->id) {
        return redirect()->route('products');
      }

      return view('profile.editproduct')->with('product',$product);
    }

    public function ShowSales(){
        $sales = Auth::user()->sales()->orderBy('created_at','desc')->paginate(20);
    //  $products = Auth::user()->products()->where('sold',true)->orderBy('purchase_time','desc')->paginate(20);
      return view('profile.sales')->with([
        'sales'=>$sales
      ]);
    }

    public function AutoFill($uniqueid){
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null || $product->seller->id !== Auth::user()->id || $product->auction == true || $product->sold == true) {
        return redirect()->route('products');
      }
      if ($product->seller->id !== Auth::user()->id) {
         return redirect()->route('profile');
      }
      if ($product->autofilled == true) {
        $autofill = unserialize($product->autofill);

      } else {
        $autofill = null;
      }
      return view('profile.autofill')->with([
        'product'=>$product,
        'autofill'=>$autofill
      ]);
    }

    public function AutoFillPost($uniqueid,Request $request){
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null || $product->seller->id !== Auth::user()->id || $product->auction == true) {
        return redirect()->route('products');
      }
      if ($product->seller->id !== Auth::user()->id) {
         return redirect()->route('profile');
      }
      if ($request->autofill == null) {
         session()->flash('errormessage','You must add at least one item');
         return redirect()->back()->withInput();
      }
            $text = trim($request->autofill);
            $textAr = explode("\n", $text);
            $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
            $autofill = [];
            foreach ($textAr as $line) {
              $line = str_replace("\r\n", "", $line);
              $line = str_replace("\r", "", $line);
              if ($line !== "") {
                  $autofill[]=$line;
              }
            }
          $product->autofilled = true;
          $product->autofill= serialize($autofill);
          $product->save();
          return redirect()->route('products');


    }

    public function ShowPurchases(){
    //  $products = Auth::user()->products()->where('buyer_id',Auth::user()->id)->orderBy('purchase_time','desc')->paginate(20);
        $purchases = Auth::user()->purchases()->orderBy('created_at','desc')->paginate(20);
      return view('profile.purchases')->with([
        'purchases'=>$purchases
      ]);
    }
    public function ShowFeedback(){

      $feedback = Auth::user()->feedback()->where('active',1)->orderBy('created_at','desc')->paginate(20);
      return view('profile.feedback')->with([
        'feedback'=>$feedback,
      ]);
    }

    public function View($uniqueid,$item = 'profile'){
      $user = User::where('uniqueid',$uniqueid)->first();
      if ($user == null) {
         return redirect()->back();
      }
      if ($item !== 'profile' && $item !== 'pgp' && $item !== 'feedback') {
         $item == 'profile';
      }
      return view('profile.view')->with([
        'user'=>$user,
        'item'=>$item
      ]);
    }

    public function EditProfile(Request $request){
      $user = Auth::user();
      $user->profile = $request->pd;
      $user->pgp = $request->pgp;
      $user->save();
      return redirect()->back();
    }

    public function ViewStore($uniqueid){
      $user = User::where('uniqueid',$uniqueid)->first();
      if ($user == null) {
         return redirect()->back();
      }
      $products = $user->products()->where('active',1)->where('sold',0)->orderBy('created_at','desc')->paginate(25);
      return view('profile.store')->with([
        'user'=>$user,
        'products'=>$products
      ]);
    }

    public function ShowWallet(){
      return view('profile.wallet');
    }
    
}
