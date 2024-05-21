<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){

        return view('login');
    }


    public function authentication(Request $request) {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'Email atau kata sandi yang diberikan tidak sesuai dengan data kami.',
                ])->errorBag('login');
            }

            if($user->tokens()->count() > 0){
                $userId = $user->id;

                $user->tokens()->where('tokenable_id', $userId)->delete();
            }

            $token = $user->createToken('web-login-token')->plainTextToken;
            session(['token' => $token]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route('admin.');
            }

        } catch (ValidationException $e) {
            return redirect()->route('login')
                ->withErrors($e->errors())
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.'. $e->getMessage()]);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
