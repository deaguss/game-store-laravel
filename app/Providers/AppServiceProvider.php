<?php

namespace App\Providers;

use App\Models\UserOTP;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try{
            View::composer('layouts.main', function ($view) {
                $otpCodes = UserOTP::select(
                    'otp_code',
                    'expired_at',
                    'users.email',
                )
                ->join('users', 'users.id', '=', 'user_otps.user_id')
                ->orderBy('expired_at', 'desc')
                ->limit(5)
                ->get();

                $view->with('otpCodes', $otpCodes);
            });
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
        }
    }
}
