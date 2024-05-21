<?php

namespace App\Http\Controllers;

use App\Models\Billboard;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Games;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopController extends Controller
{


    public function index(Request $request)
    {
        try {
            $search = $request->input('category');
            $priceFree = $request->input('price');
            $page = $request->input('page', 1);

            $gamesData = $this->getAllCategoryWithGames($search, $page, $priceFree);
            $billboardData = $this->billboard();
            $getCategories = $this->getCategory();


            $categoriesWithMostGames = Category::withCount('games')
                ->orderByDesc('games_count')
                ->take(3)
                ->get();

            return view('shopify.index', [
                'billboard' => $billboardData,
                'data' => $categoriesWithMostGames,
                'games' => $gamesData,
                'getCategories' => $getCategories,
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Something went wrong. Please try again!');
            return redirect()->route('home.');
        }
    }



    public function getAllCategoryWithGames($search, $page, $priceFree)
    {

        if ($priceFree == "free") {
            return Games::with('categories')
                ->whereNull('price')
                ->paginate(8, ['*'], 'page', $page);
        } elseif (!empty($search)) {
            $categoryName = $search;
            return Games::with('categories')
                ->whereHas('categories', function ($query) use ($categoryName) {
                    $query->where('name', 'like', '%' . $categoryName . '%');
                })
                ->paginate(8, ['*'], 'page', $page);
        } else {
            return Games::with('categories')
            ->paginate(8, ['*'], 'page', $page);
        }
    }

    public function getCategory(){
        return Category::all();
    }

    public function billboard(){
        return Billboard::where('status', 1)->first();
    }

    public function cart(){
        try {
            $userId = auth()->user()->id;

            $cartTotal = $this->cartTotal($userId);

            $cart = User::select(
                    'games.id',
                    'games.imageUrl',
                    'games.description',
                    'games.price',
                    'detail_cart_games.id as pivot_id',
                    'detail_cart_games.user_id',
                    'detail_cart_games.game_id',
                    'detail_cart_games.created_at')
                    ->join(
                        'detail_cart_games',
                        'users.id',
                        '=',
                        'detail_cart_games.user_id')
                    ->join(
                        'games',
                        'detail_cart_games.game_id',
                        '=',
                        'games.id')
                    ->where('users.id', $userId)
                    ->get();

            return view('shopify.cart.index', [
                'data' => $cart,
                'cartTotal' => $cartTotal
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Something went wrong. Please try again!' . $e->getMessage());
            return redirect()->route('home.');
        }
    }

    public function cartTotal($userId){
        return User::select('id as user_id')
        ->with(['cart' => function ($query) use ($userId) {
            $query->select(
                'games.id',
                'games.price',
                'detail_cart_games.id as pivot_id',
                'detail_cart_games.user_id',
                'detail_cart_games.game_id')
                ->join('detail_cart_games as cart', 'games.id', '=', 'cart.game_id')
                ->where('cart.user_id', $userId);
        }])
        ->withCount('cart as total_games')
        ->addSelect(['subtotal' => function ($query) {
            $query->select(DB::raw('SUM(games.price)'))
                ->from('games')
                ->join('detail_cart_games as cart', 'games.id', '=', 'cart.game_id')
                ->whereColumn('cart.user_id', 'users.id');
        }])
        ->where('id', $userId)
        ->first();
    }

    public function library(Request $request) {
        try {
            $search = $request->sortBy;

            $userId = auth()->user()->id;

            $categoryBy = [
                "Latest",
                "Oldest"
            ];

            $libraries = User::with(['libraries' => function ($query) use ($userId, $search, $categoryBy) {
                $query->select(
                    'games.id',
                    'games.imageUrl',
                    'games.release_date',
                    'games.title',
                    'games.developer',
                    'games.description',
                    'library_games.id as pivot_id',
                    'library_games.user_id',
                    'library_games.game_id',
                    'library_games.created_at'
                    )
                    ->join('library_games as lg1', 'games.id', '=', 'lg1.game_id')
                    ->where('lg1.user_id', $userId);

                if ($search == $categoryBy[0]) {
                    $query->orderBy("lg1.created_at", "desc");
                } elseif ($search == $categoryBy[1]) {
                    $query->orderBy("lg1.created_at", "asc");
                }
            }])
            ->where('id', $userId)
            ->get();

            return view('shopify.library.index', [
                'data' => $libraries
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Something went wrong. Please try again!' . $e->getMessage());
            return redirect()->route('home.');
        }
    }



    public function addLibrary($id = null){
        try {
            $userId = auth()->user()->id;

            $isPrice = Games::where('id', $id)->whereNull('price')->first();
            $existingGame = Library::where('game_id', $id)
            ->where('user_id', $userId)
            ->first();

            if ($isPrice && !$existingGame) {
                Library::create([
                    'id' => Str::uuid(),
                    'user_id' => $userId,
                    'game_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $status = 'success';
                $message = 'Successfully added to library!';
            } else {
                $status = 'error';
                $message = "Can't added game to library!";
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('home.');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Something went wrong. Please try again!');
            return redirect()->route('home.');
        }
    }

    public function addCart($id = null){
        try {
            $userId = auth()->user()->id;

            $isPrice = Games::where('id', $id)->whereNull('price')->first();
            $existingGame = Cart::where('game_id', $id)
            ->where('user_id', $userId)
            ->first();

            if (!$existingGame && !$isPrice) {
                Cart::create([
                    'id' => Str::uuid(),
                    'user_id' => $userId,
                    'game_id' => $id,
                    'status_payment' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $status = 'success';
                $message = 'Successfully added to cart!';
            } else {
                $status = 'error';
                $message = "Can't added game to cart!";
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('home.');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Something went wrong. Please try again!');
            return redirect()->route('home.');
        }
    }
}
