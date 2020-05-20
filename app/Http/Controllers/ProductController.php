<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Input;
use Validator;
use App\Product;
use Auth;
use App\User;
use DateTime;
use File;
use App\Bid;
use App\Purchase;
use App\Settings;
class ProductController extends Controller
{
    public function CreateProduct(){
      if (Auth::user()->vendor == false) {
         return redirect()->route('profile');
      }
      $categories = Category::all();
      return view('product.create')->with([
        'categories'=>$categories
      ]);
    }
    public function CreateProductPost(Request $request){

      if (Auth::user()->vendor == false) {
         return redirect()->route('profile');
      }
      if ($request->name == null) {
        session()->flash('errormessage','Product name is required');
        return redirect()->back()->withInput();
      }
      if ($request->category == null) {
        session()->flash('errormessage','Product category is required');
        return redirect()->back()->withInput();
      }
      if ($request->price == null) {
        session()->flash('errormessage','Product price is required');
        return redirect()->back()->withInput();
      }
      if (!is_numeric($request->price) || $request->price <= 0.0001) {
        session()->flash('errormessage','Invalid price');
        return redirect()->back()->withInput();
      }
      $category = Category::where('name',$request->category)->first();
      if ($category == null) {
        session()->flash('errormessage','Invalid category name, chose from given categories');
        return redirect()->back()->withInput();
      }
      if ($request->description == null) {
        session()->flash('errormessage','Product description is required');
        return redirect()->back()->withInput();
      }
      if ($request->auction == 'true') {
        if ($request->end_date == null) {
          session()->flash('errormessage','End date is required for auctions');
          return redirect()->back()->withInput();
        }
        if (validateDate($request->end_date)) {
          $end_date = DateTime::createFromFormat('Y-m-d\TH:i',$request->end_date);
          $now = date('Y-m-d\TH:i');
          $end_date1 =  date_format($end_date,'Y-m-d\TH:i');
          if ($end_date1 < $now) {
            session()->flash('errormessage','Invalid end date');
            return redirect()->back()->withInput();
          }
        } else{
          session()->flash('errormessage','Invalid end date');
          return redirect()->back()->withInput();
        }

        if ($request->buyout == null) {
          session()->flash('errormessage','Buyout is required for auction');
          return redirect()->back()->withInput();
        }
        if (!is_numeric($request->buyout) || $request->buyout <= 0.0001) {
          session()->flash('errormessage','Invalid buyout');
          return redirect()->back()->withInput();
        }
      }

      if ($request->hasFile('image')) {

         $file = $request->file('image');

         $size = $request->file('image')->getSize();
         if ($size > 500000) {
           session()->flash('errormessage','Image is too large');
           return redirect()->back()->withInput();
         }
         if (substr($file->getMimeType(), 0, 5) !== 'image') {
           session()->flash('errormessage','File is not an image');
           return redirect()->back()->withInput();
         }

        if ($file->isValid()) {
            $path = $request->image->store('uploads','public');
        } else {

          session()->flash('errormessage','Image is not valid');
          return redirect()->back()->withInput();
        }

      }
      $product = new Product;
      $product->name = $request->name;
      $product->uniqueid = 'PR'.str_random(28);
      $product->category_id = $category->id;
      $product->description = $request->description;
      $product->refund_policy = $request->refund_policy;
      $product->price = $request->price/0.00000001;
      if ($request->image !== null) {
        $product->image = $path;
      }
      if ($request->auction == 'true') {
        $product->auction = true;
        $product->end_date = $end_date;
        $product->buyout = $request->buyout/0.00000001;
      } else {
        $product->buyout = 0;
      }
      $product->seller_id = Auth::user()->id;
      $product->save();
      return redirect()->route('products');



    }
    public function EditProductPost($uniqueid, Request $request){
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null ) {
        return redirect()->route('products');
      }
      if (Auth::user()->id !== $product->seller->id) {
        return redirect()->route('products');
      }
      if ($product->sold == true) {
        session()->flash('errormessage','You cannot edit sold products');
        return redirect()->back()->withInput();
      }
      if ($request->name == null) {
        session()->flash('errormessage','Product name is required');
        return redirect()->back()->withInput();
      }
      if ($request->name !== $product->name) {
         $product->name = $request->name;
      }
      if ($request->description == null) {
        session()->flash('errormessage','Product description is required');
        return redirect()->back()->withInput();
      }
      if ($request->description !== $product->description) {
         $product->description = $request->description;
      }
      if ($product->auction == false) {
        if (!is_numeric($request->price)) {
          session()->flash('errormessage','Invalid price');
          return redirect()->back()->withInput();
        }
        if ($request->price/0.00000001 !== $product->price) {
             $product->price = $request->price/0.00000001;
        }
      } else {
        if ($request->buyout == null) {
          session()->flash('errormessage','Buyout is required for auction');
          return redirect()->back()->withInput();
        }
        if (!is_numeric($request->buyout) || $request->buyout <= 0.0001) {
          session()->flash('errormessage','Invalid buyout');
          return redirect()->back()->withInput();
        }
        if ($request->buyout/0.00000001 !== $product->buyout) {
           $product->buyout = $request->buyout/0.00000001;
        }
      }
      if ($request->hasFile('image')) {
         $file = $request->file('image');
         $size = $request->file('image')->getSize();

         if ($size > 500000) {
           session()->flash('errormessage','Image is too large');
           return redirect()->back()->withInput();
         }
         if (substr($file->getMimeType(), 0, 5) !== 'image') {
           session()->flash('errormessage','File is not an image ');
           return redirect()->back()->withInput();
         }

        if ($file->isValid()) {
            $path = $request->image->store('uploads','public');

        } else {

          session()->flash('errormessage','Image is not valid');
          return redirect()->back()->withInput();
        }
      }
      if ($request->image !== null) {
        $product->image = $path;
      }
      $product->save();
      return redirect()->route('products');


    }
    public function ShowCategory($cslug){
      $category = Category::where('slug',$cslug)->first();
      $categories = Category::all();
      if ($category == null) {
         return redirect()->route('home');
      }
      $products = $category->products()->where('sold',0)->paginate(20);
      return view('product.category')->with([
        'products'=> $products,
        'categories'=>$categories,
        'category'=>$category,
        'cslug'=>$cslug
      ]);
    }

    public function ViewProduct($cslug,$uniqueid,$item = 'description'){
      $category = Category::where('slug',$cslug)->first();
      $categories = Category::all();
      if ($category == null) {
         return redirect()->route('home');
      }
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null) {
          return redirect()->route('home');
      }
      if ($item !== 'description' && $item !== 'refund_policy' && $item !== 'feedback') {
          $item == 'description';
      }
      if ($product->sold == true) {
          session()->flash('sold',true);
          return redirect()->route('sold');
      }
      if ($product->auction == true) {
          $ends =  new DateTime($product->end_date);
          $now = new DateTime(date('Y-m-d H:i:s', time()));
          $interval = $now->diff($ends);
          $days = $interval->format("%a");
          $hours = $interval->format("%h");
          $minutes = $interval->format("%i");
          $a_ends = $days.' days '.$hours.' hours '.$minutes.' minutes';
      } else {
        $a_ends = null;
      }
      $categories = Category::all();
      return view('product.view')->with([
        'product'=> $product,
        'category'=>$categories,
        'categories'=>$categories,
        'cslug'=>$cslug,
        'a_ends'=>$a_ends,
        'item'=>$item
      ]);
    }


    public function Sold(){
        if (session()->has('sold')) {
            return view('product.sold');
        }
    }

    public function BidShow($cslug,$uniqueid){
      $category = Category::where('slug',$cslug)->first();
      if ($category == null) {
         return redirect()->route('home');
      }
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null) {
          return redirect()->route('home');
      }
      if ($product->sold == true) {
        session()->flash('sold',true);
        return redirect()->route('sold');
      }
      if ($product->bids->count() == 0) {
        $minbid = $product->price*0.00000001;
      } else {
         $minbid = $product->bids->max('value')*0.00000001;
      }
      return view('product.bid')->with([
        'product'=> $product,
        'cslug'=>$cslug,
        'minbid'=>$minbid
      ]);
    }

    public function BidShowPost($cslug,$uniqueid,Request $request){
      $category = Category::where('slug',$cslug)->first();
      $categories = Category::all();
      if ($category == null) {
         return redirect()->route('home');
      }
      $product = Product::where('uniqueid',$uniqueid)->first();
      if ($product == null) {
          return redirect()->route('home');
      }
      if ($product->sold == true) {
        session()->flash('sold',true);
        return redirect()->route('sold');
      }
      if (!is_numeric($request->bid) || $request->bid <= 0.0001) {
        session()->flash('errormessage','Invalid bid');
        return redirect()->back()->withInput();
      }
      $user = Auth::user();
      if ($user->id == $product->seller_id) {
        session()->flash('errormessage','You cannot bid on your own product');
        return redirect()->back()->withInput();
      }
      if ($request->bid/0.00000001 > $user->balance) {
        session()->flash('errormessage','You don\'t have enough bitcoins in order to place bid');
        return redirect()->back()->withInput();
      }
      if ($product->bids->count() == 0) {
        $minbid = $product->price;
        if ($request->bid/0.00000001 <= $minbid) {
          session()->flash('errormessage','Bid is too small');
          return redirect()->back()->withInput();
        }
        $bid = new Bid;
        $bid->uniqueid = 'BD'.str_random(28);
        $bid->user_id = Auth::user()->id;
        $bid->product_id = $product->id;
        $bid->value = $request->bid/0.00000001;
        $bid->winner = false;
        $bid->save();
        $user->balance -= $request->bid/0.00000001;
        $user->save();
        session()->flash('successmessage','You have placed your bid');
        return redirect()->back()->withInput();

      } else {
         $minbid = $product->bids->max('value');
         if ($request->bid/0.00000001 <= $minbid) {
           session()->flash('errormessage','Bid is too small');
           return redirect()->back()->withInput();
         }

         $bid = new Bid;
         $bid->uniqueid = 'BD'.str_random(28);
         $bid->user_id = Auth::user()->id;
         $bid->product_id = $product->id;
         $bid->value = $request->bid/0.00000001;
         $bid->winner = false;
         $bid->save();
         $user->balance -= $request->bid/0.00000001;
         $user->save();
         session()->flash('successmessage','You have placed your bid');
         return redirect()->back()->withInput();
      }


    }

        public function BuyShow($cslug,$uniqueid){
          $category = Category::where('slug',$cslug)->first();
          $categories = Category::all();
          if ($category == null) {
             return redirect()->route('home');
          }
          $product = Product::where('uniqueid',$uniqueid)->first();
          if ($product == null) {
              return redirect()->route('home');
          }
          if ($product->sold == true) {
            session()->flash('sold',true);
            return redirect()->route('sold');
          }

          return view('product.buy')->with([
            'product'=> $product,
            'cslug'=>$cslug,
          ]);
        }

        public function BuyShowPost($cslug,$uniqueid,Request $request){
          $category = Category::where('slug',$cslug)->first();
          $categories = Category::all();
          if ($category == null) {
             return redirect()->route('home');
          }
          $product = Product::where('uniqueid',$uniqueid)->first();
          if ($product == null) {
              return redirect()->route('home');
          }
          if ($product->sold == true) {
            session()->flash('sold',true);
            return redirect()->route('sold');
          }
          $user = Auth::user();
          if ($user->id == $product->seller_id) {
            session()->flash('errormessage','You cannot buy your own product');
            return redirect()->back()->withInput();
          }
          if ($product->auction == true) {
            if ($product->buyout > $user->balance) {
              session()->flash('errormessage','You don\'t have enough bitcoins in order to purchase this product');
              return redirect()->back()->withInput();
            }
            $user->balance -= $product->buyout;
            $user->save();
            $product->buyer_id= $user->id;
            $product->sold = true;
            $product->save();

            $purchase = new Purchase;
            $purchase->uniqueid = 'PU'.str_random(28);
            $purchase->buyer_id = $user->id;
            $purchase->seller_id = $product->seller->id;
            $purchase->value = $product->buyout;
            $purchase->product_id = $product->id;
            $purchase->delivered = false;
            $purchase->save();
          }else {
            if ($product->price > $user->balance) {
              session()->flash('errormessage','You don\'t have enough bitcoins in order to purchase this product');
              return redirect()->back()->withInput();
            }
            $user->balance -= $product->price;
            $user->save();
            $product->buyer_id= $user->id;
            $product->purchase_time = date('Y-m-d H:i:s', time());
            if ($product->autofilled == true) {
                $autofill = unserialize($product->autofill);
                $item = array_shift($autofill);
                $purchase = new Purchase;
                $purchase->uniqueid = 'PU'.str_random(28);
                $purchase->buyer_id = $user->id;
                $purchase->seller_id = $product->seller->id;
                $purchase->product_id = $product->id;
                $purchase->delivered = true;
                $purchase->value = $product->price;
                $purchase->goods = $item;
                $purchase->state = 1;
                $purchase->save();
                if (count($autofill) !== 0) {
                  $product->autofill = serialize($autofill);
                } else {
                $product->autofill = null;
                $product->sold = true;
                }

            } else {
              $purchase = new Purchase;
              $purchase->uniqueid = 'PU'.str_random(28);
              $purchase->buyer_id = $user->id;
              $purchase->seller_id = $product->seller->id;
              $purchase->value = $product->price;
              $purchase->product_id = $product->id;
              $purchase->delivered = false;
              $purchase->save();
              $product->sold = true;
            }

            $product->save();
        }

        return redirect()->route('purchases');
      }
}
