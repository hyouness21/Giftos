@php
    $linkBase       = 'rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-200 text-zinc-600 hover:text-giftos hover:bg-giftos-muted';
    $active         = 'text-giftos bg-giftos-muted font-semibold';
    $mobileLinkBase = 'block rounded-lg px-4 py-2.5 text-sm font-medium transition-colors duration-200 text-zinc-600 hover:text-giftos hover:bg-giftos-muted';
    $cartCount      = array_sum(array_column(session('cart', []), 'qty'));
@endphp

<header class="sticky top-0 z-50 border-b border-giftos/15 bg-white/90 shadow-sm shadow-zinc-200/40 backdrop-blur-md">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-2 sm:px-6 lg:px-8">

        {{-- Logo (left) --}}
        <x-logo />

        {{-- Desktop nav (right) --}}
        <nav class="hidden sm:flex items-center gap-1" aria-label="Main">
            <a href="{{ url('/') }}"           class="{{ $linkBase }} {{ request()->is('/') ? $active : '' }}">Home</a>
            <a href="{{ url('/products') }}"  class="{{ $linkBase }} {{ request()->is('products', 'products/*') ? $active : '' }}">Products</a>
            <a href="{{ url('/wholesale') }}" class="{{ $linkBase }} {{ request()->is('wholesale') ? $active : '' }}">Wholesale</a>
            <a href="{{ url('/track') }}"     class="{{ $linkBase }} {{ request()->is('track') ? $active : '' }}">Track Order</a>
            <a href="{{ url('/cart') }}"      class="{{ $linkBase }} {{ request()->is('cart') ? $active : '' }}">Cart</a>
            @if (session('giftos_admin'))
                <a href="{{ url('/admin') }}" class="{{ $linkBase }} {{ request()->is('admin', 'admin/*') ? $active : '' }}">Admin</a>
                <a href="{{ url('/admin/logout') }}" class="{{ $linkBase }} text-red-500 hover:text-red-600 hover:bg-red-50">Logout</a>
            @endif
        </nav>

        {{-- Mobile: cart icon + hamburger --}}
        <div class="flex sm:hidden items-center gap-1">
            <a href="{{ url('/cart') }}"
                class="relative flex items-center justify-center rounded-lg p-2 text-zinc-600 hover:bg-giftos-muted hover:text-giftos transition"
                aria-label="Cart">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="nav-cart-badge absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-giftos text-[10px] font-bold text-white leading-none {{ $cartCount > 0 ? '' : 'hidden' }}">
                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                </span>
            </a>
            <button type="button" id="nav-hamburger"
                class="flex items-center justify-center rounded-lg p-2 text-zinc-600 hover:bg-giftos-muted hover:text-giftos transition">
                <svg id="hamburger-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Desktop cart icon --}}
        <a href="{{ url('/cart') }}"
            class="hidden sm:flex relative items-center justify-center rounded-lg p-2 text-zinc-600 hover:bg-giftos-muted hover:text-giftos transition {{ request()->is('cart') ? 'text-giftos bg-giftos-muted' : '' }}"
            aria-label="Cart">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            @if ($cartCount > 0)
                <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-giftos text-[10px] font-bold text-white leading-none">
                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                </span>
            @endif
        </a>
    </div>

    {{-- Mobile dropdown menu --}}
    <div id="mobile-menu" class="hidden sm:hidden border-t border-zinc-100 bg-white px-4 pb-4 pt-2">
        <nav class="flex flex-col gap-1" aria-label="Mobile">
            <a href="{{ url('/') }}"           class="{{ $mobileLinkBase }} {{ request()->is('/') ? $active : '' }}">Home</a>
            <a href="{{ url('/products') }}"  class="{{ $mobileLinkBase }} {{ request()->is('products', 'products/*') ? $active : '' }}">Products</a>
            <a href="{{ url('/wholesale') }}" class="{{ $mobileLinkBase }} {{ request()->is('wholesale') ? $active : '' }}">Wholesale</a>
            <a href="{{ url('/track') }}"     class="{{ $mobileLinkBase }} {{ request()->is('track') ? $active : '' }}">Track Order</a>
            <a href="{{ url('/cart') }}"      class="{{ $mobileLinkBase }} {{ request()->is('cart') ? $active : '' }}">Cart</a>
            @if (session('giftos_admin'))
                <a href="{{ url('/admin') }}" class="{{ $mobileLinkBase }} {{ request()->is('admin', 'admin/*') ? $active : '' }}">Admin</a>
                <a href="{{ url('/admin/logout') }}" class="{{ $mobileLinkBase }} text-red-500 hover:text-red-600 hover:bg-red-50">Logout</a>
            @endif
        </nav>
    </div>
</header>

@once
@push('scripts')
<script>
(function () {
    const btn           = document.getElementById('nav-hamburger');
    const menu          = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon     = document.getElementById('close-icon');

    btn.addEventListener('click', function () {
        const open = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden', open);
        hamburgerIcon.classList.toggle('hidden', !open);
        closeIcon.classList.toggle('hidden', open);
    });

    menu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            menu.classList.add('hidden');
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        });
    });
})();
</script>
@endpush
@endonce
