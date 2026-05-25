@extends('layouts.app')

@section('title', 'Welcome — GIFTOS')

@section('content')
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(64,224,208,0.18),transparent_50%),radial-gradient(ellipse_at_bottom_left,rgba(64,224,208,0.12),transparent_45%)]"></div>

        <div class="relative mx-auto flex min-h-[calc(100vh-8rem)] max-w-3xl flex-col items-center justify-center px-4 py-16 text-center sm:px-6">
            <div class="mb-10 flex flex-col items-center gap-8">
                <button type="button" id="home-logo-btn" aria-label="GIFTOS" class="focus:outline-none">
                    <x-logo height="h-40 sm:h-56" class="pointer-events-none" />
                </button>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">Gifts that feel personal.</h1>
            </div>

            <p class="max-w-xl text-lg leading-relaxed text-zinc-600 sm:text-xl">
                Discover mugs, toys, accessories, and collectibles — curated for smiles, wrapped in care. Start browsing in seconds.
            </p>

            <div class="mt-12 flex w-full max-w-md flex-col gap-3 sm:max-w-lg sm:flex-row sm:justify-center">
                <a
                    href="{{ url('/products') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-giftos px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-giftos/25 transition hover:bg-giftos-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-giftos focus-visible:ring-offset-2"
                >
                    Shop Now
                </a>
            </div>

            <div id="admin-login-panel" class="mt-6 hidden w-full max-w-xs mx-auto">
                <div class="relative overflow-hidden rounded-3xl bg-white shadow-2xl shadow-giftos/15 ring-1 ring-zinc-100">

                    {{-- Top accent bar --}}
                    <div class="h-1 w-full bg-linear-to-r from-giftos via-teal-300 to-giftos"></div>

                    <div class="px-6 py-6">
                        {{-- Lock icon --}}
                        <div class="mx-auto mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-giftos/10">
                            <svg class="h-5 w-5 text-giftos" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </div>

                        <form id="homeAdminLoginForm" class="space-y-3" action="#" method="post" onsubmit="return false">
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                                <input id="admin-user" type="text" name="username" autocomplete="username"
                                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 py-2.5 pl-9 pr-3 text-sm text-zinc-900 outline-none transition focus:border-giftos focus:bg-white focus:ring-2 focus:ring-giftos/20"
                                    placeholder="Username" />
                            </div>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                                <input id="admin-pass" type="password" name="password" autocomplete="current-password"
                                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 py-2.5 pl-9 pr-3 text-sm text-zinc-900 outline-none transition focus:border-giftos focus:bg-white focus:ring-2 focus:ring-giftos/20"
                                    placeholder="Password" />
                            </div>
                            <button id="homeAdminLoginBtn" type="button"
                                class="w-full rounded-xl bg-giftos py-2.5 text-sm font-bold text-white shadow-lg shadow-giftos/30 transition hover:bg-giftos-dark active:scale-95">
                                Sign in
                            </button>
                            <p id="homeAdminLoginMsg" class="hidden text-center text-xs text-red-500"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('home-logo-btn').addEventListener('click', function () {
            const panel = document.getElementById('admin-login-panel');
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                document.getElementById('admin-user').focus();
            }
        });

        (function () {
            const form = document.getElementById('homeAdminLoginForm');
            const btn = document.getElementById('homeAdminLoginBtn');
            const msg = document.getElementById('homeAdminLoginMsg');
            const user = document.getElementById('admin-user');
            const pass = document.getElementById('admin-pass');

            function setMessage(text) {
                if (!text) {
                    msg.textContent = '';
                    msg.classList.add('hidden');
                    return;
                }
                msg.textContent = text;
                msg.classList.remove('hidden');
            }

            function extractErrorMessage(data, fallback) {
                if (!data) return fallback;
                if (typeof data.message === 'string' && data.message.trim()) return data.message;
                if (data.errors && typeof data.errors === 'object') {
                    const firstKey = Object.keys(data.errors)[0];
                    const firstError = firstKey ? data.errors[firstKey] : null;
                    if (Array.isArray(firstError) && firstError[0]) return firstError[0];
                }
                return fallback;
            }

            async function loginAdmin() {
                setMessage('');
                btn.disabled = true;
                btn.classList.add('opacity-80', 'cursor-not-allowed');

                try {
                    const res = await fetch('{{ url('/api/admin/login') }}', {
                        method: 'POST',
                        credentials: 'include',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            username: (user.value || '').trim(),
                            password: pass.value || '',
                        }),
                    });

                    if (!res.ok) {
                        const data = await res.json().catch(() => null);
                        setMessage(extractErrorMessage(data, 'Invalid username or password.'));
                        return;
                    }

                    window.location.href = '{{ url('/admin') }}';
                } catch (e) {
                    setMessage('Network error. Please try again.');
                } finally {
                    btn.disabled = false;
                    btn.classList.remove('opacity-80', 'cursor-not-allowed');
                }
            }

            btn.addEventListener('click', loginAdmin);
            form.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') loginAdmin();
            });
        })();
    </script>
@endsection
