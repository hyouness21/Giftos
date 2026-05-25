@extends('layouts.app')

@section('title', 'Login — GIFTOS')

@section('content')
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6">
        <div class="rounded-3xl border border-zinc-100 bg-white p-8 shadow-xl shadow-zinc-200/50 sm:p-10">
            <div class="mb-8 text-center">
                <x-logo class="justify-center" />
                <h1 class="mt-6 text-2xl font-bold text-zinc-900">Welcome back</h1>
                <p class="mt-2 text-sm text-zinc-500">Sign in with your username and password.</p>
            </div>

            <form class="space-y-5" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div>
                    <label for="username" class="mb-1.5 block text-sm font-medium text-zinc-700">Username</label>
                    <input
                        id="username" name="username" type="text"
                        value="{{ old('username') }}"
                        @class(['w-full rounded-xl border px-4 py-3 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30',
                            'border-red-400 bg-red-50'   => $errors->has('username'),
                            'border-zinc-200 bg-zinc-50' => !$errors->has('username'),
                        ])
                        placeholder="your username" autocomplete="username" required autofocus
                    />
                    @error('username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-zinc-700">Password</label>
                    <div class="relative">
                        <input
                            id="password" name="password" type="password"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-11 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30"
                            placeholder="••••••••" autocomplete="current-password" required
                        />
                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 hover:text-zinc-600">
                            <svg class="eye-off h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            <svg class="eye-on h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 rounded border-zinc-300 accent-giftos cursor-pointer" />
                    <label for="remember" class="text-sm text-zinc-600 cursor-pointer">Remember me</label>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-giftos py-3.5 text-base font-semibold text-white shadow-lg shadow-giftos/25 transition hover:bg-giftos-dark">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-500">
                Prefer to browse first?
                <a href="{{ url('/products') }}" class="font-semibold text-giftos-dark hover:text-giftos">Continue as guest</a>
            </p>
            <p class="mt-3 text-center text-sm text-zinc-500">
                Don't have an account?
                <a href="{{ url('/register') }}" class="font-semibold text-giftos-dark hover:text-giftos">Sign up</a>
            </p>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.getElementById('toggle-password').addEventListener('click', function () {
    const input = document.getElementById('password');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    this.querySelector('.eye-off').classList.toggle('hidden', isHidden);
    this.querySelector('.eye-on').classList.toggle('hidden', !isHidden);
});
</script>
@endpush
