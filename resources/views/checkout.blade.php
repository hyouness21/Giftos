@extends('layouts.app')

@section('title', 'Checkout — GIFTOS')

@section('content')
    @php
        $deliveryUsd = 4;
        $orderLbp    = round($orderUsd * $lbpPerUsd);
    @endphp

    {{-- Success screen (hidden until order placed) --}}
    <div id="success-screen" class="hidden">
        <div class="mx-auto max-w-md px-4 py-20 text-center sm:px-6">
            {{-- Animated checkmark --}}
            <div class="relative mx-auto mb-8 flex h-24 w-24 items-center justify-center">
                <div class="absolute inset-0 animate-ping rounded-full bg-giftos/20"></div>
                <div class="relative flex h-24 w-24 items-center justify-center rounded-full bg-giftos/10 ring-4 ring-giftos/30">
                    <svg class="h-12 w-12 text-giftos" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-zinc-900">Order placed!</h2>
            <p class="mt-3 text-zinc-500 leading-relaxed">
                Your order is ready to send. Tap below to open WhatsApp and send it directly to us — we'll get back to you shortly.
            </p>

            {{-- WhatsApp button --}}
            <a id="success-wa-link" href="#" target="_blank"
                class="mt-8 flex w-full items-center justify-center gap-3 rounded-2xl py-4 text-base font-bold text-white shadow-xl transition hover:opacity-90 active:scale-95"
                style="background:#25D366">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Send Order on WhatsApp
            </a>

            {{-- Copy fallback --}}
            <div id="success-copy-wrap" class="mt-4 hidden">
                <textarea id="success-message" readonly rows="8"
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 font-mono text-xs text-zinc-700 outline-none"></textarea>
                <button type="button" id="success-copy-btn"
                    class="mt-2 w-full rounded-xl border border-zinc-200 py-3 text-sm font-semibold text-zinc-600 transition hover:bg-zinc-50">
                    <span id="success-copy-label">Copy message</span>
                </button>
            </div>

            <a href="{{ url('/track') }}"
                class="mt-6 flex w-full items-center justify-center gap-2 rounded-2xl border-2 border-giftos/30 bg-white py-3.5 text-sm font-semibold text-giftos-dark transition hover:border-giftos hover:bg-giftos-muted">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                Track Your Order
            </a>

            <a href="{{ url('/products') }}"
                class="mt-3 block text-sm font-semibold text-giftos-dark hover:text-giftos">
                ← Continue Shopping
            </a>
        </div>
    </div>

    {{-- Checkout form (hidden after order placed) --}}
    <div id="checkout-main" class="mx-auto max-w-5xl px-3 pt-2 pb-6 sm:py-10 sm:px-6 lg:px-8">
        <header class="mb-3 sm:mb-8">
            <h1 class="text-xl font-bold text-zinc-900 sm:text-3xl">Checkout</h1>
            <p class="mt-0.5 text-xs text-zinc-500 sm:mt-2 sm:text-base sm:text-zinc-600">Fill in your details and send your order via WhatsApp.</p>
        </header>

        <div class="grid gap-3 lg:grid-cols-3 lg:gap-10">

            {{-- Order summary: top on mobile, right column on desktop --}}
            <aside class="lg:col-span-1 lg:order-last">
                <div class="sticky top-24 rounded-2xl border border-giftos/20 bg-white shadow-lg shadow-giftos/10">

                    {{-- Mobile: compact horizontal total bar --}}
                    <div class="flex items-center justify-between gap-4 px-4 py-3 lg:hidden">
                        <div class="flex items-center gap-2 min-w-0">
                            <svg class="h-4 w-4 shrink-0 text-giftos" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                            </svg>
                            <span class="text-sm font-semibold text-zinc-800">{{ count($lines) }} item{{ count($lines) !== 1 ? 's' : '' }}</span>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-base font-bold text-giftos-dark" id="summary-total-usd-mobile">${{ number_format($orderUsd + $deliveryUsd, 2) }}</p>
                            <p class="text-xs text-zinc-400" id="summary-total-lbp-mobile">LBP {{ number_format(round(($orderUsd + $deliveryUsd) * $lbpPerUsd)) }}</p>
                        </div>
                    </div>

                    {{-- Mobile: collapsible item list --}}
                    <details class="border-t border-zinc-100 lg:hidden">
                        <summary class="cursor-pointer px-4 py-2 text-xs font-semibold text-giftos-dark select-none">Show items</summary>
                        <ul class="space-y-2 px-4 pb-3 pt-1">
                            @foreach ($lines as $item)
                                <li class="flex items-center justify-between gap-2 text-xs">
                                    <div class="flex items-center gap-2 min-w-0">
                                        @if ($item['img'])
                                            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                                                class="h-7 w-7 shrink-0 rounded-md object-cover border border-zinc-100" />
                                        @endif
                                        <span class="truncate text-zinc-600">{{ $item['name'] }} <span class="text-zinc-400">×{{ $item['qty'] }}</span></span>
                                    </div>
                                    <span class="shrink-0 font-medium text-zinc-800">${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </details>

                    {{-- Desktop: full summary --}}
                    <div class="hidden p-4 lg:block">
                        <h2 class="text-sm font-semibold text-zinc-900">Order summary</h2>

                        @if ($lines)
                            <ul class="mt-3 space-y-2 border-b border-zinc-100 pb-3">
                                @foreach ($lines as $item)
                                    <li class="flex items-center justify-between gap-2 text-xs">
                                        <div class="flex items-center gap-2 min-w-0">
                                            @if ($item['img'])
                                                <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                                                    class="h-7 w-7 shrink-0 rounded-md object-cover border border-zinc-100" />
                                            @endif
                                            <span class="truncate text-zinc-600">{{ $item['name'] }}
                                                <span class="text-zinc-400">×{{ $item['qty'] }}</span>
                                            </span>
                                        </div>
                                        <span class="shrink-0 font-medium text-zinc-900">
                                            ${{ number_format($item['price'] * $item['qty'], 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <dl class="mt-3 space-y-1.5 text-xs">
                                <div class="flex justify-between text-zinc-500">
                                    <dt>Subtotal</dt>
                                    <dd>${{ number_format($orderUsd, 2) }}</dd>
                                </div>
                                <div id="summary-delivery-row" class="flex justify-between text-zinc-500">
                                    <dt>Delivery</dt>
                                    <dd id="summary-delivery-amt">${{ number_format($deliveryUsd, 2) }}</dd>
                                </div>
                                <div class="flex justify-between border-t border-zinc-100 pt-2 text-zinc-900">
                                    <dt class="font-bold text-sm">Total (USD)</dt>
                                    <dd class="font-bold text-sm text-giftos-dark" id="summary-total-usd">${{ number_format($orderUsd + $deliveryUsd, 2) }}</dd>
                                </div>
                                <div class="flex justify-between text-zinc-500">
                                    <dt>LBP</dt>
                                    <dd class="font-semibold text-zinc-800" id="summary-total-lbp">{{ number_format(round(($orderUsd + $deliveryUsd) * $lbpPerUsd)) }}</dd>
                                </div>
                            </dl>
                            <p class="mt-2 text-xs text-zinc-400">1 USD ≈ {{ number_format($lbpPerUsd) }} LBP</p>
                        @else
                            <p class="mt-3 text-xs text-zinc-400">Your cart is empty.</p>
                        @endif

                        <a href="{{ url('/cart') }}" class="mt-4 block text-center text-xs font-semibold text-giftos-dark hover:text-giftos">← Back to cart</a>
                    </div>
                </div>
            </aside>

            <section class="lg:col-span-2">
                <div class="rounded-2xl border border-zinc-100 bg-white p-3 shadow-md shadow-zinc-200/50 sm:p-8">
                    <h2 class="text-sm font-semibold text-zinc-900 sm:text-lg">Delivery details</h2>
                    <p class="mt-0.5 text-xs text-zinc-400 sm:mt-1 sm:text-sm sm:text-zinc-500">We will include this in your WhatsApp order message.</p>

                    <form class="mt-3 space-y-3 sm:mt-6 sm:space-y-5" id="checkout-form" novalidate>
                        <div>
                            <label for="full_name" class="mb-1 block text-xs font-medium text-zinc-700 sm:mb-1.5 sm:text-sm">Full name <span class="text-red-500">*</span></label>
                            <input
                                id="full_name" type="text"
                                class="field w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30 sm:rounded-xl sm:px-4 sm:py-3"
                                placeholder="Hussein Youness" autocomplete="name"
                            />
                            <p id="full_name-error" class="mt-1 hidden text-xs text-red-600">Full name is required.</p>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium text-zinc-700 sm:mb-1.5 sm:text-sm">Phone number <span class="text-red-500">*</span></label>
                            <x-phone-input id="phone" name="phone" />
                            <p id="phone-error" class="mt-1 hidden text-xs text-red-600">Phone number is required.</p>
                        </div>
                        <div>
                            <label for="address" class="mb-1 block text-xs font-medium text-zinc-700 sm:mb-1.5 sm:text-sm">Address <span class="text-red-500">*</span></label>
                            <textarea
                                id="address" rows="2"
                                class="field w-full resize-y rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30 sm:rounded-xl sm:px-4 sm:py-3"
                                placeholder="Street, building, floor, city" autocomplete="street-address"
                            ></textarea>
                            <p id="address-error" class="mt-1 hidden text-xs text-red-600">Address is required.</p>
                        </div>

                        {{-- Delivery / Pickup toggle --}}
                        <div>
                            <p class="mb-2 text-sm font-medium text-zinc-700">How would you like to receive your order?</p>
                            <div class="flex flex-col gap-2">

                                {{-- Delivery --}}
                                <label class="group relative flex cursor-pointer items-center gap-3 rounded-xl border-2 border-zinc-200 bg-white px-4 py-3 shadow-sm transition has-checked:border-giftos has-checked:bg-giftos-muted">
                                    <input type="radio" name="fulfillment" value="delivery" class="sr-only" checked />
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-zinc-100 transition group-has-checked:bg-giftos/15">
                                        <svg class="h-5 w-5 text-zinc-400 transition group-has-checked:text-giftos" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                                        </svg>
                                    </span>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-zinc-800">Delivery</p>
                                        <p class="text-xs font-semibold text-giftos-dark">+${{ number_format($deliveryUsd, 2) }}</p>
                                    </div>
                                    <span class="hidden h-5 w-5 shrink-0 items-center justify-center rounded-full bg-giftos group-has-checked:flex">
                                        <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                </label>

                                {{-- Pickup --}}
                                <label class="group relative flex cursor-pointer items-center gap-3 rounded-xl border-2 border-zinc-200 bg-white px-4 py-3 shadow-sm transition has-checked:border-giftos has-checked:bg-giftos-muted">
                                    <input type="radio" name="fulfillment" value="pickup" class="sr-only" />
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-zinc-100 transition group-has-checked:bg-giftos/15">
                                        <svg class="h-5 w-5 text-zinc-400 transition group-has-checked:text-giftos" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                                        </svg>
                                    </span>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-zinc-800">Pickup</p>
                                        <p class="text-xs font-semibold text-green-600">Free</p>
                                    </div>
                                    <span class="hidden h-5 w-5 shrink-0 items-center justify-center rounded-full bg-giftos group-has-checked:flex">
                                        <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                </label>

                            </div>
                        </div>

                        <button type="button" id="place-order-btn"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-giftos py-3 text-sm font-semibold text-white shadow-lg shadow-giftos/30 transition hover:bg-giftos-dark sm:py-4 sm:text-base">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Place Order via WhatsApp
                        </button>
                    </form>
                </div>

            </section>

        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    const ADMIN_PHONE  = '96181714898';
    const LINES        = @json($lines);
    const ORDER_USD    = {{ $orderUsd }};
    const DELIVERY_USD = {{ $deliveryUsd }};
    const LBP_RATE     = {{ $lbpPerUsd }};

    function isDelivery() {
        return document.querySelector('input[name="fulfillment"]:checked')?.value === 'delivery';
    }

    function updateSummary() {
        const delivery = isDelivery() ? DELIVERY_USD : 0;
        const grand    = ORDER_USD + delivery;
        const usdStr   = '$' + grand.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const lbpStr   = 'LBP ' + Math.round(grand * LBP_RATE).toLocaleString('en-US');
        document.getElementById('summary-delivery-row').classList.toggle('hidden', !isDelivery());
        document.getElementById('summary-total-usd').textContent = usdStr;
        document.getElementById('summary-total-lbp').textContent = lbpStr;
        document.getElementById('summary-total-usd-mobile').textContent = usdStr;
        document.getElementById('summary-total-lbp-mobile').textContent = lbpStr;
    }

    document.querySelectorAll('input[name="fulfillment"]').forEach(r => r.addEventListener('change', updateSummary));
    updateSummary();

    const ERROR_CLASSES = ['border-red-400', 'bg-red-50'];
    const OK_CLASSES    = ['border-zinc-200', 'bg-zinc-50'];

    function fullPhone() {
        const code  = document.getElementById('phone-country').value;
        const local = (document.getElementById('phone-local').value || '').replace(/[\s\-\.]/g, '');
        return code + local;
    }

    function phoneError() {
        const local = (document.getElementById('phone-local').value || '').trim();
        if (!local) return 'Phone number is required.';
        if (!/^\d{4,15}$/.test(local.replace(/[\s\-\.]/g, ''))) return 'Enter digits only (no spaces or letters).';
        return null;
    }

    function setFieldState(input, error, msg) {
        if (msg) {
            error.textContent = msg;
            error.classList.remove('hidden');
            input.classList.remove(...OK_CLASSES);
            input.classList.add(...ERROR_CLASSES);
        } else {
            error.classList.add('hidden');
            input.classList.remove(...ERROR_CLASSES);
            input.classList.add(...OK_CLASSES);
        }
    }

    function validate() {
        let valid = true;

        ['full_name', 'address'].forEach(id => {
            const input = document.getElementById(id);
            const error = document.getElementById(id + '-error');
            const msg   = input.value.trim() ? null : (id === 'full_name' ? 'Full name is required.' : 'Address is required.');
            setFieldState(input, error, msg);
            if (msg) valid = false;
        });

        const phoneLocal = document.getElementById('phone-local');
        const phoneErrEl = document.getElementById('phone-error');
        const phoneMsg   = phoneError();
        setFieldState(phoneLocal, phoneErrEl, phoneMsg);
        if (phoneMsg) valid = false;

        return valid;
    }

    ['full_name', 'address'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
            const error = document.getElementById(id + '-error');
            setFieldState(this, error, this.value.trim() ? null : '');
        });
    });

    document.getElementById('phone-local').addEventListener('input', function () {
        setFieldState(this, document.getElementById('phone-error'), phoneError());
    });

    function buildMessage(name, phone, address) {
        const delivery  = isDelivery() ? DELIVERY_USD : 0;
        const grand     = ORDER_USD + delivery;
        const grandLbp  = Math.round(grand * LBP_RATE);
        const itemLines = LINES.map(item => {
            const total = (item.price * item.qty).toFixed(2);
            return `  • ${item.name} x${item.qty}  —  $${total}`;
        }).join('\n');

        const parts = [
            '🎁 New Order — GIFTOS',
            '',
            `👤 Name: ${name}`,
            `📞 Phone: ${phone}`,
            `📍 Address: ${address}`,
            `🚚 Fulfillment: ${isDelivery() ? 'Delivery' : 'Pickup'}`,
            '',
            '🛒 Order:',
            itemLines,
            '',
            `📦 Subtotal: $${ORDER_USD.toFixed(2)}`,
        ];
        if (isDelivery()) parts.push(`🚚 Delivery: $${delivery.toFixed(2)}`);
        parts.push(`💰 Total: $${grand.toFixed(2)}  (LBP ${grandLbp.toLocaleString()})`);
        return parts.join('\n');
    }

    function clearCart() {
        fetch('/api/cart/clear', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest' },
        });
        document.querySelectorAll('.nav-cart-badge').forEach(b => b.classList.add('hidden'));
    }

    const btn = document.getElementById('place-order-btn');

    btn.addEventListener('click', async function () {
        if (!validate()) return;

        const name    = document.getElementById('full_name').value.trim();
        const phone   = fullPhone();
        const address = document.getElementById('address').value.trim();

        btn.disabled = true;
        btn.textContent = 'Placing order…';

        try {
            await fetch('/api/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    name, phone, address,
                    items: LINES,
                    total_usd: ORDER_USD + (isDelivery() ? DELIVERY_USD : 0),
                    total_lbp: Math.round((ORDER_USD + (isDelivery() ? DELIVERY_USD : 0)) * LBP_RATE),
                }),
            });
        } catch (e) {
            // Non-blocking: order save failure shouldn't block the user
        }

        const message  = buildMessage(name, phone, address);
        const waUrl    = `https://wa.me/${ADMIN_PHONE}?text=${encodeURIComponent(message)}`;
        const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        clearCart();

        document.getElementById('success-wa-link').href = waUrl;

        if (!isMobile) {
            document.getElementById('success-message').value = message;
            document.getElementById('success-copy-wrap').classList.remove('hidden');
        }

        document.getElementById('checkout-main').classList.add('hidden');
        document.getElementById('success-screen').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Copy to clipboard (success screen)
    document.getElementById('success-copy-btn').addEventListener('click', function () {
        const text  = document.getElementById('success-message').value;
        const label = document.getElementById('success-copy-label');
        navigator.clipboard.writeText(text).then(() => {
            label.textContent = 'Copied!';
            setTimeout(() => { label.textContent = 'Copy message'; }, 2500);
        });
    });
})();
</script>
@endpush
