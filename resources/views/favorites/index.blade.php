@extends('layouts.app')

@section('title', 'My Favorites — GIFTOS')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        <header class="mb-10 border-b border-giftos/20 pb-6 text-center sm:text-left">
            <p class="text-sm font-semibold uppercase tracking-widest text-giftos-dark">Saved Items</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">My Favorites</h1>
            <p class="mt-3 max-w-2xl text-zinc-600">Items you've starred for later.</p>
        </header>

        @if (count($favorites) === 0)
            <div class="rounded-2xl border border-zinc-100 bg-white p-12 text-center shadow-md shadow-zinc-200/40">
                <svg class="mx-auto mb-4 h-12 w-12 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <p class="text-lg font-semibold text-zinc-500">No favorites yet</p>
                <p class="mt-1 text-sm text-zinc-400">Star a product to save it here.</p>
                <a href="{{ url('/products') }}"
                   class="mt-6 inline-block rounded-xl bg-giftos px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-giftos-dark">
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($favorites as $product)
                    <x-product-card
                        :image="$product['img']"
                        :name="$product['name']"
                        :description="$product['description']"
                        :price="number_format($product['price'], 2)"
                        :in-stock="$product['in_stock']"
                    />
                @endforeach
            </div>
        @endif

    </div>
@endsection
