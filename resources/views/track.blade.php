@extends('layouts.app')

@section('title', 'Track Order — GIFTOS')

@section('content')
    @php
        $statusConfig = [
            'new'        => ['label' => 'Order Received',  'color' => 'bg-blue-50 text-blue-700 ring-blue-200',     'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z'],
            'accepted'   => ['label' => 'Accepted',        'color' => 'bg-teal-50 text-teal-700 ring-teal-200',      'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            'processing' => ['label' => 'Being Prepared',  'color' => 'bg-yellow-50 text-yellow-700 ring-yellow-200','icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            'in_transit' => ['label' => 'On the Way',      'color' => 'bg-purple-50 text-purple-700 ring-purple-200', 'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
            'completed'  => ['label' => 'Delivered',       'color' => 'bg-green-50 text-green-700 ring-green-200',   'icon' => 'M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z'],
        ];
    @endphp

    {{-- Hero banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-giftos/10 via-white to-giftos/5 py-14">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(64,224,208,0.15),transparent_55%)]"></div>
        <div class="relative mx-auto max-w-2xl px-4 text-center sm:px-6">

            {{-- Truck icon with animated ping --}}
            <div class="relative mx-auto mb-6 w-fit">
                <div class="absolute inset-0 animate-ping rounded-full bg-giftos/20 [animation-duration:2.5s]"></div>
                <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-white shadow-lg shadow-giftos/20 ring-4 ring-giftos/25">
                    <svg class="h-10 w-10 text-giftos" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-zinc-900 sm:text-4xl">Track Your Order</h1>
            <p class="mt-3 text-zinc-500">Enter the phone number you used when placing your order.</p>

            {{-- Search form --}}
            <form method="GET" action="{{ url('/track') }}" class="mt-8 flex flex-col gap-3 sm:flex-row">
                <div class="flex-1">
                    <x-phone-input id="track-phone" name="phone" />
                </div>
                <button type="submit"
                    class="shrink-0 rounded-2xl bg-giftos px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-giftos/30 transition hover:bg-giftos-dark active:scale-95">
                    Search
                </button>
            </form>

            @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Results --}}
        @if ($orders !== null)
            @if ($orders->isEmpty())
                <div class="mt-10 rounded-2xl border border-zinc-100 bg-white p-10 text-center shadow-md shadow-zinc-200/40">
                    <p class="text-zinc-500">No orders found for <span class="font-semibold text-zinc-700">{{ $phone }}</span>.</p>
                    <p class="mt-1 text-sm text-zinc-400">Make sure you enter the same number used at checkout.</p>
                </div>
            @else
                <p class="mt-8 text-sm font-medium text-zinc-500">{{ $orders->count() }} order{{ $orders->count() !== 1 ? 's' : '' }} found for <span class="font-semibold text-zinc-700">{{ $phone }}</span></p>

                <div class="mt-3 space-y-5">
                    @foreach ($orders as $order)
                        @php $cfg = $statusConfig[$order->status] ?? $statusConfig['new']; @endphp
                        <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/40">

                            {{-- Order header --}}
                            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-100 bg-zinc-50 px-5 py-4">
                                <div>
                                    <p class="text-xs text-zinc-400">Order #{{ $order->id }} &mdash; {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    <p class="mt-0.5 text-sm font-semibold text-zinc-800">{{ $order->name }}</p>
                                </div>
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $cfg['color'] }}">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cfg['icon'] }}"/>
                                    </svg>
                                    {{ $cfg['label'] }}
                                </span>
                            </div>

                            {{-- Items --}}
                            <ul class="divide-y divide-zinc-100 px-5">
                                @foreach ($order->items as $item)
                                    <li class="flex items-center justify-between gap-4 py-3 text-sm">
                                        <div class="flex items-center gap-3 min-w-0">
                                            @if (!empty($item['img']))
                                                <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                                                    class="h-9 w-9 shrink-0 rounded-lg border border-zinc-100 object-cover"/>
                                            @endif
                                            <span class="truncate text-zinc-700">{{ $item['name'] }}
                                                <span class="text-zinc-400">× {{ $item['qty'] }}</span>
                                            </span>
                                        </div>
                                        <span class="shrink-0 font-medium text-zinc-900">
                                            ${{ number_format($item['price'] * $item['qty'], 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Footer --}}
                            <div class="flex items-center justify-between border-t border-zinc-100 bg-zinc-50 px-5 py-3">
                                <span class="text-xs text-zinc-400">{{ $order->address }}</span>
                                <span class="text-base font-bold text-giftos-dark">${{ number_format($order->total_usd, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
@endsection
