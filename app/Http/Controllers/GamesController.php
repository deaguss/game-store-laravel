<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Category;
use App\Models\Games;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class GamesController extends Controller
{
    public function index(Request $request) {
        try {
            $search = $request->search;
            $deletedGames = $this->deletedGames();

            $games = Games::with('users', 'categories')
            ->where('title', 'like', '%' . $search . '%')
            ->orWhere('developer', 'like', '%' . $search . '%')
            ->orWhereHas('users', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('categories', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->simplePaginate(10);


            return view('games.index', [
                'games' => $games,
                'deletedGames' => $deletedGames
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
        }
    }

    public function deletedGames(){
        return Games::onlyTrashed()->count();
    }

    public function create(){
        try {
            $games = Category::select('name', 'id')->get();

            if ($games->isEmpty()) {
                Session::flash('status', 'error');
                Session::flash('message', 'Category Not found');
                return redirect()->route('admin.game.create');
            }
            return view('games.create', ['categoryList' => $games]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.create');
        }
    }

    public function store(GameRequest $request)
    {
        try {
            $status = 'error';
            $message = 'Data game gagal ditambahkan!';

            if ($request->hasFile('image')) {
                $sizeFile = $request->file('image')->getSize() < 5000000;
                $fileType = in_array($request->file('image')->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                $isRequest = $request->title
                && $request->description
                && $request->category
                && $request->developer
                && $request->release_date;


                if ($sizeFile && $fileType && $isRequest) {
                    $store = Storage::disk('s3')->put('games', $request->file('image'), 'public');

                    $urlPath = env('AWS_URL_PATH') . $store;

                    $games = Games::create([
                        'id' => Str::uuid(),
                        'title' => $request->title,
                        'imageUrl' => $urlPath,
                        'description' => $request->description,
                        'category_id' => $request->category,
                        'developer' => $request->developer,
                        'release_date' => $request->release_date,
                        'price' => $request->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $userId = auth()->user()->id;
                    $user = User::findOrFail($userId);

                    if($user){
                        $user->games()->attach($games->id,[
                            'user_id' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }else {
                        $status = 'error';
                        $message = 'Terjadi Kesalahan di pivot';
                    }

                    $status = $games ? 'success' : 'error';
                    $message = $games ? 'Data game berhasil ditambahkan!' : 'Data game gagal ditambahkan!';
                } else {
                    $message = 'Invalid file size or type.' . ' (' . $request->file('image')->getMimeType() . ')' . ' (' . $request->file('image')->getSize() / 1024 . ' KB)';
                }
            } else {
                $message = 'No file uploaded.';
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.game.create');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.create');
        }
    }

    public function edit($id = null){
        try {
            $games = Games::findOrFail($id);
            $categoryList = Category::where('id','!=' , $games->category_id)->select('id', 'name')->get();

            return view('games.edit', [
                'games' => $games,
                'categoryList' => $categoryList
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.edit', $id);
        }
    }

    public function update(GameRequest $request, $id = null)
    {
        try {
            $status = 'error';
            $message = 'Data games gagal diperbarui!';

            $games = Games::findOrFail($id);

            if ($request->hasFile('image')) {
                $sizeFile = $request->file('image')->getSize() < 5000000;
                $fileType = in_array($request->file('image')->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                $isRequest = $request->title
                && $request->description
                && $request->category
                && $request->developer
                && $request->release_date;


                if ($sizeFile && $fileType && $isRequest) {

                    if ($games->imageUrl) {
                        $existingImagePath = str_replace(env('AWS_URL_PATH'), '', $games->imageUrl);
                        Storage::disk('s3')->delete($existingImagePath);
                    }

                    $store = Storage::disk('s3')->put('games', $request->file('image'), 'public');
                    $urlPath = env('AWS_URL_PATH') . $store;

                    $games->update([
                        'title' => $request->title,
                        'imageUrl' => $urlPath,
                        'description' => $request->description,
                        'category_id' => $request->category,
                        'developer' => $request->developer,
                        'release_date' => $request->release_date,
                        'price' => $request->price,
                        'updated_at' => now(),
                    ]);

                    $status = 'success';
                    $message = 'Data games berhasil diperbarui!';
                } else {
                    $message = 'Invalid file size or type.' . ' (' . $request->file('image')->getMimeType() . ')' . ' (' . $request->file('image')->getSize() / 1024 . ' KB)';
                }
            } else {

                $games->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'category_id' => $request->category,
                    'developer' => $request->developer,
                    'release_date' => $request->release_date,
                    'price' => $request->price,
                    'updated_at' => now(),
                ]);

                $status = 'success';
                $message = 'Data game berhasil diperbarui!';
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.game.edit', $id);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.edit', $id);
        }
    }

    public function destroy($id = null){
        try {
            $games = Games::findOrFail($id)->delete();
            if ($games) {
                Session::flash('status', 'success');
                Session::flash('message', 'Game deleted successfully.');
                return redirect()->route('admin.game.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.');
        }
    }

    public function allDeleted(Request $request){
        try {
            $search = $request->search;

            $games = Games::onlyTrashed()
            ->where('title', 'like', '%' . $search . '%')
            ->simplePaginate(10);

            return view('games.deleted', [
                'games' => $games
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.');
        }
    }

    public function restore($id = null){
        try {
            $games = Games::withTrashed()->findOrFail($id)->restore();
            if ($games) {
                Session::flash('status', 'success');
                Session::flash('message', 'Game restored successfully.');
                return redirect()->route('admin.game.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.game.');
        }
    }
}
