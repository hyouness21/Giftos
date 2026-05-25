@extends('layouts.app')

@section('title', 'Admin Categories — GIFTOS')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-giftos-dark">Admin</p>
                <h1 class="mt-1 text-3xl font-bold tracking-tight text-zinc-900">Categories</h1>
            </div>
            <button type="button" id="open-add-modal"
                class="shrink-0 rounded-xl bg-giftos px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-giftos/25 transition hover:bg-giftos-dark">
                + Add Category
            </button>
        </header>

        <div id="flash" class="mb-6 hidden rounded-xl px-4 py-3 text-sm font-medium"></div>

        <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-md shadow-zinc-200/50">
            {{-- Header row --}}
            <div class="grid grid-cols-[1.5rem,3rem,1fr,auto] items-center gap-4 border-b border-zinc-100 bg-zinc-50 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-400">
                <span></span>
                <span>Img</span>
                <span>Category</span>
                <span>Actions</span>
            </div>

            {{-- Category rows --}}
            <div id="category-list" class="divide-y divide-zinc-100">
                @forelse ($categories as $category)
                    <div id="cat-{{ $category->id }}"
                         data-name="{{ $category->name }}"
                         data-img="{{ $category->image ?? '' }}"
                         class="grid grid-cols-[1.5rem,3rem,1fr,auto] items-center gap-4 px-4 py-3">

                        {{-- Drag handle --}}
                        <span class="drag-handle cursor-grab touch-none select-none text-zinc-300 hover:text-zinc-500 active:cursor-grabbing">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 4a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2zM7 10a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2zM7 16a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>
                        </span>

                        {{-- Thumbnail --}}
                        <div id="cat-img-{{ $category->id }}" class="shrink-0">
                            @if ($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}"
                                    class="h-12 w-12 rounded-xl object-cover border border-zinc-100" />
                            @else
                                <div class="h-12 w-12 rounded-xl bg-giftos-muted flex items-center justify-center text-giftos-dark text-sm font-bold">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <span class="truncate text-sm font-semibold text-zinc-800" id="cat-name-{{ $category->id }}">
                            {{ $category->name }}
                        </span>

                        {{-- Actions --}}
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button"
                                class="edit-btn rounded-lg p-2 text-zinc-400 transition hover:bg-giftos-muted hover:text-giftos-dark"
                                data-id="{{ $category->id }}" title="Edit">
                                <svg class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                </svg>
                            </button>
                            <button type="button"
                                class="delete-btn rounded-lg p-2 text-zinc-400 transition hover:bg-red-50 hover:text-red-500"
                                data-id="{{ $category->id }}" data-name="{{ $category->name }}" title="Delete">
                                <svg class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div id="empty-row" class="px-4 py-8 text-center text-sm text-zinc-400">
                        No categories yet. Add one above.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Add Category Modal --}}
    <div id="add-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
            <h2 class="text-lg font-bold text-zinc-900">New Category</h2>
            <form id="add-form" class="mt-4 flex flex-col gap-4" novalidate>
                <div>
                    <label for="add-cat-name" class="block text-sm font-medium text-zinc-700">Name</label>
                    <input id="add-cat-name" type="text" maxlength="100" placeholder="e.g. Candles"
                        class="mt-1 w-full rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20" required />
                    <p id="add-name-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700">Image <span class="font-normal text-zinc-400">(optional)</span></label>
                    <label for="add-cat-image" id="add-image-label"
                        class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 px-4 py-5 text-sm text-zinc-400 transition hover:border-giftos hover:bg-giftos-muted hover:text-giftos-dark">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span id="add-img-label-text">Click to upload a photo</span>
                    </label>
                    <input id="add-cat-image" type="file" accept="image/*" class="hidden" />
                    <div id="add-img-preview-wrap" class="mt-2 hidden">
                        <img id="add-img-preview" src="" alt="Preview" class="h-28 w-full rounded-xl object-cover border border-zinc-100" />
                        <button type="button" id="add-clear-image" class="mt-1 text-xs text-red-500 hover:underline">Remove image</button>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" id="add-submit-btn"
                        class="flex-1 rounded-xl bg-giftos py-2.5 text-sm font-semibold text-white transition hover:bg-giftos-dark disabled:opacity-60">Add</button>
                    <button type="button" id="add-close-modal"
                        class="flex-1 rounded-xl border border-zinc-200 py-2.5 text-sm font-semibold text-zinc-600 transition hover:bg-zinc-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div id="edit-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
            <h2 class="text-lg font-bold text-zinc-900">Edit Category</h2>
            <form id="edit-form" class="mt-4 flex flex-col gap-4" novalidate>
                <input type="hidden" id="edit-cat-id" value="" />
                <div>
                    <label for="edit-cat-name" class="block text-sm font-medium text-zinc-700">Name</label>
                    <input id="edit-cat-name" type="text" maxlength="100"
                        class="mt-1 w-full rounded-xl border border-zinc-200 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-giftos focus:ring-2 focus:ring-giftos/20" required />
                    <p id="edit-name-error" class="mt-1 hidden text-xs text-red-600"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700">Image <span class="font-normal text-zinc-400">(leave blank to keep current)</span></label>
                    <div id="edit-current-img-wrap" class="mb-2 hidden">
                        <p class="mb-1 text-xs text-zinc-400">Current image:</p>
                        <img id="edit-current-img" src="" alt="Current" class="h-24 w-full rounded-xl border border-zinc-100 object-cover" />
                    </div>
                    <label for="edit-cat-image"
                        class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 px-4 py-5 text-sm text-zinc-400 transition hover:border-giftos hover:bg-giftos-muted hover:text-giftos-dark">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span id="edit-img-label-text">Click to replace image</span>
                    </label>
                    <input id="edit-cat-image" type="file" accept="image/*" class="hidden" />
                    <div id="edit-new-img-wrap" class="mt-2 hidden">
                        <img id="edit-new-img-preview" src="" alt="New preview" class="h-28 w-full rounded-xl border border-zinc-100 object-cover" />
                        <button type="button" id="edit-clear-image" class="mt-1 text-xs text-red-500 hover:underline">Remove new image</button>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" id="edit-submit-btn"
                        class="flex-1 rounded-xl bg-giftos py-2.5 text-sm font-semibold text-white transition hover:bg-giftos-dark disabled:opacity-60">Save</button>
                    <button type="button" id="edit-close-modal"
                        class="flex-1 rounded-xl border border-zinc-200 py-2.5 text-sm font-semibold text-zinc-600 transition hover:bg-zinc-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
