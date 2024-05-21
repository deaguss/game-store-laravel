<?php

namespace App\Http\Controllers;

use App\Events\OtpCodeMailEvent;
use App\Models\Cart;
use App\Models\Games;
use App\Models\Library;
use App\Models\User;
use App\Models\UserOTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        try {
            $cartCount = $this->cartCount();
            $cart = $this->cart();
            $libraryCount = $this->libraryCount();
            $mostGamesLibrary = $this->mostGamesLibrary();

            $data = User::with(['billboards', 'games', 'categories'])->get();

            $billboardsCount = $data->pluck('billboards')->flatten()->count();
            $gamesCount = $data->pluck('games')->flatten()->count();
            $categoriesCount = $data->pluck('categories')->flatten()->count();

            return view('dashboard', [
               'data' => $cart,
               'billboardsCount' => $billboardsCount,
               'gamesCount' => $gamesCount,
               'categoriesCount' => $categoriesCount,
               'cartCount' => $cartCount,
               'libraryCount' => $libraryCount,
               'mostGamesLibrary' => $mostGamesLibrary,
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.');
        }
    }

    public function libraryCount(){
        return Library::count();
    }

    public function mostGamesLibrary(){
        return Library::select(
        'games.id',
        'games.imageUrl',
        'games.title'
        )
        ->join('games', 'games.id', '=', 'library_games.game_id')
        ->orderBy('games.id', 'desc')->limit(3)->get();
    }

    public function cart(){
        return Cart::select(
            'games.id',
            'games.imageUrl',
            'games.price',
            'games.title',
            'users.name',
            'users.email',
            'detail_cart_games.created_at',
            'detail_cart_games.status_payment'
        )
        ->join('games', 'games.id', '=', 'detail_cart_games.game_id')
        ->join('users', 'users.id', '=', 'detail_cart_games.user_id')
        ->simplePaginate(10);
    }

    public function cartCount(){
        return Cart::count();
    }


    public function chartCountUser() {
        try {
        $startDate = Carbon::now()->subYear()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $userCounts = User::selectRaw(
            'DATE(created_at) as date, COUNT(*) as count'
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($userCounts);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.');
        }
    }

    public function chartData()
    {
    try {
        $yearAgo = Carbon::now()->subYear();
        $monthlyData = Games::selectRaw(
            'MONTH(created_at) as month, COUNT(*) as total_games'
            )
            ->where('created_at', '>=', $yearAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($monthlyData);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.');
        }
    }

    public function userProfile(){
        return view('user.index');
    }

    public function editAdmin(Request $request){
        try {
            $status = 'error';
            $message = 'Data users gagal diperbarui!';

            $id = Auth::user()->id;

            $user = User::findOrFail($id);

            if ($request->hasFile('image')) {
                $sizeFile = $request->file('image')->getSize() < 5000000;
                $fileType = in_array($request->file('image')->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                if ($sizeFile && $fileType) {

                    if ($user->image_url) {
                        $existingImagePath = str_replace(env('AWS_URL_PATH'), '', $user->image_url);
                        Storage::disk('s3')->delete($existingImagePath);
                    }

                    $store = Storage::disk('s3')->put('user', $request->file('image'), 'public');
                    $urlPath = env('AWS_URL_PATH') . $store;

                    $user->update([
                        'name' => $request->name,
                        'image_url' => $urlPath,
                    ]);

                    $status = 'success';
                    $message = 'Data user berhasil diperbarui!';
                } else {
                    $message = 'Invalid file size or type.';
                }
            } else {
                $user->update([
                    'name' => $request->name,
                ]);

                $status = 'success';
                $message = 'Data user berhasil diperbarui!';
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.profile.');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.profile.');
        }
    }
}
