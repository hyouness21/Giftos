@extends('layouts.app')

@section('title', $section['label'].' — GIFTOS')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-8 text-sm text-zinc-500" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2">
                <li>
                    <a href="{{ url('/products') }}" class="font-medium text-giftos-dark hover:text-giftos">Products</a>
                </li>
                <li aria-hidden="true">/</li>
                <li class="font-semibold text-zinc-800">{{ $section['label'] }}</li>
            </ol>
        </nav>

        <header class="mb-10 border-b border-giftos/20 pb-6 text-center sm:text-left">
            <p class="text-sm font-semibold uppercase tracking-widest text-giftos-dark">{{ $category }}</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">{{ $section['label'] }}</h1>
            <p class="mt-3 max-w-2xl text-zinc-600">Browse and add items to your cart.</p>
        </header>

        @if (count($catalog) > 1)
            <div class="mb-8 -mx-4 sm:mx-0">
                <div class="flex gap-2 overflow-x-auto px-4 pb-3 sm:px-0 sm:flex-wrap"
                     style="scrollbar-width:none;-ms-overflow-style:none;">
                    @foreach ($catalog as $slug => $cat)
                        @php $active = $slug === $category; @endphp
                        <a href="{{ url("/products/{$slug}") }}"
                           class="shrink-0 whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold transition-all duration-150
                                  {{ $active
                                     ? 'bg-giftos text-white'
                                     : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 hover:text-zinc-800' }}">
                            {{ $cat['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if (count($section['products']) === 0)
            <div class="rounded-2xl border border-zinc-100 bg-white p-10 text-center shadow-md shadow-zinc-200/40">
                <p class="text-zinc-500">No products in this category yet.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($section['products'] as $product)
                    <x-product-card
                        :image="$product['img']"
                        :name="$product['name']"
                        :description="$product['description']"
                        :price="$product['price']"
                        :in-stock="$product['in_stock'] ?? true"
                    />
                @endforeach
            </div>
        @endif
    </div>
@endsection
