<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        return view('admin.products', [
            'categories' => Category::withCount('products')->orderBy('name')->get(),
        ]);
    }

    public function show(Category $category)
    {
        $category->load('products');
        return view('admin.category-products', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'price_usd'   => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:4096',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = uniqid('prod_') . '.' . $file->getClientOriginalExtension();
            $dir      = public_path('images/products');

            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $file->move($dir, $filename);
            $imagePath = '/images/products/' . $filename;
        }

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price_usd'   => $request->price_usd,
            'image_url'   => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'ok'          => true,
            'id'          => $product->id,
            'name'        => $product->name,
            'description' => $product->description,
            'price_usd'   => $product->price_usd,
            'image_url'   => $product->image_url,
            'category_id' => $product->category_id,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'price_usd'   => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }
            $file     = $request->file('image');
            $filename = uniqid('prod_') . '.' . $file->getClientOriginalExtension();
            $dir      = public_path('images/products');
            if (! is_dir($dir)) mkdir($dir, 0755, true);
            $file->move($dir, $filename);
            $product->image_url = '/images/products/' . $filename;
        }

        $product->name        = $request->name;
        $product->description = $request->description;
        $product->price_usd   = $request->price_usd;
        $product->save();

        return response()->json([
            'ok'          => true,
            'id'          => $product->id,
            'name'        => $product->name,
            'description' => $product->description,
            'price_usd'   => $product->price_usd,
            'image_url'   => $product->image_url,
        ]);
    }

    public function toggleStock(Product $product)
    {
        $product->in_stock = !$product->in_stock;
        $product->save();
        return response()->json(['ok' => true, 'in_stock' => $product->in_stock]);
    }

    public function destroy(Product $product)
    {
        if ($product->image_url && file_exists(public_path($product->image_url))) {
            unlink(public_path($product->image_url));
        }

        $product->delete();

        return response()->json(['ok' => true]);
    }
}
