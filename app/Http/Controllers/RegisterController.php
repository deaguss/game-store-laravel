<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\UserOTP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use OTP;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function signup()
    {
        return view("signup");
    }

    public function register(RegistrationRequest $request)
    {
        try {
            $user = User::create([
                'id' => Str::uuid(),
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            UserOTP::create([
                'user_id' => $user->id,
                'otp_code' => Str::random(6),
                'expired_at' => now()->addMinutes(5)
            ]);
            event(new Registered($user));

            return redirect()->route('signup.otp' ,$user->id)->with('success', 'Registration successful. Please check your email for verification.');
        } catch (ValidationException $e) {
            return redirect()->route('signup.')
                ->withErrors($e->errors())
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            return redirect()->route('signup.')->withErrors(['error' => 'Something went wrong. Please try again.' . $e->getMessage()]);
        }
    }

    public function otpVerify($id = null){
        try {
            $user = User::findOrFail($id);
            return view('otp', ['user' => $user]);
        } catch (ValidationException $e) {
            return redirect()->route('signup.')->withErrors($e->errors());
        }
    }

    public function otpvalidation(Request $request, $id = null)
    {
        try {
            $user = UserOTP::where('otp_code', $request->otp)->where('expired_at', '>', now())->first();

            if(!$user){
                return redirect()->back()->withErrors([
                    'otp' => 'The OTP code is invalid. Please try again'
                ]);
            }

            $user->user->email_verified_at = now();
            $user->user->save();
            Auth::login($user->user);
            return redirect()->route('home.');
        } catch (\Exception $e) {
            return redirect()->route('signup.otp')->withErrors(['error' => 'Something went wrong. Please try again.' . $e->getMessage()]);
        }

    }
}
