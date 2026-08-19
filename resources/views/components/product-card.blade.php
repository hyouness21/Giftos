@props([
    'image'    => '',
    'name'     => '',
    'description' => '',
    'price'    => '',
    'inStock'  => true,
])

@php
    $qty       = session('cart', [])[md5($name)]['qty'] ?? 0;
    $favorited = isset(session('favorites', [])[md5($name)]);
@endphp

<article
    class="flex flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/50 transition hover:border-giftos/30 hover:shadow-lg hover:shadow-giftos/10"
    data-product-name="{{ $name }}"
    data-product-price="{{ $price }}"
    data-product-img="{{ $image }}"
    data-product-description="{{ $description }}"
    data-product-in-stock="{{ $inStock ? 'true' : 'false' }}"
>
    <div class="relative">
        <button type="button"
            class="img-zoom-btn aspect-4/3 overflow-hidden bg-giftos-muted w-full cursor-zoom-in"
            data-src="{{ $image }}" data-alt="{{ $name }}"
            aria-label="View full image of {{ $name }}">
            <img src="{{ $image }}" alt="{{ $name }}" class="h-full w-full object-cover {{ !$inStock ? 'opacity-50' : '' }}" loading="lazy" width="400" height="300" />
        </button>
        @if (!$inStock)
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <span class="rounded-full bg-zinc-800/80 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-white backdrop-blur-sm">Out of Stock</span>
            </div>
        @endif
    </div>
    <div class="flex flex-1 flex-col gap-3 p-4 sm:p-5">
        <div class="flex-1 space-y-1">
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-lg font-semibold text-zinc-900 leading-snug">{{ $name }}</h3>
                {{-- Favorite star button --}}
                <button type="button"
                    class="fav-btn shrink-0 mt-0.5 transition-transform duration-150 hover:scale-125 active:scale-95"
                    aria-label="{{ $favorited ? 'Remove from favorites' : 'Add to favorites' }}"
                    data-favorited="{{ $favorited ? 'true' : 'false' }}">
                    <svg class="fav-icon-outline h-6 w-6 text-zinc-300 {{ $favorited ? 'hidden' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <svg class="fav-icon-filled h-6 w-6 text-giftos {{ $favorited ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm leading-relaxed text-zinc-600">{{ $description }}</p>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-zinc-100 pt-4">
            <p class="text-lg font-bold {{ $inStock ? 'text-giftos-dark' : 'text-zinc-400' }}">${{ $price }}</p>
            @if ($inStock)
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="cart-btn minus-btn flex h-9 w-9 select-none items-center justify-center rounded-lg border text-lg font-medium transition-all duration-150 active:scale-90
                            {{ $qty > 0 ? 'border-giftos bg-giftos-muted text-giftos-dark hover:bg-giftos/20' : 'border-zinc-200 bg-white text-zinc-400 hover:border-giftos hover:bg-giftos-muted hover:text-giftos-dark' }}"
                        data-delta="-1" aria-label="Decrease quantity">−</button>
                    <span class="cart-qty min-w-8 text-center text-sm font-bold transition-all duration-150
                        {{ $qty > 0 ? 'text-giftos-dark' : 'text-zinc-400' }}">{{ $qty }}</span>
                    <button type="button"
                        class="cart-btn plus-btn flex h-9 w-9 select-none items-center justify-center rounded-lg border text-lg font-medium transition-all duration-150 active:scale-90
                            {{ $qty > 0 ? 'border-giftos bg-giftos text-white hover:bg-giftos-dark' : 'border-zinc-200 bg-white text-zinc-700 hover:border-giftos hover:bg-giftos-muted hover:text-giftos-dark' }}"
                        data-delta="1" aria-label="Increase quantity">+</button>
                </div>
            @else
                <span class="text-xs font-semibold text-zinc-400">Unavailable</span>
            @endif
        </div>
    </div>
</article>

@once
@push('body')
{{-- Lightbox --}}
<div id="img-lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4" role="dialog" aria-modal="true">
    <div class="relative inline-block">
        <img id="lightbox-img" src="" alt="" class="max-h-[90vh] max-w-full rounded-2xl object-contain shadow-2xl" />
        <button type="button" id="lightbox-close"
            class="absolute top-3 right-3 z-10 text-white transition hover:text-zinc-300"
            style="filter:drop-shadow(0 1px 3px rgba(0,0,0,0.6))">
            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
@endpush

@push('scripts')
<style>
@keyframes qty-pop {
    0%   { transform: scale(1); }
    40%  { transform: scale(1.45); }
    70%  { transform: scale(0.9); }
    100% { transform: scale(1); }
}
@keyframes btn-ping {
    0%   { box-shadow: 0 0 0 0 rgba(45,184,168,0.5); }
    100% { box-shadow: 0 0 0 8px rgba(45,184,168,0); }
}
.qty-pop  { animation: qty-pop  0.35s cubic-bezier(.36,.07,.19,.97); }
.btn-ping { animation: btn-ping 0.4s ease-out; }
</style>
<script>
function applyCartUI(card, btn, qty) {
    const qtyEl    = card.querySelector('.cart-qty');
    const plusBtn  = card.querySelector('.plus-btn');
    const minusBtn = card.querySelector('.minus-btn');

    // Animate qty number
    qtyEl.classList.remove('qty-pop');
    void qtyEl.offsetWidth;
    qtyEl.classList.add('qty-pop');
    qtyEl.textContent = qty;

    // Ping the clicked button
    btn.classList.remove('btn-ping');
    void btn.offsetWidth;
    btn.classList.add('btn-ping');
    setTimeout(() => btn.classList.remove('btn-ping'), 450);

    // Qty label color
    qtyEl.classList.toggle('text-giftos-dark', qty > 0);
    qtyEl.classList.toggle('text-zinc-400',    qty === 0);

    // + button
    plusBtn.classList.toggle('border-giftos',        qty > 0);
    plusBtn.classList.toggle('bg-giftos',            qty > 0);
    plusBtn.classList.toggle('text-white',           qty > 0);
    plusBtn.classList.toggle('hover:bg-giftos-dark', qty > 0);
    plusBtn.classList.toggle('border-zinc-200',      qty === 0);
    plusBtn.classList.toggle('bg-white',             qty === 0);
    plusBtn.classList.toggle('text-zinc-700',        qty === 0);

    // - button
    minusBtn.classList.toggle('border-giftos',    qty > 0);
    minusBtn.classList.toggle('bg-giftos-muted',  qty > 0);
    minusBtn.classList.toggle('text-giftos-dark', qty > 0);
    minusBtn.classList.toggle('border-zinc-200',  qty === 0);
    minusBtn.classList.toggle('bg-white',         qty === 0);
    minusBtn.classList.toggle('text-zinc-400',    qty === 0);
}

function applyNavBadge(count) {
    document.querySelectorAll('.nav-cart-badge').forEach(function (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    });
}

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.cart-btn');
    if (!btn) return;

    const card  = btn.closest('[data-product-name]');
    if (!card) return;

    const name  = card.dataset.productName;
    const price = card.dataset.productPrice;
    const img   = card.dataset.productImg;
    const delta = parseInt(btn.dataset.delta, 10);
    const csrf  = document.querySelector('meta[name="csrf-token"]').content;

    // --- Optimistic update (instant) ---
    const prevQty    = parseInt(card.querySelector('.cart-qty').textContent, 10) || 0;
    const optimistic = Math.max(0, prevQty + delta);

    const prevBadgeEl  = document.querySelector('.nav-cart-badge');
    const prevBadgeNum = prevBadgeEl ? (parseInt(prevBadgeEl.textContent, 10) || 0) : 0;
    const optimisticBadge = Math.max(0, prevBadgeNum + delta);

    applyCartUI(card, btn, optimistic);
    applyNavBadge(optimisticBadge);

    // --- Background sync ---
    fetch('/api/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ name, price, img, delta }),
    })
    .then(r => r.json())
    .then(data => {
        // Reconcile if server differs (e.g. went below 0)
        if (data.qty !== undefined && data.qty !== optimistic) {
            applyCartUI(card, btn, data.qty);
        }
        if (data.cart_count !== undefined) {
            applyNavBadge(data.cart_count);
        }
    })
    .catch(() => {
        // Revert on network error
        applyCartUI(card, btn, prevQty);
        applyNavBadge(prevBadgeNum);
    });
});

