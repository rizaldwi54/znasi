<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\UserAuthVerifyRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    
    public function verify(UserAuthVerifyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'role'=>'admin'])){
            $request->session()->regenerate();
            return redirect()->intended('/admin/home');
        }else if(Auth::guard('user')->attempt(['email'=>$data['email'],'password'=>$data['password'],'role'=>'user'])){
            $request->session()->regenerate();
            return redirect()->intended('/user/home');
        }else{
            return redirect(route('login'))->with('msg','email dan password salah');
        }
    }

    public function logout(): RedirectResponse
    {
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }else if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
        }
        return redirect(route('login'));
    }

    public function LoginVerif(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $verificationCode = random_int(100000,999999);
        session(['verification_code' => $verificationCode, 'user' => $user->id]);

        Mail::to($user->email)->send(new VerificationCodeMail ($verificationCode));

        Auth::logout();

        return redirect()->route('custom.verification.form')->with('status','Verification code send to your mail');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid Credentials Provided']);
    }

    public function ShowVerification()
    {
        return view('auth.verify');
    }

    public function VerificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if ($request->code == session('verification_code')) {
            Auth::loginUsingId(session('user'));

            session()->forget(['verification_code','user']);
            return redirect()->intended('/user/home');
        }

        return back()->withErrors(['code' => 'Invalid Verification Code']);
    }
}
