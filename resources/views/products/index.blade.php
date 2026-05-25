@extends('layouts.app')

@section('title', 'Products — GIFTOS')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-12 text-center sm:text-left">
            <p class="text-sm font-semibold uppercase tracking-widest text-giftos-dark">Shop</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">Categories</h1>
            <p class="mt-3 max-w-2xl text-zinc-600">Choose a category to browse products. Each collection has its own page.</p>
        </header>

        <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($catalog as $slug => $section)
                <li>
                    <a
                        href="{{ url("/products/{$slug}") }}"
                        class="group flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/50 transition hover:border-giftos/35 hover:shadow-lg hover:shadow-giftos/10"
                    >
                        @php
                            $cardImg = $section['image'] ?? $section['products'][0]['img'] ?? null;
                        @endphp
                        <div class="aspect-16/10 overflow-hidden bg-giftos-muted">
                            @if ($cardImg)
                                <img
                                    src="{{ $cardImg }}"
                                    alt="{{ $section['label'] }} preview"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    loading="lazy"
                                    width="640"
                                    height="400"
                                />
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <span class="text-4xl font-bold text-giftos/30">{{ strtoupper(substr($section['label'], 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <h2 class="text-xl font-bold text-zinc-900 group-hover:text-giftos-dark">{{ $section['label'] }}</h2>
                            <p class="mt-2 flex-1 text-sm text-zinc-600">{{ $section['count'] ?? count($section['products']) }} items</p>
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-giftos-dark">
                                View category
                                <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
