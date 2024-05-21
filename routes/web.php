<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiGames;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');



Route::prefix('signup')->name('signup.')->middleware('guest')->group(function () {
    Route::get('/', [RegisterController::class, 'signup']);

    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/{id}/otp-verification', [RegisterController::class, 'otpVerify'])->name('otp');


    Route::post('/{id}/otp-validation', [RegisterController::class, 'otpvalidation'])->name('otpValidation');
});


Route::post('/login', [AuthController::class, 'authentication'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::prefix('/')->name('home.')->group(function () {
    Route::get('/', [ShopController::class, 'index']);

    Route::get('/load-more', [ShopController::class, 'loadMore'])->name
    ('load-more');

    Route::get('/library', [ShopController::class, 'library'])->middleware('auth')->name('library');

    Route::post('/library/{id}', [ShopController::class, 'addLibrary'])->middleware('auth')->name('addLibrary');

    Route::get('/cart', [ShopController::class, 'cart'])->middleware('auth')->name('cart');

    Route::post('/cart/{id}', [ShopController::class, 'addCart'])->middleware('auth')->name('addCart');


    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/', [ApiGames::class, 'index'])->middleware('auth');

        Route::prefix('games')->name('games.')->middleware(['auth:sanctum'])->group(function () {
            Route::get('/', [ApiGames::class, 'getGame'])->name('getGames');
            Route::get('/{id}', [ApiGames::class, 'getGameDetail'])->name('getGameDetail');

            Route::post('/', [ApiGames::class, 'postGame'])->name('postGames')->middleware('admin');
            // Route::put('/{id}', [ApiGames::class, 'editGame'])->name('editGame')->middleware('admin');
            Route::delete('/{id}/delete', [ApiGames::class, 'destroyGame'])->name('destroyGame')->middleware('admin');;
        });
    });

});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);

    Route::get('/chart-data', [AdminController::class, 'chartData'])->name('chart-data');

    Route::get('/chart-data-user', [AdminController::class, 'chartCountUser'])->name('chart-data-user');

    // profile page
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminController::class, 'userProfile']);

        Route::put('/update', [AdminController::class, 'editAdmin'])->name('update');
    });

    // billboard page
    Route::prefix('billboard')->name('billboard.')->group(function () {
        Route::get('/', [BillboardController::class, 'index']);
        Route::get('/create', [BillboardController::class, 'create'])->name('create');

        // create
        Route::post('/store', [BillboardController::class, 'store'])->name('store');

        // edit
        Route::get('/edit/{id}', [BillboardController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}/active-billboard', [BillboardController::class, 'setActive'])->name('active-billboard');
        Route::put('/edit/{id}/update', [BillboardController::class, 'update'])->name('update');

        // soft delete
        Route::get('/deleted', [BillboardController::class, 'allDeleted'])->name('deleted');
        Route::delete('/delete/{id}', [BillboardController::class, 'destroy'])->name('delete');
        Route::get('/delete/{id}/restore', [BillboardController::class, 'restore'])->name('restore');
    });

       // user page
       Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index']);

        // edit
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}/update', [UserController::class, 'update'])->name('update');

        // soft delete
        Route::get('/deleted', [UserController::class, 'allDeleted'])->name('deleted');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/delete/{id}/restore', [UserController::class, 'restore'])->name('restore');
    });

    // categories page
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/create', [CategoryController::class, 'create'])->name('create');

        // create
        Route::post('/store', [CategoryController::class, 'store'])->name('store');

        // edit
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}/update', [CategoryController::class, 'update'])->name('update');

        // soft delete
        Route::get('/deleted', [CategoryController::class, 'allDeleted'])->name('deleted');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        Route::get('/delete/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
    });

    // games page
    Route::prefix('game')->name('game.')->group(function () {
        Route::get('/', [GamesController::class, 'index']);
        Route::get('/create', [GamesController::class, 'create'])->name('create');

        // create
        Route::post('/store', [GamesController::class, 'store'])->name('store');

        // edit
        Route::get('/edit/{id}', [GamesController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}/update', [GamesController::class, 'update'])->name('update');

        // soft delete
        Route::get('/deleted', [GamesController::class, 'allDeleted'])->name('deleted');
        Route::delete('/delete/{id}', [GamesController::class, 'destroy'])->name('delete');
        Route::get('/delete/{id}/restore', [GamesController::class, 'restore'])->name('restore');
    });
});

