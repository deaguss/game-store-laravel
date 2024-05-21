<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request) {
        try {
            $userVerifiedCount = $this->userVerifiedCount();
            $deletedCount = $this->deletedCount();

            $search = $request->search;

            $users = User::where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->where('role', '!=', 'admin')
            ->simplePaginate(10);

            return view('users.index', [
                'users' => $users,
                'userVerifiedCount' => $userVerifiedCount,
                'deletedCount' => $deletedCount
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
        }
    }

    public function userVerifiedCount(){
        return User::where('email_verified_at', '!=', null)->count();
    }

    public function deletedCount(){
        return User::onlyTrashed()->count();
    }

    public function edit($id = null){
        try {
            $users = User::findOrFail($id);

            return view('users.edit', [
                'users' => $users
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.users.edit', $id);
        }
    }



    public function update(UserRequest $request, $id = null)
    {
        try {
            $status = 'error';
            $message = 'Data users gagal diperbarui!';

            $users = User::findOrFail($id);

            if ($request->hasFile('image')) {
                $sizeFile = $request->file('image')->getSize() < 5000000;
                $fileType = in_array($request->file('image')->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                $isRequest = $request->name && $request->address && $request->phone && $request->email;

                if ($sizeFile && $fileType && $isRequest) {

                    if ($users->image_url) {
                        $existingImagePath = str_replace(env('AWS_URL_PATH'), '', $users->image_url);
                        Storage::disk('s3')->delete($existingImagePath);
                    }


                    $store = Storage::disk('s3')->put('user', $request->file('image'), 'public');
                    $urlPath = env('AWS_URL_PATH') . $store;

                    $users->update([
                        'name' => $request->name,
                        'image_url' => $urlPath,
                        'address' => $request->address,
                        'email' => $request->email,
                        'phone' => $request->phone
                    ]);

                    $status = 'success';
                    $message = 'Data users berhasil diperbarui!';
                } else {
                    $message = 'Invalid file size or type.';
                }
            } else {

                $users->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);

                $status = 'success';
                $message = 'Data users berhasil diperbarui!';
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.users.edit', $id);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.users.edit', $id);
        }
    }

    public function destroy($id = null){
        try {
            $users = User::findOrFail($id)->delete();
            if ($users) {
                Session::flash('status', 'success');
                Session::flash('message', 'User deleted successfully.');
                return redirect()->route('admin.users.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.users.');
        }
    }

    public function allDeleted(Request $request){
        try {
            $search = $request->search;

            $users = User::onlyTrashed()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->simplePaginate(10);

            return view('users.deleted', [
                'users' => $users
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.users.deleted');
        }
    }

    public function restore($id = null){
        try {
            $users = User::withTrashed()->findOrFail($id)->restore();
            if ($users) {
                Session::flash('status', 'success');
                Session::flash('message', 'User restored successfully.');
                return redirect()->route('admin.users.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.users.deleted');
        }
    }
}
