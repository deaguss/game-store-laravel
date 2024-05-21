<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillboardRequest;
use App\Models\Billboard;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


class BillboardController extends Controller
{

    public function index(Request $request) {
        try {
            $search = $request->search;

            $desiredPart = $this->billboardActive();
            $deletedBillboards = $this->billboardDeleted();

            $billboards = Billboard::with('user')
            ->where('label', 'like', '%' . $search . '%')
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->simplePaginate(10);

            return view('billboard.index', [
                'billboards' => $billboards,
                'billboardActive' => $desiredPart,
                'deletedBillboards' => $deletedBillboards
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
        }
    }


    public function billboardActive(){
        $billboardActive = Billboard::where('status', '1')->select('id')->get();

        if (count($billboardActive) > 0) {
            $desiredPart = substr($billboardActive[0]->id, 0, strpos($billboardActive[0]->id, "-"));
        } else {
            $desiredPart = null;
        }
        return $desiredPart;
    }

    public function billboardDeleted(){
        return Billboard::onlyTrashed()->count();
    }

    public function create(){
        return view('billboard.create');
    }

    public function store(BillboardRequest $request)
    {
        try {
            $status = 'error';
            $message = 'Data billboard gagal ditambahkan!';

            if ($request->hasFile('image')) {
                $sizeFile = $request->file('image')->getSize() < 5000000;
                $fileType = in_array($request->file('image')->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                $isRequest = $request->label && $request->description;

                if ($sizeFile && $fileType && $isRequest) {
                    $store = Storage::disk('s3')->put('billboard', $request->file('image'), 'public');

                    $urlPath = env('AWS_URL_PATH') . $store;
                    $user_id = auth()->user()->id;

                    $billboard = Billboard::create([
                        'id' => Str::uuid(),
                        'label' => $request->label,
                        'imageUrl' => $urlPath,
                        'description' => $request->description,
                        'user_id' => $user_id,
                        'status' => '0',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $status = $billboard ? 'success' : 'error';
                    $message = $billboard ? 'Data billboard berhasil ditambahkan!' : 'Data billboard gagal ditambahkan!';
                } else {
                    $message = 'Invalid file size or type. Min image(600x200)';
                }
            } else {
                $message = 'No file uploaded.';
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.billboard.create');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.billboard.create');
        }
    }


    public function edit($id = null){
        try {
            $billboards = Billboard::findOrFail($id);

            return view('billboard.edit', [
                'billboard' => $billboards
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.billboard.edit', $id);
        }
    }



    public function update(BillboardRequest $request, $id = null)
    {
        try {
            $status = 'error';
            $message = 'Data billboard gagal diperbarui!';

            $billboard = Billboard::findOrFail($id);

            if ($request->hasFile('image')) {
                $sizeFile = $request->file('image')->getSize() < 5000000;
                $fileType = in_array($request->file('image')->getMimeType(), ["image/png", "image/jpg", "image/jpeg"]);

                $isRequest = $request->label && $request->description;

                if ($sizeFile && $fileType && $isRequest) {

                    if ($billboard->imageUrl) {
                        $existingImagePath = str_replace(env('AWS_URL_PATH'), '', $billboard->imageUrl);
                        Storage::disk('s3')->delete($existingImagePath);
                    }


                    $store = Storage::disk('s3')->put('billboard', $request->file('image'), 'public');
                    $urlPath = env('AWS_URL_PATH') . $store;

                    $billboard->update([
                        'label' => $request->label,
                        'imageUrl' => $urlPath,
                        'description' => $request->description,
                        'status' => '0',
                    ]);

                    $status = 'success';
                    $message = 'Data billboard berhasil diperbarui!';
                } else {
                    $message = 'Invalid file size or type. Min image(600x200)';
                }
            } else {

                $billboard->update([
                    'label' => $request->label,
                    'description' => $request->description,
                    'status' => '0',
                ]);

                $status = 'success';
                $message = 'Data billboard berhasil diperbarui!';
            }

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.billboard.edit', $id);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.billboard.edit', $id);
        }
    }

    public function setActive($id = null)
    {
        try {
            $billboard = Billboard::findOrFail($id);

            if ($billboard->status == '0') {
                Billboard::where('status', '1')->update(['status' => '0']);

                $billboard->update(['status' => '1']);

                Session::flash('status', 'success');
                Session::flash('message', 'Billboard activated successfully.');
            } else {
                Session::flash('status', 'info');
                Session::flash('message', 'Billboard is already active.');
            }

            return redirect()->route('admin.billboard.');
        } catch (ModelNotFoundException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Billboard not found.');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
        }
        return redirect()->route('admin.billboard.');
    }

    public function destroy($id = null){
        try {

            $statusFalse = Billboard::findOrFail($id);

            if($statusFalse->status == '1'){
                $statusFalse->update(['status' => '0']);
            }

            $billboard = Billboard::findOrFail($id)->delete();
            if ($billboard) {
                Session::flash('status', 'success');
                Session::flash('message', 'Billboard deleted successfully.');
                return redirect()->route('admin.billboard.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.billboard.');
        }
    }

    public function allDeleted(Request $request){
        try {
            $search = $request->search;

            $billboard = Billboard::onlyTrashed()
            ->where('label', 'like', '%' . $search . '%')
            ->simplePaginate(10);
            return view('billboard.deleted', [
                'billboards' => $billboard
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.billboard.');
        }
    }

    public function restore($id = null){
        try {
            $billboard = Billboard::withTrashed()->findOrFail($id)->restore();
            if ($billboard) {
                Session::flash('status', 'success');
                Session::flash('message', 'Billboard restored successfully.');
                return redirect()->route('admin.billboard.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.billboard.');
        }
    }
}
