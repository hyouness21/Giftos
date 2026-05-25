@extends('layouts.app')

@section('title', 'Cart — GIFTOS')

@section('content')
    @php
        $lbpPerUsd   = 89500;
        $subtotalUsd = array_reduce($lines, fn ($carry, $l) => $carry + $l['qty'] * $l['price'], 0);
        $subtotalLbp = round($subtotalUsd * $lbpPerUsd);
    @endphp

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-zinc-900">Your cart</h1>
        </header>

        @if (count($lines) === 0)
            <div class="rounded-2xl border border-zinc-100 bg-white p-10 text-center shadow-md shadow-zinc-200/40">
                <p class="text-zinc-500">Your cart is empty.</p>
                <a href="{{ url('/products') }}" class="mt-4 inline-block text-sm font-semibold text-giftos-dark hover:text-giftos">
                    Browse products →
                </a>
            </div>
        @else
            <div class="space-y-4" id="cart-lines">
                @foreach ($lines as $line)
                    @php $lineSub = $line['qty'] * $line['price']; @endphp
                    <article
                        class="flex flex-col gap-4 rounded-2xl border border-zinc-100 bg-white p-4 shadow-md shadow-zinc-200/40 sm:flex-row sm:items-center sm:gap-6 sm:p-5"
                        data-product-name="{{ $line['name'] }}"
                        data-product-price="{{ $line['price'] }}"
                        data-product-img="{{ $line['img'] }}"
                    >
                        <img
                            src="{{ $line['img'] }}"
                            alt="{{ $line['name'] }}"
                            class="h-24 w-full rounded-xl object-cover sm:h-20 sm:w-20 sm:shrink-0"
                            width="120"
                            height="120"
                            loading="lazy"
                        />
                        <div class="min-w-0 flex-1">
                            <h2 class="text-lg font-semibold text-zinc-900">{{ $line['name'] }}</h2>
                            <p class="mt-1 text-sm text-zinc-500">${{ number_format($line['price'], 2) }} each</p>
                            <div class="mt-4 flex flex-wrap items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium uppercase tracking-wide text-zinc-500">Qty</span>
                                    <button
                                        type="button"
                                        class="cart-btn flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-lg font-medium text-zinc-700 transition hover:border-giftos hover:bg-giftos-muted"
                                        data-delta="-1"
                                        aria-label="Decrease quantity"
                                    >
                                        −
                                    </button>
                                    <span class="cart-qty min-w-8 text-center text-sm font-bold text-zinc-900">{{ $line['qty'] }}</span>
                                    <button
                                        type="button"
                                        class="cart-btn flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-lg font-medium text-zinc-700 transition hover:border-giftos hover:bg-giftos-muted"
                                        data-delta="1"
                                        aria-label="Increase quantity"
                                    >
                                        +
                                    </button>
                                </div>
                                <button
                                    type="button"
                                    class="cart-remove text-sm font-semibold text-red-600 underline-offset-2 hover:underline"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                        <div class="text-right sm:shrink-0">
                            <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Subtotal</p>
                            <p class="cart-line-sub text-xl font-bold text-giftos-dark">${{ number_format($lineSub, 2) }}</p>
                            <p class="cart-line-lbp mt-1 text-sm text-zinc-500">LBP {{ number_format(round($lineSub * $lbpPerUsd)) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 rounded-2xl border border-giftos/25 bg-white p-6 shadow-lg shadow-giftos/5 sm:p-8">
                <h2 class="text-lg font-semibold text-zinc-900">Order totals</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between text-zinc-600">
                        <dt>Subtotal (USD)</dt>
                        <dd class="font-medium text-zinc-900" id="total-usd">${{ number_format($subtotalUsd, 2) }}</dd>
                    </div>
                    <div class="flex justify-between border-t border-zinc-100 pt-3 text-zinc-600">
                        <dt>Total (Lebanese LBP)</dt>
                        <dd class="font-semibold text-zinc-900" id="total-lbp">LBP {{ number_format($subtotalLbp) }}</dd>
                    </div>
                </dl>
                <p class="mt-3 text-xs text-zinc-400">LBP amount uses a placeholder rate of 1 USD = {{ number_format($lbpPerUsd) }} LBP for display.</p>
                <a
                    href="{{ url('/checkout') }}"
                    class="mt-6 flex w-full items-center justify-center rounded-xl bg-giftos py-3.5 text-base font-semibold text-white shadow-lg shadow-giftos/25 transition hover:bg-giftos-dark"
                >
                    Proceed to checkout
                </a>
                <a
                    href="{{ url('/products') }}"
                    class="mt-3 block text-center text-sm font-semibold text-giftos-dark hover:text-giftos"
                >
                    Continue shopping
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
(function () {
    const LBP = {{ $lbpPerUsd }};

    function fmt(n) { return n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
    function fmtInt(n) { return Math.round(n).toLocaleString('en-US'); }

    function recalcTotals() {
        let subtotal = 0;
        document.querySelectorAll('#cart-lines article').forEach(card => {
            const qty   = parseInt(card.querySelector('.cart-qty').textContent, 10);
            const price = parseFloat(card.dataset.productPrice);
            const sub   = qty * price;
            card.querySelector('.cart-line-sub').textContent = '$' + fmt(sub);
            card.querySelector('.cart-line-lbp').textContent = 'LBP ' + fmtInt(sub * LBP);
            subtotal += sub;
        });
        document.getElementById('total-usd').textContent = '$' + fmt(subtotal);
        document.getElementById('total-lbp').textContent = 'LBP ' + fmtInt(subtotal * LBP);
    }

    function csrf() { return document.querySelector('meta[name="csrf-token"]').content; }

    function updateNavBadge(count) {
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
        if (btn) {
            const card  = btn.closest('[data-product-name]');
            const name  = card.dataset.productName;
            const price = card.dataset.productPrice;
            const img   = card.dataset.productImg;
            const delta = parseInt(btn.dataset.delta, 10);
            btn.disabled = true;

            fetch('/api/cart/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ name, price, img, delta }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.qty === 0) {
                    card.remove();
                } else {
                    card.querySelector('.cart-qty').textContent = data.qty;
                }
                if (data.cart_count !== undefined) updateNavBadge(data.cart_count);
                recalcTotals();
            })
            .finally(() => { btn.disabled = false; });
        }

        const rem = e.target.closest('.cart-remove');
        if (rem) {
            const card = rem.closest('[data-product-name]');
            const name = card.dataset.productName;
            rem.disabled = true;

            fetch('/api/cart/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ name }),
            })
            .then(r => r.json())
            .then(data => {
                card.remove();
                if (data.cart_count !== undefined) updateNavBadge(data.cart_count);
                recalcTotals();
            });
        }
    });
})();
</script>
@endpush
