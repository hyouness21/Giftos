<nav class="mb-6 flex flex-wrap items-center gap-2">
    <a href="{{ url('/admin') }}"
        class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->is('admin') ? 'bg-giftos text-white' : 'bg-white border border-zinc-200 text-zinc-600 hover:border-giftos/40 hover:text-giftos' }}">
        Dashboard
    </a>
    <a href="{{ url('/admin/categories') }}"
        class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->is('admin/categories') ? 'bg-giftos text-white' : 'bg-white border border-zinc-200 text-zinc-600 hover:border-giftos/40 hover:text-giftos' }}">
        Categories
    </a>
    <a href="{{ url('/admin/products') }}"
        class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->is('admin/products', 'admin/products/*') ? 'bg-giftos text-white' : 'bg-white border border-zinc-200 text-zinc-600 hover:border-giftos/40 hover:text-giftos' }}">
        Products
    </a>
    <a href="{{ url('/admin/orders') }}"
        class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->is('admin/orders') ? 'bg-giftos text-white' : 'bg-white border border-zinc-200 text-zinc-600 hover:border-giftos/40 hover:text-giftos' }}">
        Orders
    </a>
</nav>
