@extends('layouts.app')

@section('title', 'Register — GIFTOS')

@section('content')
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6">
        <div class="rounded-3xl border border-zinc-100 bg-white p-8 shadow-xl shadow-zinc-200/50 sm:p-10">
            <div class="mb-8 text-center">
                <x-logo class="justify-center" />
                <h1 class="mt-6 text-2xl font-bold text-zinc-900">Create your account</h1>
                <p class="mt-2 text-sm text-zinc-500">Sign up to place orders and save your favorites.</p>
            </div>

            <form class="space-y-5" action="{{ route('register.store') }}" method="POST">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="mb-1.5 block text-sm font-medium text-zinc-700">Username</label>
                    <input
                        id="username" name="username" type="text"
                        value="{{ old('username') }}"
                        @class(['w-full rounded-xl border px-4 py-3 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30',
                            'border-red-400 bg-red-50'   => $errors->has('username'),
                            'border-zinc-200 bg-zinc-50' => !$errors->has('username'),
                        ])
                        placeholder="e.g. youness" autocomplete="username" required
                    />
                    @error('username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Full name --}}
                <div>
                    <label for="full_name" class="mb-1.5 block text-sm font-medium text-zinc-700">Full Name</label>
                    <input
                        id="full_name" name="full_name" type="text"
                        value="{{ old('full_name') }}"
                        @class(['w-full rounded-xl border px-4 py-3 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30',
                            'border-red-400 bg-red-50'   => $errors->has('full_name'),
                            'border-zinc-200 bg-zinc-50' => !$errors->has('full_name'),
                        ])
                        placeholder="Your full name" autocomplete="name" required
                    />
                    @error('full_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-medium text-zinc-700">Phone Number</label>
                    <input
                        id="phone" name="phone" type="tel"
                        value="{{ old('phone') }}"
                        @class(['w-full rounded-xl border px-4 py-3 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30',
                            'border-red-400 bg-red-50'   => $errors->has('phone'),
                            'border-zinc-200 bg-zinc-50' => !$errors->has('phone'),
                        ])
                        placeholder="+961 70 000 000" autocomplete="tel" required
                    />
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="mb-1.5 block text-sm font-medium text-zinc-700">Address</label>
                    <textarea
                        id="address" name="address" rows="3"
                        @class(['w-full rounded-xl border px-4 py-3 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30',
                            'border-red-400 bg-red-50'   => $errors->has('address'),
                            'border-zinc-200 bg-zinc-50' => !$errors->has('address'),
                        ])
                        placeholder="Your delivery address" autocomplete="street-address" required
                    >{{ old('address') }}</textarea>
                    @error('address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-zinc-700">Password</label>
                    <div class="relative">
                        <input
                            id="password" name="password" type="password"
                            @class(['w-full rounded-xl border px-4 py-3 pr-11 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30',
                                'border-red-400 bg-red-50'   => $errors->has('password'),
                                'border-zinc-200 bg-zinc-50' => !$errors->has('password'),
                            ])
                            placeholder="••••••••" autocomplete="new-password" required
                        />
                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 hover:text-zinc-600">
                            <svg class="eye-off h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            <svg class="eye-on h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Confirm password --}}
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-zinc-700">Confirm Password</label>
                    <div class="relative">
                        <input
                            id="password_confirmation" name="password_confirmation" type="password"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-11 text-zinc-900 outline-none transition focus:border-giftos focus:ring-2 focus:ring-giftos/30"
                            placeholder="••••••••" autocomplete="new-password" required
                        />
                        <button type="button" id="toggle-password-confirm"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 hover:text-zinc-600">
                            <svg class="eye-off h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            <svg class="eye-on h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-giftos py-3.5 text-base font-semibold text-white shadow-lg shadow-giftos/25 transition hover:bg-giftos-dark">
                    Sign up
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-zinc-500">
                Already have an account?
                <a href="{{ url('/login') }}" class="font-semibold text-giftos-dark hover:text-giftos">Login</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function setupEyeToggle(btnId, inputId) {
    document.getElementById(btnId).addEventListener('click', function () {
        const input = document.getElementById(inputId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        this.querySelector('.eye-off').classList.toggle('hidden', isHidden);
        this.querySelector('.eye-on').classList.toggle('hidden', !isHidden);
    });
}
setupEyeToggle('toggle-password',         'password');
setupEyeToggle('toggle-password-confirm', 'password_confirmation');
</script>
@endpush
