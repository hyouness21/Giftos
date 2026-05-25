@extends('layouts.app')

@section('title', 'Admin – {{ $category->name }} — GIFTOS')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-zinc-400">
                    <a href="{{ url('/admin') }}" class="hover:text-giftos">Admin</a>
                    <span>/</span>
                    <a href="{{ url('/admin/products') }}" class="hover:text-giftos">Products</a>
                    <span>/</span>
                    <span class="font-medium text-zinc-700">{{ $category->name }}</span>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900">{{ $category->name }}</h1>
            </div>
            <button
                type="button"
                id="open-add-modal"
                class="rounded-xl bg-giftos px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-giftos/25 transition hover:bg-giftos-dark"
            >
                Add Product
            </button>
        </header>

        <div id="flash" class="mb-6 hidden rounded-xl px-4 py-3 text-sm font-medium"></div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" id="products-grid">
            @forelse ($category->products as $product)
                <article
                    id="prod-{{ $product->id }}"
                    class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/50"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-desc="{{ $product->description }}"
                    data-price="{{ $product->price_usd }}"
                    data-img="{{ $product->image_url }}"
                    data-in-stock="{{ $product->in_stock ? '1' : '0' }}"
                >
                    <div class="aspect-4/3 overflow-hidden bg-giftos-muted" id="prod-img-wrap-{{ $product->id }}">
                        @if ($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover" loading="lazy" />
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-4xl font-bold text-giftos/30">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-base font-bold text-zinc-900" id="prod-title-{{ $product->id }}">{{ $product->name }}</h3>
                        <p class="mt-1 text-sm text-zinc-500 line-clamp-2" id="prod-desc-{{ $product->id }}">{{ $product->description }}</p>
                        <p class="mt-2 text-base font-semibold text-giftos-dark" id="prod-price-{{ $product->id }}">${{ number_format($product->price_usd, 2) }}</p>
                        <div class="mt-4 flex gap-2">
                            <button type="button"
                                class="edit-btn flex-1 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold text-zinc-600 transition hover:border-giftos/40 hover:text-giftos-dark"
                                data-id="{{ $product->id }}">Edit</button>
                            <button type="button"
                                class="stock-btn flex-1 rounded-lg border px-3 py-2 text-sm font-semibold transition
                                    {{ $product->in_stock
                                        ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100'
                                        : 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100' }}"
                                data-id="{{ $product->id }}">
                                {{ $product->in_stock ? 'Out of Stock' : 'Available' }}
                            </button>
                            <button type="button"
                                class="delete-btn rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold text-zinc-600 transition hover:border-red-200 hover:text-red-600"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}">Del</button>
                        </div>
                    </div>
                </article>
            @empty
                <p id="empty-label" class="col-span-3 text-sm text-zinc-400">No products in this category yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Add Product Modal --}}
    <div id="add-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold text-zinc-900">New Product — {{ $category->name }}</h2>
            <form id="add-form" class="mt-4 flex flex-col gap-4" novalidate>

                <div>
                    <label for="add-name" class="block text-sm font-medium text-zinc-700">Name</label>
                    <input id="add-name" type="text" maxlength="200" placeholder="e.g. Crystal Vase"
                        class="mt-1 w-full rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20" required />
                    <p id="add-name-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>

                <div>
                    <label for="add-desc" class="block text-sm font-medium text-zinc-700">Description</label>
                    <textarea id="add-desc" rows="3" maxlength="1000" placeholder="Short product description…"
                        class="mt-1 w-full resize-none rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20"></textarea>
                    <p id="add-desc-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>

                <div>
                    <label for="add-price" class="block text-sm font-medium text-zinc-700">Price (USD)</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-zinc-400">$</span>
                        <input id="add-price" type="number" step="0.01" min="0" placeholder="0.00"
                            class="w-full rounded-xl border border-zinc-200 py-2.5 pl-8 pr-4 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20" required />
                    </div>
                    <p id="add-price-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700">Image <span class="font-normal text-zinc-400">(optional)</span></label>
                    <label for="add-image" id="add-img-label"
                        class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 px-4 py-5 text-sm text-zinc-400 transition hover:border-giftos hover:bg-giftos-muted hover:text-giftos-dark">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span id="add-img-label-text">Click to upload a photo</span>
                    </label>
                    <input id="add-image" type="file" accept="image/*" class="hidden" />
                    <div id="add-img-preview-wrap" class="mt-2 hidden">
                        <img id="add-img-preview" src="" alt="Preview" class="h-28 w-full rounded-xl border border-zinc-100 object-cover" />
                        <button type="button" id="add-clear-image" class="mt-1 text-xs text-red-500 hover:underline">Remove image</button>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" id="add-submit-btn"
                        class="flex-1 rounded-xl bg-giftos py-2.5 text-sm font-semibold text-white transition hover:bg-giftos-dark disabled:opacity-60">
                        Add Product
                    </button>
                    <button type="button" id="add-close-modal"
                        class="flex-1 rounded-xl border border-zinc-200 py-2.5 text-sm font-semibold text-zinc-600 transition hover:bg-zinc-50">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Product Modal --}}
    <div id="edit-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold text-zinc-900">Edit Product</h2>
            <form id="edit-form" class="mt-4 flex flex-col gap-4" novalidate>
                <input type="hidden" id="edit-product-id" value="" />

                <div>
                    <label for="edit-name" class="block text-sm font-medium text-zinc-700">Name</label>
                    <input id="edit-name" type="text" maxlength="200"
                        class="mt-1 w-full rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20" required />
                    <p id="edit-name-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>

                <div>
                    <label for="edit-desc" class="block text-sm font-medium text-zinc-700">Description</label>
                    <textarea id="edit-desc" rows="3" maxlength="1000"
                        class="mt-1 w-full resize-none rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20"></textarea>
                    <p id="edit-desc-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>

                <div>
                    <label for="edit-price" class="block text-sm font-medium text-zinc-700">Price (USD)</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-zinc-400">$</span>
                        <input id="edit-price" type="number" step="0.01" min="0"
                            class="w-full rounded-xl border border-zinc-200 py-2.5 pl-8 pr-4 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20" required />
                    </div>
                    <p id="edit-price-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700">Image <span class="font-normal text-zinc-400">(optional — leave blank to keep current)</span></label>
                    <div id="edit-current-img-wrap" class="mb-2 hidden">
                        <p class="mb-1 text-xs text-zinc-400">Current image:</p>
                        <img id="edit-current-img" src="" alt="Current" class="h-24 w-full rounded-xl border border-zinc-100 object-cover" />
                    </div>
                    <label for="edit-image" id="edit-img-label"
                        class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 px-4 py-5 text-sm text-zinc-400 transition hover:border-giftos hover:bg-giftos-muted hover:text-giftos-dark">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span id="edit-img-label-text">Click to replace image</span>
                    </label>
                    <input id="edit-image" type="file" accept="image/*" class="hidden" />
                    <div id="edit-new-img-wrap" class="mt-2 hidden">
                        <img id="edit-new-img-preview" src="" alt="New preview" class="h-28 w-full rounded-xl border border-zinc-100 object-cover" />
                        <button type="button" id="edit-clear-image" class="mt-1 text-xs text-red-500 hover:underline">Remove new image</button>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" id="edit-submit-btn"
                        class="flex-1 rounded-xl bg-giftos py-2.5 text-sm font-semibold text-white transition hover:bg-giftos-dark disabled:opacity-60">
                        Save Changes
                    </button>
                    <button type="button" id="edit-close-modal"
                        class="flex-1 rounded-xl border border-zinc-200 py-2.5 text-sm font-semibold text-zinc-600 transition hover:bg-zinc-50">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    const CATEGORY_ID = {{ $category->id }};
    const csrf        = () => document.querySelector('meta[name="csrf-token"]').content;
    const grid        = document.getElementById('products-grid');
    const flash       = document.getElementById('flash');

    function showFlash(msg, ok = true) {
        flash.textContent = msg;
        flash.className = 'mb-6 rounded-xl px-4 py-3 text-sm font-medium ' +
            (ok ? 'bg-green-50 text-green-700 border border-green-200'
                : 'bg-red-50 text-red-700 border border-red-200');
        setTimeout(() => flash.classList.add('hidden'), 3500);
    }

    function clearErr(id) { document.getElementById(id).classList.add('hidden'); }
    function setErr(id, msg) {
        const el = document.getElementById(id);
        el.textContent = msg;
        el.classList.remove('hidden');
    }

    function escHtml(str) {
        return String(str).replace(/[&<>"']/g, c =>
            ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    // ── ADD MODAL ────────────────────────────────────────────────
    const addModal     = document.getElementById('add-modal');
    const addSubmitBtn = document.getElementById('add-submit-btn');
    const addName      = document.getElementById('add-name');
    const addDesc      = document.getElementById('add-desc');
    const addPrice     = document.getElementById('add-price');
    const addImage     = document.getElementById('add-image');
    const addPreview   = document.getElementById('add-img-preview');
    const addPreviewW  = document.getElementById('add-img-preview-wrap');
    const addLabelTxt  = document.getElementById('add-img-label-text');

    function resetAddForm() {
        addName.value = addDesc.value = addPrice.value = addImage.value = '';
        addPreviewW.classList.add('hidden');
        addPreview.src = '';
        addLabelTxt.textContent = 'Click to upload a photo';
        ['add-name-error', 'add-desc-error', 'add-price-error'].forEach(clearErr);
    }

    addImage.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        addLabelTxt.textContent = file.name;
        const r = new FileReader();
        r.onload = e => { addPreview.src = e.target.result; addPreviewW.classList.remove('hidden'); };
        r.readAsDataURL(file);
    });

    document.getElementById('add-clear-image').addEventListener('click', () => {
        addImage.value = '';
        addPreviewW.classList.add('hidden');
        addPreview.src = '';
        addLabelTxt.textContent = 'Click to upload a photo';
    });

    document.getElementById('open-add-modal').addEventListener('click', () => {
        resetAddForm();
        addModal.classList.remove('hidden');
        addModal.classList.add('flex');
        addName.focus();
    });

    function closeAddModal() { addModal.classList.add('hidden'); addModal.classList.remove('flex'); }
    document.getElementById('add-close-modal').addEventListener('click', closeAddModal);
    addModal.addEventListener('click', e => { if (e.target === addModal) closeAddModal(); });

    document.getElementById('add-form').addEventListener('submit', function (e) {
        e.preventDefault();
        let valid = true;
        if (!addName.value.trim())  { setErr('add-name-error',  'Name is required.');        valid = false; } else clearErr('add-name-error');
        if (!addDesc.value.trim())  { setErr('add-desc-error',  'Description is required.'); valid = false; } else clearErr('add-desc-error');
        if (!addPrice.value || parseFloat(addPrice.value) < 0) { setErr('add-price-error', 'Enter a valid price.'); valid = false; } else clearErr('add-price-error');
        if (!valid) return;

        addSubmitBtn.disabled = true;
        const fd = new FormData();
        fd.append('name',        addName.value.trim());
        fd.append('description', addDesc.value.trim());
        fd.append('price_usd',   addPrice.value);
        fd.append('category_id', CATEGORY_ID);
        if (addImage.files[0]) fd.append('image', addImage.files[0]);

        fetch('/admin/products', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { showFlash(data.message ?? 'Something went wrong.', false); return; }
            document.getElementById('empty-label')?.remove();
            grid.appendChild(buildCard(data));
            closeAddModal();
            showFlash(`"${data.name}" added successfully.`);
        })
        .catch(() => showFlash('Network error. Try again.', false))
        .finally(() => { addSubmitBtn.disabled = false; });
    });

    // ── EDIT MODAL ────────────────────────────────────────────────
    const editModal      = document.getElementById('edit-modal');
    const editSubmitBtn  = document.getElementById('edit-submit-btn');
    const editProductId  = document.getElementById('edit-product-id');
    const editName       = document.getElementById('edit-name');
    const editDesc       = document.getElementById('edit-desc');
    const editPrice      = document.getElementById('edit-price');
    const editImage      = document.getElementById('edit-image');
    const editCurImgWrap = document.getElementById('edit-current-img-wrap');
    const editCurImg     = document.getElementById('edit-current-img');
    const editNewImgWrap = document.getElementById('edit-new-img-wrap');
    const editNewPreview = document.getElementById('edit-new-img-preview');
    const editLabelTxt   = document.getElementById('edit-img-label-text');

    editImage.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        editLabelTxt.textContent = file.name;
        const r = new FileReader();
        r.onload = e => { editNewPreview.src = e.target.result; editNewImgWrap.classList.remove('hidden'); };
        r.readAsDataURL(file);
    });

    document.getElementById('edit-clear-image').addEventListener('click', () => {
        editImage.value = '';
        editNewImgWrap.classList.add('hidden');
        editNewPreview.src = '';
        editLabelTxt.textContent = 'Click to replace image';
    });

    function openEditModal(article) {
        const id    = article.dataset.id;
        const name  = article.dataset.name;
        const desc  = article.dataset.desc;
        const price = article.dataset.price;
        const img   = article.dataset.img;

        editProductId.value = id;
        editName.value      = name;
        editDesc.value      = desc;
        editPrice.value     = price;

        editImage.value = '';
        editNewImgWrap.classList.add('hidden');
        editNewPreview.src = '';
        editLabelTxt.textContent = 'Click to replace image';
        ['edit-name-error', 'edit-desc-error', 'edit-price-error'].forEach(clearErr);

        if (img) {
            editCurImg.src = img;
            editCurImgWrap.classList.remove('hidden');
        } else {
            editCurImgWrap.classList.add('hidden');
        }

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        editName.focus();
    }

    function closeEditModal() { editModal.classList.add('hidden'); editModal.classList.remove('flex'); }
    document.getElementById('edit-close-modal').addEventListener('click', closeEditModal);
    editModal.addEventListener('click', e => { if (e.target === editModal) closeEditModal(); });

    document.getElementById('edit-form').addEventListener('submit', function (e) {
        e.preventDefault();
        let valid = true;
        if (!editName.value.trim())  { setErr('edit-name-error',  'Name is required.');        valid = false; } else clearErr('edit-name-error');
        if (!editDesc.value.trim())  { setErr('edit-desc-error',  'Description is required.'); valid = false; } else clearErr('edit-desc-error');
        if (!editPrice.value || parseFloat(editPrice.value) < 0) { setErr('edit-price-error', 'Enter a valid price.'); valid = false; } else clearErr('edit-price-error');
        if (!valid) return;

        const id = editProductId.value;
        editSubmitBtn.disabled = true;
        const fd = new FormData();
        fd.append('name',        editName.value.trim());
        fd.append('description', editDesc.value.trim());
        fd.append('price_usd',   editPrice.value);
        if (editImage.files[0]) fd.append('image', editImage.files[0]);

        fetch(`/admin/products/${id}/update`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { showFlash(data.message ?? 'Something went wrong.', false); return; }

            // Update card in-place
            const article = document.getElementById('prod-' + id);
            article.dataset.name  = data.name;
            article.dataset.desc  = data.description;
            article.dataset.price = data.price_usd;
            if (data.image_url) article.dataset.img = data.image_url;

            document.getElementById('prod-title-' + id).textContent = data.name;
            document.getElementById('prod-desc-'  + id).textContent = data.description;
            document.getElementById('prod-price-' + id).textContent = '$' + parseFloat(data.price_usd).toFixed(2);

            const imgWrap = document.getElementById('prod-img-wrap-' + id);
            imgWrap.innerHTML = data.image_url
                ? `<img src="${escHtml(data.image_url)}" alt="${escHtml(data.name)}" class="h-full w-full object-cover" />`
                : `<div class="flex h-full w-full items-center justify-center"><span class="text-4xl font-bold text-giftos/30">${escHtml(data.name.charAt(0).toUpperCase())}</span></div>`;

            article.querySelector('.delete-btn').dataset.name = data.name;

            closeEditModal();
            showFlash(`"${data.name}" updated successfully.`);
        })
        .catch(() => showFlash('Network error. Try again.', false))
        .finally(() => { editSubmitBtn.disabled = false; });
    });

    // ── EVENT DELEGATION ─────────────────────────────────────────
    document.addEventListener('click', function (e) {
        // Edit button
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            const article = document.getElementById('prod-' + editBtn.dataset.id);
            if (article) openEditModal(article);
            return;
        }

        // Stock toggle button
        const stockBtn = e.target.closest('.stock-btn');
        if (stockBtn) {
            const id      = stockBtn.dataset.id;
            const article = document.getElementById('prod-' + id);
            stockBtn.disabled = true;
            fetch(`/admin/products/${id}/toggle-stock`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(r => r.json())
            .then(data => {
                if (!data.ok) { showFlash('Failed to update stock.', false); return; }
                const inStock = data.in_stock;
                article.dataset.inStock = inStock ? '1' : '0';
                if (inStock) {
                    stockBtn.textContent = 'Out of Stock';
                    stockBtn.className = 'stock-btn flex-1 rounded-lg border px-3 py-2 text-sm font-semibold transition border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100';
                } else {
                    stockBtn.textContent = 'Available';
                    stockBtn.className = 'stock-btn flex-1 rounded-lg border px-3 py-2 text-sm font-semibold transition border-green-200 bg-green-50 text-green-700 hover:bg-green-100';
                }
                showFlash(inStock ? 'Marked as available.' : 'Marked as out of stock.');
            })
            .catch(() => showFlash('Network error.', false))
            .finally(() => { stockBtn.disabled = false; });
            return;
        }

        // Delete button
        const delBtn = e.target.closest('.delete-btn');
        if (!delBtn) return;
        const id   = delBtn.dataset.id;
        const name = delBtn.dataset.name;
        if (!confirm(`Delete "${name}"? This cannot be undone.`)) return;
        delBtn.disabled = true;

        fetch(`/admin/products/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { showFlash('Delete failed.', false); delBtn.disabled = false; return; }
            document.getElementById('prod-' + id)?.remove();
            showFlash(`"${name}" deleted.`);
            if (grid.children.length === 0) {
                const p = document.createElement('p');
                p.id = 'empty-label';
                p.className = 'col-span-3 text-sm text-zinc-400';
                p.textContent = 'No products in this category yet.';
                grid.appendChild(p);
            }
        })
        .catch(() => { showFlash('Network error. Try again.', false); delBtn.disabled = false; });
    });

    // ── BUILD CARD (for newly added products) ────────────────────
    function buildCard(data) {
        const imgHtml = data.image_url
            ? `<img src="${escHtml(data.image_url)}" alt="${escHtml(data.name)}" class="h-full w-full object-cover" loading="lazy" />`
            : `<div class="flex h-full w-full items-center justify-center"><span class="text-4xl font-bold text-giftos/30">${escHtml(data.name.charAt(0).toUpperCase())}</span></div>`;

        const article = document.createElement('article');
        article.id = 'prod-' + data.id;
        article.className = 'overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/50';
        article.dataset.id    = data.id;
        article.dataset.name  = data.name;
        article.dataset.desc  = data.description;
        article.dataset.price = data.price_usd;
        article.dataset.img   = data.image_url ?? '';
        article.innerHTML = `
            <div class="aspect-4/3 overflow-hidden bg-giftos-muted" id="prod-img-wrap-${data.id}">${imgHtml}</div>
            <div class="p-5">
                <h3 class="text-base font-bold text-zinc-900" id="prod-title-${data.id}">${escHtml(data.name)}</h3>
                <p class="mt-1 text-sm text-zinc-500 line-clamp-2" id="prod-desc-${data.id}">${escHtml(data.description)}</p>
                <p class="mt-2 text-base font-semibold text-giftos-dark" id="prod-price-${data.id}">$${parseFloat(data.price_usd).toFixed(2)}</p>
                <div class="mt-4 flex gap-2">
                    <button type="button"
                        class="edit-btn flex-1 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold text-zinc-600 transition hover:border-giftos/40 hover:text-giftos-dark"
                        data-id="${data.id}">Edit</button>
                    <button type="button"
                        class="stock-btn flex-1 rounded-lg border px-3 py-2 text-sm font-semibold transition border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100"
                        data-id="${data.id}">Out of Stock</button>
                    <button type="button"
                        class="delete-btn rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold text-zinc-600 transition hover:border-red-200 hover:text-red-600"
                        data-id="${data.id}" data-name="${escHtml(data.name)}">Del</button>
                </div>
            </div>`;
        return article;
    }
})();
</script>
@endpush