(function () {
    const csrf = () => document.querySelector('meta[name="csrf-token"]').content;
    const flash = document.getElementById('flash');
    const list  = document.getElementById('category-list');

    function showFlash(msg, ok = true) {
        flash.textContent = msg;
        flash.className = 'mb-6 rounded-xl px-4 py-3 text-sm font-medium ' +
            (ok ? 'bg-green-50 text-green-700 border border-green-200'
                : 'bg-red-50 text-red-700 border border-red-200');
        setTimeout(() => flash.classList.add('hidden'), 3500);
    }

    function escHtml(str) {
        return String(str).replace(/[&<>"']/g, c =>
            ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    function thumbHtml(id, name, img) {
        return img
            ? `<img src="${escHtml(img)}" alt="${escHtml(name)}" class="h-12 w-12 rounded-xl object-cover border border-zinc-100" />`
            : `<div class="h-12 w-12 rounded-xl bg-giftos-muted flex items-center justify-center text-giftos-dark text-sm font-bold">${escHtml(name.charAt(0).toUpperCase())}</div>`;
    }

    const editIcon = `<svg class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>`;
    const trashIcon = `<svg class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>`;

    // ── ADD MODAL ──────────────────────────────────────────────────
    const addModal     = document.getElementById('add-modal');
    const addNameInput = document.getElementById('add-cat-name');
    const addNameError = document.getElementById('add-name-error');
    const addSubmitBtn = document.getElementById('add-submit-btn');
    const addImgInput  = document.getElementById('add-cat-image');
    const addPreviewW  = document.getElementById('add-img-preview-wrap');
    const addPreview   = document.getElementById('add-img-preview');
    const addLabelTxt  = document.getElementById('add-img-label-text');

    function resetAddForm() {
        addNameInput.value = '';
        addNameError.classList.add('hidden');
        addImgInput.value = '';
        addPreviewW.classList.add('hidden');
        addPreview.src = '';
        addLabelTxt.textContent = 'Click to upload a photo';
    }

    addImgInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        addLabelTxt.textContent = file.name;
        const r = new FileReader();
        r.onload = e => { addPreview.src = e.target.result; addPreviewW.classList.remove('hidden'); };
        r.readAsDataURL(file);
    });

    document.getElementById('add-clear-image').addEventListener('click', () => {
        addImgInput.value = '';
        addPreviewW.classList.add('hidden');
        addPreview.src = '';
        addLabelTxt.textContent = 'Click to upload a photo';
    });

    document.getElementById('open-add-modal').addEventListener('click', () => {
        resetAddForm();
        addModal.classList.remove('hidden');
        addModal.classList.add('flex');
        addNameInput.focus();
    });

    function closeAddModal() { addModal.classList.add('hidden'); addModal.classList.remove('flex'); }
    document.getElementById('add-close-modal').addEventListener('click', closeAddModal);
    addModal.addEventListener('click', e => { if (e.target === addModal) closeAddModal(); });

    document.getElementById('add-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const name = addNameInput.value.trim();
        if (!name) { addNameError.textContent = 'Name is required.'; addNameError.classList.remove('hidden'); return; }
        addNameError.classList.add('hidden');
        addSubmitBtn.disabled = true;

        const fd = new FormData();
        fd.append('name', name);
        if (addImgInput.files[0]) fd.append('image', addImgInput.files[0]);

        fetch('/admin/categories', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { addNameError.textContent = data.message ?? 'Something went wrong.'; addNameError.classList.remove('hidden'); return; }
            document.getElementById('empty-row')?.remove();
            list.appendChild(buildRow(data.id, data.name, data.image));
            closeAddModal();
            showFlash(`"${data.name}" added successfully.`);
        })
        .catch(() => showFlash('Network error. Try again.', false))
        .finally(() => { addSubmitBtn.disabled = false; });
    });

    // ── EDIT MODAL ─────────────────────────────────────────────────
    const editModal      = document.getElementById('edit-modal');
    const editIdInput    = document.getElementById('edit-cat-id');
    const editNameInput  = document.getElementById('edit-cat-name');
    const editNameError  = document.getElementById('edit-name-error');
    const editSubmitBtn  = document.getElementById('edit-submit-btn');
    const editImgInput   = document.getElementById('edit-cat-image');
    const editCurWrap    = document.getElementById('edit-current-img-wrap');
    const editCurImg     = document.getElementById('edit-current-img');
    const editNewWrap    = document.getElementById('edit-new-img-wrap');
    const editNewPreview = document.getElementById('edit-new-img-preview');
    const editLabelTxt   = document.getElementById('edit-img-label-text');

    editImgInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        editLabelTxt.textContent = file.name;
        const r = new FileReader();
        r.onload = e => { editNewPreview.src = e.target.result; editNewWrap.classList.remove('hidden'); };
        r.readAsDataURL(file);
    });

    document.getElementById('edit-clear-image').addEventListener('click', () => {
        editImgInput.value = '';
        editNewWrap.classList.add('hidden');
        editNewPreview.src = '';
        editLabelTxt.textContent = 'Click to replace image';
    });

    function openEditModal(id, name, img) {
        editIdInput.value   = id;
        editNameInput.value = name;
        editNameError.classList.add('hidden');
        editImgInput.value = '';
        editNewWrap.classList.add('hidden');
        editNewPreview.src = '';
        editLabelTxt.textContent = 'Click to replace image';
        if (img) { editCurImg.src = img; editCurWrap.classList.remove('hidden'); }
        else      { editCurWrap.classList.add('hidden'); }
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        editNameInput.focus();
    }

    function closeEditModal() { editModal.classList.add('hidden'); editModal.classList.remove('flex'); }
    document.getElementById('edit-close-modal').addEventListener('click', closeEditModal);
    editModal.addEventListener('click', e => { if (e.target === editModal) closeEditModal(); });

    document.getElementById('edit-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const name = editNameInput.value.trim();
        if (!name) { editNameError.textContent = 'Name is required.'; editNameError.classList.remove('hidden'); return; }
        editNameError.classList.add('hidden');
        const id = editIdInput.value;
        editSubmitBtn.disabled = true;

        const fd = new FormData();
        fd.append('name', name);
        if (editImgInput.files[0]) fd.append('image', editImgInput.files[0]);

        fetch(`/admin/categories/${id}/update`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
            body: fd,
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { editNameError.textContent = data.message ?? 'Something went wrong.'; editNameError.classList.remove('hidden'); return; }
            const row = document.getElementById('cat-' + id);
            row.dataset.name = data.name;
            row.dataset.img  = data.image ?? '';
            document.getElementById('cat-name-' + id).textContent = data.name;
            document.getElementById('cat-img-'  + id).innerHTML   = thumbHtml(id, data.name, data.image);
            row.querySelector('.edit-btn').dataset.id     = id;
            row.querySelector('.delete-btn').dataset.name = data.name;
            if (data.image) { editCurImg.src = data.image; editCurWrap.classList.remove('hidden'); }
            closeEditModal();
            showFlash(`"${data.name}" updated successfully.`);
        })
        .catch(() => showFlash('Network error. Try again.', false))
        .finally(() => { editSubmitBtn.disabled = false; });
    });

    // ── EVENT DELEGATION ───────────────────────────────────────────
    list.addEventListener('click', function (e) {
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            const row = document.getElementById('cat-' + editBtn.dataset.id);
            openEditModal(editBtn.dataset.id, row.dataset.name, row.dataset.img);
            return;
        }

        const delBtn = e.target.closest('.delete-btn');
        if (!delBtn) return;
        const id   = delBtn.dataset.id;
        const name = delBtn.dataset.name;
        if (!confirm(`Delete "${name}"? This cannot be undone.`)) return;
        delBtn.disabled = true;

        fetch(`/admin/categories/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf(), 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { showFlash('Delete failed.', false); delBtn.disabled = false; return; }
            document.getElementById('cat-' + id)?.remove();
            showFlash(`"${name}" deleted.`);
            if (!list.querySelector('[id^="cat-"]')) {
                list.innerHTML = '<div id="empty-row" class="px-4 py-8 text-center text-sm text-zinc-400">No categories yet. Add one above.</div>';
            }
        })
        .catch(() => { showFlash('Network error. Try again.', false); delBtn.disabled = false; });
    });

    // ── BUILD ROW ──────────────────────────────────────────────────
    const dragHandleHtml = `<span class="drag-handle cursor-grab touch-none select-none text-zinc-300 hover:text-zinc-500 active:cursor-grabbing"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 4a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2zM7 10a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2zM7 16a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z"/></svg></span>`;

    function buildRow(id, name, img) {
        const div = document.createElement('div');
        div.id = 'cat-' + id;
        div.dataset.name = name;
        div.dataset.img  = img ?? '';
        div.className = 'grid grid-cols-[1.5rem,3rem,1fr,auto] items-center gap-4 px-4 py-3';
        div.innerHTML = `
            ${dragHandleHtml}
            <div id="cat-img-${id}" class="shrink-0">${thumbHtml(id, name, img)}</div>
            <span class="truncate text-sm font-semibold text-zinc-800" id="cat-name-${id}">${escHtml(name)}</span>
            <div class="flex items-center gap-1 shrink-0">
                <button type="button" class="edit-btn rounded-lg p-2 text-zinc-400 transition hover:bg-giftos-muted hover:text-giftos-dark" data-id="${id}" title="Edit">${editIcon}</button>
                <button type="button" class="delete-btn rounded-lg p-2 text-zinc-400 transition hover:bg-red-50 hover:text-red-500" data-id="${id}" data-name="${escHtml(name)}" title="Delete">${trashIcon}</button>
            </div>`;
        return div;
    }

    // ── DRAG TO REORDER (SortableJS) ───────────────────────────────
    Sortable.create(list, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'opacity-40',
        onEnd: function () {
            const ids = [...list.querySelectorAll('[id^="cat-"]')].map(el => el.id.replace('cat-', ''));
            fetch('/admin/categories/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ ids }),
            }).catch(() => showFlash('Could not save order.', false));
        },
    });
})();
</script>
@endpush
