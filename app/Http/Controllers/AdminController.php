<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorApplication;
use App\Category;
use App\Dispute;
use App\News;
use App\Settings;

class AdminController extends Controller
{
    public function Index(){
        $settings = Settings::first();
        return view('admin.index')->with([
          'settings' => $settings
        ]);
    }

    public function SettingsEdit(Request $request){
      if (env('APP_DEMO')==true) {
        return redirect()->back();
      }
      $settings = Settings::first();
      if ($request->vendor_price !== null) {
        $settings->vendor_price = $request->vendor_price/0.00000001;
      }
      if ($request->fee !== null && $request->fee < 100 && $request->fee >= 0) {
        $settings->fee = $request->fee;
      }
      $settings->save();
      return redirect()->back();
    }

    public function VendorApplications(){
        $va = VendorApplication::orderBy('created_at','asc')->paginate(25);
        return view('admin.vendorapplications')->with([
          'va'=>$va
        ]);
    }
    public function VaShow($uniqueid = '123'){
      $va = VendorApplication::where('uniqueid',$uniqueid)->first();
      if ($va == null) {
         return redirect()->route('admin');
      }
      return view('admin.showvendorapplication')->with([
        'va'=>$va
      ]);
    }

    public function VaPost($uniqueid = '123',Request $request){
      $va = VendorApplication::where('uniqueid',$uniqueid)->first();
      if ($va == null) {
         return redirect()->route('admin');
      }
      if ($request->action == 'approve') {
        $va->status = 1;
        $va->user->vendor = true;
        $va->user->save();
      } elseif ($request->action == 'decline') {
        $va->status = 2;
      } else{
        $va->status = 4;
      }

      $va->save();
      return redirect()->back();
    }

    public function ShowCategories(){
        $categories = Category::paginate(25);
        return view('admin.categories')->with([
          'categories'=>$categories
        ]);
    }

    public function EditCategory($uniqueid = '123'){
      $category = Category::where('uniqueid',$uniqueid)->first();
      if ($category == null) {
         return redirect()->route('admin');
      }

      return view('admin.editcategory')->with([
        'category'=>$category
      ]);
    }

    public function EditCategoryPost($uniqueid = '123',Request $request){
      $category = Category::where('uniqueid',$uniqueid)->first();
      if ($category == null) {
         return redirect()->route('admin');
      }
      if ($request->cname == null) {
        session()->flash('errormessage',' Invalid category name');
        return redirect()->back();
      }
      if ($request->cname == null || $request->cslug == null ) {
        session()->flash('errormessage','You must populate all fields');
        return redirect()->back();
      }
      if ($request->cname !== $category->name) {
          $cc = Category::where('name',$request->cname)->first();
          if ($cc !== null) {
            session()->flash('errormessage',' Category with that name already exists');
            return redirect()->back();
          }
          $category->name = $request->cname;
          $category->save();
      }
      if ($request->cslug !== $category->slug) {
          $cc1 = Category::where('slug',$request->cslug)->first();
          if ($cc1 !== null) {
            session()->flash('errormessage',' Category with that slug already exists');
            return redirect()->back();
          }
          $category->slug = $request->cslug;
          $category->save();
      }
      return redirect()->route('categories');
    }

    public function CreateCategory(){
      return view('admin.createcategory');
    }
    public function CreateCategoryPost(Request $request){
        if ($request->cname == null) {
          session()->flash('errormessage',' Invalid category name');
          return redirect()->back();
        }
        $cc = Category::where('name',$request->cname)->first();
        if ($cc !== null) {
          session()->flash('errormessage',' Category with that name already exists');
          return redirect()->back();
        }
        $category = new Category;
        $category->name = $request->cname;
        $category->uniqueid = 'CA'.str_random(28);
        $category->slug = str_slug($request->cname,'-');
        $category->save();
        return redirect()->route('categories');
    }
    public function DisputesShow(){
      $disputes = Dispute::orderBy('created_at','desc')->paginate(25);
      return view('admin.disputes')->with([
        'disputes'=>$disputes
      ]);
    }

    public function News(){
      $news = News::orderBy('created_at','desc')->paginate(25);
      return view('admin.news')->with('news',$news);
    }
    public function NewsCreate(){
      return view('admin.newscreate');
    }
    public function NewsCreatePost(Request $request){
      if ($request->title == null) {
        session()->flash('errormessage','You must enter title');
        return redirect()->back();
      }
      if ($request->text == null) {
        session()->flash('errormessage','You must enter something');
        return redirect()->back();
      }
      $news = new News;
      $news->uniqueid = 'NE'.str_random(28);
      $news->title = $request->title;
      $news->text = $request->text;
      $news->save();
      return redirect()->route('news');
    }
    public function EditNews($uniqueid){
      $news = News::where('uniqueid',$uniqueid)->first();
      if ($news == null) {
        return redirect()->route('news');
      }
      return view('admin.editnews')->with([
        'news'=>$news
      ]);
    }
    public function EditNewsPost($uniqueid,Request $request){
      $news = News::where('uniqueid',$uniqueid)->first();
      if ($news == null) {
        return redirect()->route('news');
      }
      if ($request->title == null) {
        session()->flash('errormessage','You must enter title');
        return redirect()->back();
      }
      if ($request->text == null) {
        session()->flash('errormessage','You must enter something');
        return redirect()->back();
      }
      $news->title = $request->title;
      $news->text = $request->text;
      $news->save();
      return redirect()->route('news');
    }
}
