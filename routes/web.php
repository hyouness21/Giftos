<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackOrderController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Models\Category;
use Illuminate\Support\Str;

Route::view('/', 'welcome');
Route::get('/products', function () {
    $catalog = Category::withCount('products')->orderBy('name')->get()
        ->mapWithKeys(fn ($c) => [
            Str::slug($c->name) => [
                'label'    => $c->name,
                'image'    => $c->image,
                'count'    => $c->products_count,
                'products' => [],
            ],
        ])->toArray();

    return view('products.index', ['catalog' => $catalog]);
});

Route::get('/products/{category}', function (string $category) {
    $allCats = Category::with('products')->orderBy('name')->get();

    $cat = $allCats->first(fn ($c) => Str::slug($c->name) === $category);
    abort_unless($cat, 404);

    $section = [
        'label'    => $cat->name,
        'image'    => $cat->image,
        'products' => $cat->products->map(fn ($p) => [
            'name'        => $p->name,
            'description' => $p->description,
            'price'       => number_format($p->price_usd, 2),
            'img'         => $p->image_url ?? '',
            'in_stock'    => $p->in_stock,
        ])->toArray(),
    ];

    $catalog = $allCats->mapWithKeys(fn ($c) => [
        Str::slug($c->name) => ['label' => $c->name, 'products' => []],
    ])->toArray();

    return view('products.category', [
        'category' => $category,
        'section'  => $section,
        'catalog'  => $catalog,
    ]);
});

Route::view('/wholesale', 'wholesale');
Route::get('/track', [TrackOrderController::class, 'show']);

Route::get('/cart', function () {
    $lines = array_values(session('cart', []));
    return view('cart', compact('lines'));
});

Route::get('/api/cart', [CartController::class, 'index']);
Route::post('/api/cart/update', [CartController::class, 'update']);
Route::post('/api/cart/remove', [CartController::class, 'remove']);
Route::post('/api/cart/clear', [CartController::class, 'clear']);
Route::post('/api/orders', [OrderController::class, 'store'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/api/orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->middleware('admin')
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/checkout', function () {
    $lines    = array_values(session('cart', []));
    $orderUsd = collect($lines)->sum(fn ($item) => $item['price'] * $item['qty']);
    $lbpPerUsd = 89500;
    return view('checkout', compact('lines', 'orderUsd', 'lbpPerUsd'));
});

// Admin login API (hardcoded credentials as requested).
Route::post('/api/admin/login', [AdminAuthController::class, 'login'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/api/admin/logout', [AdminAuthController::class, 'logout'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::match(['GET', 'POST'], '/admin/logout', function () {
    session()->forget('giftos_admin');
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('admin')->group(function () {
    Route::view('/admin', 'admin.dashboard');
    Route::get('/admin/categories', [AdminCategoryController::class, 'index']);
    Route::post('/admin/categories', [AdminCategoryController::class, 'store']);
    Route::post('/admin/categories/reorder', [AdminCategoryController::class, 'reorder']);
    Route::post('/admin/categories/{category}/update', [AdminCategoryController::class, 'update']);
    Route::delete('/admin/categories/{category}', [AdminCategoryController::class, 'destroy']);
    Route::get('/admin/products', [AdminProductController::class, 'index']);
    Route::post('/admin/products', [AdminProductController::class, 'store']);
    Route::get('/admin/products/{category}', [AdminProductController::class, 'show']);
    Route::post('/admin/products/{product}/update', [AdminProductController::class, 'update']);
    Route::post('/admin/products/{product}/toggle-stock', [AdminProductController::class, 'toggleStock']);
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy']);
    Route::get('/admin/orders', [OrderController::class, 'index']);
});

