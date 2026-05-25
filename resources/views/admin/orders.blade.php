@extends('layouts.app')

@section('title', 'Admin Orders — GIFTOS')

@section('content')
    @php
        $statusColors = [
            'new'        => 'bg-blue-50 text-blue-700',
            'accepted'   => 'bg-giftos-muted text-giftos-dark',
            'processing' => 'bg-yellow-50 text-yellow-700',
            'in_transit' => 'bg-purple-50 text-purple-700',
            'completed'  => 'bg-green-50 text-green-700',
        ];
        $statusLabels = [
            'new'        => 'New',
            'accepted'   => 'Accepted',
            'processing' => 'Processing',
            'in_transit' => 'In Transit',
            'completed'  => 'Completed',
        ];
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-giftos-dark">Admin</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-zinc-900">Orders</h1>
            <p class="mt-1 text-sm text-zinc-500">{{ $orders->count() }} order{{ $orders->count() !== 1 ? 's' : '' }} total</p>
        </header>

        @if ($orders->isEmpty())
            <div class="rounded-2xl border border-zinc-100 bg-white p-12 text-center shadow-md shadow-zinc-200/40">
                <p class="text-zinc-400">No orders yet. They will appear here once customers place them.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="rounded-2xl border border-zinc-100 bg-white p-5 shadow-md shadow-zinc-200/40 sm:p-6">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="text-xs text-zinc-400">Order #{{ $order->id }} &mdash; {{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p class="mt-1 text-base font-semibold text-zinc-900">{{ $order->name }}</p>
                                <p class="text-sm text-zinc-500">{{ $order->phone }}</p>
                                <p class="text-sm text-zinc-500">{{ $order->address }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-giftos-dark">${{ number_format($order->total_usd, 2) }}</p>
                                <p class="text-xs text-zinc-400">LBP {{ number_format($order->total_lbp) }}</p>
                                <select
                                    class="status-select mt-2 rounded-lg border border-zinc-200 px-2 py-1 text-xs font-semibold outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/20 {{ $statusColors[$order->status] ?? 'bg-zinc-50 text-zinc-700' }}"
                                    data-order-id="{{ $order->id }}"
                                >
                                    @foreach ($statusLabels as $s => $label)
                                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <ul class="mt-4 divide-y divide-zinc-100 border-t border-zinc-100 pt-3">
                            @foreach ($order->items as $item)
                                <li class="flex items-center justify-between gap-4 py-2 text-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if (!empty($item['img']))
                                            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                                                class="h-9 w-9 shrink-0 rounded-lg object-cover border border-zinc-100" />
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.status-select').forEach(function (sel) {
    const colors = {
        new:        'bg-blue-50 text-blue-700',
        accepted:   'bg-giftos-muted text-giftos-dark',
        processing: 'bg-yellow-50 text-yellow-700',
        in_transit: 'bg-purple-50 text-purple-700',
        completed:  'bg-green-50 text-green-700',
    };

    sel.addEventListener('change', function () {
        const id     = this.dataset.orderId;
        const status = this.value;

        // Update colour classes
        Object.values(colors).forEach(c => c.split(' ').forEach(cls => this.classList.remove(cls)));
        (colors[status] || '').split(' ').forEach(cls => this.classList.add(cls));

        fetch(`/api/orders/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ status }),
        });
    });
});
</script>
@endpush
