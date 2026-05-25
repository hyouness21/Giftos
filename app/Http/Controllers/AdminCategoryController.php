<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories', [
            'categories' => Category::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);
        foreach ($request->ids as $position => $id) {
            Category::where('id', $id)->update(['sort_order' => $position]);
        }
        return response()->json(['ok' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:categories,name',
            'image' => 'nullable|image|max:4096',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = uniqid('cat_') . '.' . $file->getClientOriginalExtension();
            $dir      = public_path('images/categories');

            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $file->move($dir, $filename);
            $imagePath = '/images/categories/' . $filename;
        }

        $category = Category::create([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);

        return response()->json([
            'ok'    => true,
            'id'    => $category->id,
            'name'  => $category->name,
            'slug'  => Str::slug($category->name),
            'image' => $category->image,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $file     = $request->file('image');
            $filename = uniqid('cat_') . '.' . $file->getClientOriginalExtension();
            $dir      = public_path('images/categories');
            if (! is_dir($dir)) mkdir($dir, 0755, true);
            $file->move($dir, $filename);
            $category->image = '/images/categories/' . $filename;
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'ok'    => true,
            'id'    => $category->id,
            'name'  => $category->name,
            'image' => $category->image,
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            $path = public_path($category->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $category->delete();

        return response()->json(['ok' => true]);
    }
}
