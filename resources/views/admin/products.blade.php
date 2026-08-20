@extends('layouts.app')

@section('title', 'Admin Products — GIFTOS')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.admin-nav')
        <header class="mb-8">
            <div class="mb-2 flex items-center gap-2 text-sm text-zinc-400">
                <a href="{{ url('/admin') }}" class="hover:text-giftos">Admin</a>
                <span>/</span>
                <span class="font-medium text-zinc-700">Products</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900">Manage Products</h1>
            <p class="mt-2 text-sm text-zinc-500">Choose a category to view and manage its products.</p>
        </header>

        @if ($categories->isEmpty())
            <div class="rounded-2xl border border-zinc-100 bg-white p-10 text-center shadow-md shadow-zinc-200/40">
                <p class="text-zinc-500">No categories yet.
                    <a href="{{ url('/admin/categories') }}" class="font-semibold text-giftos-dark hover:text-giftos">Add a category first →</a>
                </p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <a
                        href="{{ url('/admin/products/' . $category->id) }}"
                        class="group flex flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/50 transition hover:border-giftos/35 hover:shadow-lg hover:shadow-giftos/10"
                    >
                        @if ($category->image)
                            <div class="aspect-video overflow-hidden bg-giftos-muted">
                                <img src="{{ $category->image }}" alt="{{ $category->name }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                            </div>
                        @else
                            <div class="aspect-video flex items-center justify-center bg-giftos-muted">
                                <span class="text-5xl font-bold text-giftos/25">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <div class="flex flex-1 flex-col p-5">
                            <h2 class="text-lg font-bold text-zinc-900 group-hover:text-giftos-dark">{{ $category->name }}</h2>
                            <p class="mt-1 text-sm text-zinc-500">{{ $category->products_count }}
                                {{ $category->products_count === 1 ? 'product' : 'products' }}</p>
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-giftos-dark">
                                View products
                                <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
