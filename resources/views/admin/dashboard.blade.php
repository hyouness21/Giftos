@extends('layouts.app')

@section('title', 'Admin Dashboard — GIFTOS')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.admin-nav')
        <header class="mb-10 text-center sm:text-left">
            <p class="text-sm font-semibold uppercase tracking-widest text-giftos-dark">Admin</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">Dashboard</h1>
            <p class="mt-3 max-w-2xl text-zinc-600">Manage your store content and monitor orders from one place.</p>
        </header>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <a
                href="{{ url('/admin/categories') }}"
                class="group flex flex-col rounded-2xl border border-zinc-100 bg-white p-6 shadow-md shadow-zinc-200/50 transition hover:border-giftos/35 hover:shadow-lg hover:shadow-giftos/10"
            >
                <h2 class="text-xl font-bold text-zinc-900 group-hover:text-giftos-dark">Manage Categories</h2>
                <p class="mt-2 flex-1 text-sm text-zinc-600">Create and organize product categories.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-giftos-dark">Open</span>
            </a>
            <a
                href="{{ url('/admin/products') }}"
                class="group flex flex-col rounded-2xl border border-zinc-100 bg-white p-6 shadow-md shadow-zinc-200/50 transition hover:border-giftos/35 hover:shadow-lg hover:shadow-giftos/10"
            >
                <h2 class="text-xl font-bold text-zinc-900 group-hover:text-giftos-dark">Manage Products</h2>
                <p class="mt-2 flex-1 text-sm text-zinc-600">Add, update, and remove products.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-giftos-dark">Open</span>
            </a>
            <a
                href="{{ url('/admin/orders') }}"
                class="group flex flex-col rounded-2xl border border-zinc-100 bg-white p-6 shadow-md shadow-zinc-200/50 transition hover:border-giftos/35 hover:shadow-lg hover:shadow-giftos/10"
            >
                <h2 class="text-xl font-bold text-zinc-900 group-hover:text-giftos-dark">View Orders</h2>
                <p class="mt-2 flex-1 text-sm text-zinc-600">Review orders, delivery details, and statuses.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-giftos-dark">Open</span>
            </a>
        </div>
    </div>
@endsection
