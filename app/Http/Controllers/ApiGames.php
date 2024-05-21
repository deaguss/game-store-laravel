<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameDetailResources;
use App\Http\Resources\GameResources;
use App\Models\Games;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Validation\ValidationException;

class ApiGames extends Controller
{

    public function index(){
        $token = session('token');
        return view('api.index', ['token' => $token]);
    }

    public function getGame()
    {
        try {
            $games = Games::all();

            if ($games->isEmpty()) {
                return response()->json(['message' => 'No games found.'], Response::HTTP_NOT_FOUND);
            }

            return GameResources::collection($games);
        }catch(ModelNotFoundException $e){
            return response()->json(
                ['message' => 'No game found']
                , Response::HTTP_NOT_FOUND);

        }catch (\Exception $e) {
            return response()->json(
            [
                'error' => 'Internal Server Error',
                'message' => 'An error occurred while processing your request.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getGameDetail($id = null){
        try {
            if ($id === null) {
                return response()->json(['message' => 'Game ID cannot be null.'], Response::HTTP_BAD_REQUEST);
            }

            $games = Games::findOrFail($id);

            return new GameDetailResources($games);
        } catch(ModelNotFoundException $e){
            return response()->json(
                ['message' => 'No game found with id: ' . $id], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return response()->json(
            [
                'error' => 'Internal Server Error',
                'message' => 'An error occurred while processing your request.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function postGame(GameRequest $request){
        try {
            $status = 'error';
            $message = 'Data game gagal ditambahkan!';

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $sizeFile = $file->getSize() < 5000000;
                $fileType = in_array($file->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                $isRequest = $request->filled(['title', 'description', 'category', 'developer', 'release_date']);

                if ($sizeFile && $fileType && $isRequest) {
                    $store = Storage::disk('s3')->put('games', $file, 'public');

                    $urlPath = env('AWS_URL_PATH', 'https://php-api-img.s3.ap-southeast-1.amazonaws.com/') . $store;

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
                    $user = User::find($userId);

                    if ($user) {
                        $user->games()->attach($games->id, [
                            'user_id' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $status = 'error';
                        $message = 'Terjadi Kesalahan di pivot';
                    }

                    $status = $games ? 'success' : 'error';
                    $message = $games ? 'Data game berhasil ditambahkan!' : 'Data game gagal ditambahkan!';
                } else {
                    $message = 'Invalid file size or type. (' . $file->getMimeType() . ') (' . $file->getSize() / 1024 . ' KB)';
                }
            } else {
                $message = 'No file uploaded.';
            }

            return response()->json(['status' => $status, 'message' => $message]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unexpected error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // public function editGame(GameRequest $request, $id = null){
    //     try {
    //         if ($id === null) {
    //             return response()->json(['message' => 'Game ID cannot be null.'], Response::HTTP_BAD_REQUEST);
    //         }

    //         $status = 'error';
    //         $message = 'Data game gagal ditambahkan!';

    //         $games = Games::findOrFail($id);


    //         $isRequest = $request->filled(['title', 'description', 'category', 'developer', 'release_date']);


    //         if ($request->hasFile('image')) {
    //             $file = $request->file('image');
    //             $sizeFile = $file->getSize() < 5000000;
    //             $fileType = in_array($file->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);


    //             if ($sizeFile && $fileType && $isRequest) {
    //                 if ($games->imageUrl) {
    //                     $existingImagePath = str_replace(env('AWS_URL_PATH', 'https://php-api-img.s3.ap-southeast-1.amazonaws.com/'), '', $games->imageUrl);
    //                     Storage::disk('s3')->delete($existingImagePath);
    //                 }

    //                 $store = Storage::disk('s3')->put('games', $request->file('image'), 'public');

    //                 $urlPath = env('AWS_URL_PATH', 'https://php-api-img.s3.ap-southeast-1.amazonaws.com/') . $store;

    //                 $games->update([
    //                     'title' => $request->title,
    //                     'imageUrl' => $urlPath,
    //                     'description' => $request->description,
    //                     'category_id' => $request->category,
    //                     'developer' => $request->developer,
    //                     'release_date' => $request->release_date,
    //                     'price' => $request->price,
    //                     'updated_at' => now(),
    //                 ]);

    //                 $status = 'success';
    //                 $message = 'Data games berhasil diperbarui!';
    //             } else {
    //                 $message = 'Invalid file size or type.' . ' (' . $request->file('image')->getMimeType() . ')' . ' (' . $request->file('image')->getSize() / 1024 . ' KB)';
    //             }
    //         } else {
    //             $games->update([
    //                 'title' => $request->title,
    //                 'description' => $request->description,
    //                 'category_id' => $request->category,
    //                 'developer' => $request->developer,
    //                 'release_date' => $request->release_date,
    //                 'price' => $request->price,
    //                 'updated_at' => now(),
    //             ]);

    //             $status = 'success';
    //             $message = 'Data game berhasil diperbarui!';
    //         }

    //         return response()->json(['status' => $status, 'message' => $message]);
    //     } catch (ValidationException $e) {
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    //     } catch (QueryException $e) {
    //         return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => 'Unexpected error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    public function destroyGame($id = null){
        try{
            if ($id === null) {
                return response()->json(['message' => 'Game ID cannot be null.'], Response::HTTP_BAD_REQUEST);
            }

            $games = Games::findOrFail($id)->delete();

            if($games){
                return response()->json(['message' => 'Game deleted successfully.'], Response::HTTP_OK);
            }
        } catch(ModelNotFoundException $e){
            return response()->json(
                ['message' => 'No game found with id: ' . $id], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return response()->json(
            [
                'error' => 'Internal Server Error',
                'message' => 'An error occurred while processing your request.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