// ── Favorites ──────────────────────────────────────────────────────
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.fav-btn');
    if (!btn) return;

    const card        = btn.closest('article');
    const name        = card.dataset.productName;
    const price       = card.dataset.productPrice;
    const img         = card.dataset.productImg;
    const description = card.dataset.productDescription;
    const inStock     = card.dataset.productInStock;
    const outline     = btn.querySelector('.fav-icon-outline');
    const filled      = btn.querySelector('.fav-icon-filled');

    // Optimistic update — flip instantly
    const wasFavorited = btn.dataset.favorited === 'true';
    const nowFavorited = !wasFavorited;
    btn.dataset.favorited = nowFavorited ? 'true' : 'false';
    btn.setAttribute('aria-label', nowFavorited ? 'Remove from favorites' : 'Add to favorites');
    outline.classList.toggle('hidden', nowFavorited);
    filled.classList.toggle('hidden', !nowFavorited);
    btn.animate([{transform:'scale(1)'},{transform:'scale(1.4)'},{transform:'scale(1)'}], {duration:250, easing:'ease-out'});

    fetch('/api/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ name, price, img, description, in_stock: inStock === 'true' }),
    })
    .then(function (r) {
        if (!r.ok) throw new Error('server error');
        return r.json();
    })
    .then(function (data) {
        document.querySelectorAll('.nav-fav-badge').forEach(function (badge) {
            badge.textContent = data.favorite_count > 99 ? '99+' : data.favorite_count;
            badge.classList.toggle('hidden', data.favorite_count === 0);
        });
    })
    .catch(function () {
        // Revert on failure
        btn.dataset.favorited = wasFavorited ? 'true' : 'false';
        btn.setAttribute('aria-label', wasFavorited ? 'Remove from favorites' : 'Add to favorites');
        outline.classList.toggle('hidden', wasFavorited);
        filled.classList.toggle('hidden', !wasFavorited);
    });
});

// ── Lightbox ───────────────────────────────────────────────────────
(function () {
    const lightbox = document.getElementById('img-lightbox');
    const lbImg    = document.getElementById('lightbox-img');

    function openLightbox(src, alt) {
        lbImg.src = src;
        lbImg.alt = alt;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
        lbImg.src = '';
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.img-zoom-btn');
        if (btn) { openLightbox(btn.dataset.src, btn.dataset.alt); return; }
        if (e.target === lightbox) closeLightbox();
    });

    document.getElementById('lightbox-close').addEventListener('click', closeLightbox);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLightbox();
    });
})();
</script>
@endpush
@endonce
