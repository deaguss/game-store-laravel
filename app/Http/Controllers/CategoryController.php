<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Games;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class CategoryController extends Controller
{
    public function index(Request $request) {
        try {
            $search = $request->search;
            $bestCategory = $this->bestCategory();
            $deletedCategory = $this->deletedCategory();

            $category = Category::with('user')
            ->where('name', 'like', '%' . $search . '%')
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->simplePaginate(10);

            return view('categories.index', [
                'category' => $category,
                'bestCategory' => $bestCategory,
                'deletedCategory' => $deletedCategory
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
        }
    }

    public function bestCategory(){
        $bestCategory = Games::select('categories.name')
        ->join('categories', 'categories.id', '=', 'games.category_id')
        ->groupBy('games.category_id', 'categories.name')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->first();

        if($bestCategory == null) {
            $bestCategory = [];
        }
        return $bestCategory;
    }

    public function deletedCategory(){
        return Category::onlyTrashed()->count();
    }

    public function create(){
        return view("categories.create");
    }

    public function store(CategoryRequest $request)
    {
        try {
            $user_id = auth()->user()->id;

            $category = Category::create([
                'id' => Str::uuid(),
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $status = $category ? 'success' : 'error';
            $message = $category ? 'Data category berhasil ditambahkan!' : 'Data category gagal ditambahkan!';


            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.category.create');
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.category.create');
        }
    }

    public function edit($id = null){
        try {
            $categories = Category::findOrFail($id);

            return view('categories.edit', [
                'category' => $categories
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.category.edit', $id);
        }
    }

    public function update(CategoryRequest $request, $id = null)
    {
        try {
            $category = Category::findOrFail($id);

            $category->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $status = 'success';
            $message = 'Data category berhasil diperbarui!';

            Session::flash('status', $status);
            Session::flash('message', $message);

            return redirect()->route('admin.category.edit', $id);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.category.edit', $id);
        }
    }

    public function destroy($id = null){
        try {
            $category = Category::findOrFail($id)->delete();
            if ($category) {
                Session::flash('status', 'success');
                Session::flash('message', 'Category deleted successfully.');
                return redirect()->route('admin.category.');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.category.');
        }
    }

    public function allDeleted(Request $request){
        try {
            $search = $request->search;

            $category = Category::onlyTrashed()
            ->where('name', 'like', '%' . $search . '%')
            ->simplePaginate(10);
            return view('categories.deleted', [
                'category' => $category
            ]);
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.category.');
        }
    }

    public function restore($id = null){
        try {
            $category = Category::withTrashed()->findOrFail($id)->restore();
            if ($category) {
                Session::flash('status', 'success');
                Session::flash('message', 'Category restored successfully.');
                return redirect()->route('admin.category.deleted');
            }
        } catch (QueryException $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Error: ' . $e->getMessage());
            return redirect()->route('admin.category.deleted');
        }
    }
}
