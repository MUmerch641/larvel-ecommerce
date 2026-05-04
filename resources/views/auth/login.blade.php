@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="mb-8">
            <div class="inline-block rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-600 mb-4">
                Account
            </div>
            <h1 class="text-3xl font-black tracking-tight text-slate-900 mb-2">Login</h1>
            <p class="text-base text-slate-500">Sign in to manage your orders and checkout faster.</p>
        </div>

        <div class="surface p-8">
        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                  <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                      class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-slate-400 focus:ring-1 focus:ring-slate-200"
                       placeholder="you@example.com" />
                  @error('email') <div class="mt-2 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div>
                  <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                      class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-slate-400 focus:ring-1 focus:ring-slate-200"
                       placeholder="••••••••" />
                  @error('password') <div class="mt-2 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                       class="rounded border-slate-300 bg-white text-slate-700 focus:ring-slate-300" />
                Remember me
            </label>

            <div class="flex flex-col gap-2 pt-2 sm:flex-row">
                <button class="flex-1 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition" type="submit">
                    Login
                </button>
                <a class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-slate-400 hover:bg-slate-50 transition text-center" href="/register">
                    Create account
                </a>
            </div>
        </form>
        </div>
    </div>
@endsection

