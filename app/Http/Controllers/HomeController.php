<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\News;
use Auth;

class HomeController extends Controller
{
        public function Index(){
          $categories = Category::all();
          $news = News::where('active',true)->orderBy('created_at','desc')->paginate(25);
          return view('index')->with([
            'categories'=>$categories,
            'news'=>$news
          ]);
        }
        public function Test(){
          dd( generate_mnemonic());
        }
        public function ShowDemo(){
          if (env('APP_DEMO') == true) {
            return view('demo');
          }
          return redirect()->route('home');
        }

        public function DemoMoney(){
          if (!Auth::check()) {
            return redirect()->route('demo');
          }
          if (env('APP_DEMO') !== true) {
            return redirect()->route('home');
          }
          if (Auth::user()->balance > 10000000000) {
            return redirect()->route('demo');
          }
          Auth::user()->balance += 1000000000;
          Auth::user()->save();
          return redirect()->route('demo');
        }
        public function DemoAdmin(){
          if (!Auth::check()) {
            return redirect()->route('demo');
          }
          if (env('APP_DEMO') !== true) {
            return redirect()->route('home');
          }
          if (Auth::user()->admin == true) {
            return redirect()->route('demo');
          }
          Auth::user()->admin = true;
          Auth::user()->save();
          return redirect()->route('demo');
        }
        public function DemoVendor(){
          if (!Auth::check()) {
            return redirect()->route('demo');
          }
          if (env('APP_DEMO') !== true) {
            return redirect()->route('home');
          }
          if (Auth::user()->vendor == true) {
            return redirect()->route('demo');
          }
          Auth::user()->vendor = true;
          Auth::user()->save();
          return redirect()->route('demo');
        }
}
