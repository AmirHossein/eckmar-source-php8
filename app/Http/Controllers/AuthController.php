<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\User;

class AuthController extends Controller
{
    public function RegisterShow(){
      return view('auth.register');
    }

    public function RegisterPost(Request $request){
      $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails())
            {
                session()->flash('errormessage','Invalid captcha ');
                return redirect()->back();
            }

    if ($request->username == null || $request->password == null || $request->passwordconfirm == null) {
      session()->flash('errormessage','You must populate all fields ');
      return redirect()->back();
    }
     $usernamecheck = User::where('username',$request->username)->first();
     if ($usernamecheck !== null) {
       session()->flash('errormessage','Username is already in use ');
       return redirect()->back();
     }
     if ($request->password !== $request->passwordconfirm) {
       session()->flash('errormessage','Passwords must match ');
       return redirect()->back();
     }
     if (strlen($request->pin) > 6 || $request->pin == null) {
       session()->flash('errormessage','PIN must have 6 digits ');
       return redirect()->back();
     }
     if (strlen($request->pinconfirm) > 6 || $request->pinconfirm == null) {
       session()->flash('errormessage','You must confirm your pin ');
       return redirect()->back();
     }
     $user = new User;
     $user->username = $request->username;
     $user->password = Hash::make($request->password);
     $user->uniqueid = 'ID'.str_random(28);
     $user->balance = 0;
     $user->vendor = false;
     $user->pin = $request->pin;
     $user->admin = false;
     $user->verified = false;
     $user->mnemonic = generate_mnemonic();
     $user->save();
     session()->flash('mnemonic',$user->mnemonic);
     return redirect()->route('showmnemonic');
    }

    public function ShowMnemonic(){
      if (session()->has('mnemonic')) {
          $mnemonic = session()->get('mnemonic');
      } else {
        return redirect()->route('home');
      }
      return view('auth.mnemonic')->with('mnemonic',$mnemonic);
    }

    public function ShowLogin(){
      return view('auth.login');
    }

    public function LoginPost(Request $request){
      $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails())
            {
                session()->flash('errormessage','Invalid captcha ');
                return redirect()->back();
            }
            if ($request->username == null || $request->password == null) {
              session()->flash('errormessage','You must populate all fields ');
              return redirect()->back();
            }
            $user = User::where('username',$request->username)->first();
            if ($user == null) {
              session()->flash('errormessage','Invalid username ');
              return redirect()->back();
            }
            if ($user->verified == false) {
              session()->flash('errormessage','Your account is not verified ');
              return redirect()->route('verify');
            }
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
              $user = Auth::user();
              $user->last_seen = date('Y-m-d H:i:s', time());
              $user->save();
              return redirect()->route('home');

            } else {
              session()->flash('errormessage','Invalid password ');
              return redirect()->back();
            }
    }

    public function Logout(){
      Auth::logout();
      return redirect()->route('home');
    }
    public function PasswordResetShow(){
      return view('auth.resetpass');
    }
    public function PasswordResetPost(Request $request){
      if ($request->username == null || $request->mnemonic == null || $request->password == null) {
        session()->flash('errormessage','You must populate all fields ');
        return redirect()->back();
      }
      $user = User::where('username',$request->username)->first();
      if ($user == null) {
        session()->flash('errormessage','Invalid username ');
        return redirect()->back()->withInput();
      }
      if ($user->mnemonic !== $request->mnemonic) {
        session()->flash('errormessage','Invalid mnemonic ');
        return redirect()->back()->withInput();
      }
      $user->password = bcrypt($request->password);
      $user->save();
      session()->flash('successmessage','Password reset successful. You can log in now ');
      return redirect()->route('login');
    }

    public function VerifyShow(){
      return view('auth.verify');
    }

    public function VerifyPost(Request $request){
        $user = User::where('mnemonic',$request->mnemonic)->first();
        if ($user == null) {
          session()->flash('errormessage','Your mnemonic key is invalid, account is not verified');
          return redirect()->back();
        }
        $user->verified = true;
        $user->save();
        session()->flash('successmessage','Your account is now verified, you can login');
        return redirect()->route('login');
    }
}
