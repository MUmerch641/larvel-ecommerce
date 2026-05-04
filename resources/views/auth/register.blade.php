@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="mb-8">
            <div class="inline-block rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-600 mb-4">
                Account
            </div>
            <h1 class="text-3xl font-black tracking-tight text-slate-900 mb-2">Create your account</h1>
            <p class="text-base text-slate-500">Register to start shopping and track your orders.</p>
        </div>

        <div class="surface p-8">
        <form method="POST" action="/register" class="space-y-4">
            @csrf

            <div>
                  <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required autofocus
                      class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-slate-400 focus:ring-1 focus:ring-slate-200"
                       placeholder="Your name" />
                  @error('name') <div class="mt-2 text-xs text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div>
                  <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

            <div>
                  <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                      class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-slate-400 focus:ring-1 focus:ring-slate-200"
                       placeholder="••••••••" />
            </div>

            <div class="flex flex-col gap-2 pt-2 sm:flex-row">
                <button class="flex-1 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition" type="submit">
                    Register
                </button>
                <a class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-slate-400 hover:bg-slate-50 transition text-center" href="/login">
                    I already have an account
                </a>
            </div>
        </form>
        </div>
    </div>
@endsection

