<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ShopNest') }}</title>
    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300..800&display=swap" rel="stylesheet">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-white via-slate-50 to-sky-50"></div>
        <div class="absolute -left-24 top-20 h-72 w-72 rounded-full bg-sky-200/50 blur-3xl"></div>
        <div class="absolute -right-32 bottom-10 h-80 w-80 rounded-full bg-emerald-200/40 blur-3xl"></div>
    </div>

    @php
        $cartCount = null;
        try {
            $cart = \App\Models\Cart::query()
                ->where('user_id', auth()->id())
                ->whereNull('checked_out_at')
                ->withCount('items')
                ->first();
            $cartCount = $cart?->items_count ?? 0;
        } catch (\Throwable $e) {
            $cartCount = null;
        }
    @endphp

    <div class="min-h-screen">
        <div class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-white shadow-lg">SN</div>
                    <div>
                        <div class="text-sm font-semibold tracking-wide text-slate-900">{{ config('app.name', 'ShopNest') }}</div>
                        <div class="text-xs text-slate-500">Premium essentials marketplace</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="/products" class="hidden rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 sm:inline-flex">Browse</a>
                    <a href="/cart" class="relative inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-900/20">
                        Cart
                        @if(is_int($cartCount) && $cartCount > 0)
                            <span class="inline-flex min-w-6 items-center justify-center rounded-full bg-white px-2 py-0.5 text-xs font-bold text-slate-900">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 py-8 sm:px-6 lg:grid-cols-[240px_1fr] lg:gap-10 lg:px-8">
            <aside class="hidden lg:block">
                <div class="sticky top-24 space-y-6">
                    <div class="rounded-3xl border border-slate-200/70 bg-white/80 p-5 shadow-sm">
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Explore</div>
                        <nav class="mt-4 space-y-2 text-sm font-semibold">
                            <a href="/" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                <span>Home</span>
                                <span class="text-xs text-slate-400">01</span>
                            </a>
                            <a href="/products" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                <span>Products</span>
                                <span class="text-xs text-slate-400">02</span>
                            </a>
                            <a href="/categories" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                <span>Categories</span>
                                <span class="text-xs text-slate-400">03</span>
                            </a>
                            <a href="/contact" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                <span>Contact</span>
                                <span class="text-xs text-slate-400">04</span>
                            </a>
                        </nav>
                    </div>

                    <div class="rounded-3xl border border-slate-200/70 bg-white/80 p-5 shadow-sm">
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Account</div>
                        <div class="mt-4 space-y-2 text-sm font-semibold">
                            @auth
                                <a href="/account/orders" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                    <span>Orders</span>
                                    <span class="text-xs text-slate-400">05</span>
                                </a>
                                @if(auth()->user()->is_admin)
                                    <a href="/admin" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                        <span>Admin</span>
                                        <span class="text-xs text-slate-400">06</span>
                                    </a>
                                @endif
                                <form method="POST" action="/logout" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full rounded-2xl border border-slate-200 px-3 py-2 text-left text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">Logout</button>
                                </form>
                            @else
                                <a href="/login" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                    <span>Login</span>
                                    <span class="text-xs text-slate-400">05</span>
                                </a>
                                <a href="/register" class="flex items-center justify-between rounded-2xl px-3 py-2 transition hover:bg-slate-100">
                                    <span>Create account</span>
                                    <span class="text-xs text-slate-400">06</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </aside>

            <main>
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ now()->format('F Y') }}</div>
                        <h1 class="text-2xl font-semibold text-slate-900">Welcome back</h1>
                        <p class="mt-1 text-sm text-slate-500">Curated products, streamlined checkout, tailored for you.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/products" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">View catalog</a>
                        <a href="/contact" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-900/20">Talk to us</a>
                    </div>
                </div>
                @if (session('success'))
                    <div class="mb-5 rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <div class="font-semibold text-rose-900">Please fix the following:</div>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-3xl border border-slate-200/70 bg-white/80 p-6 shadow-sm">
                    @yield('content')
                </div>
            </main>
        </div>

        <footer class="border-t border-slate-200/70 bg-white/80">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">{{ config('app.name', 'ShopNest') }}</div>
                        <p class="mt-2 text-xs text-slate-500">Minimal design. Maximum clarity. Built for fast shopping.</p>
                    </div>
                    <div class="space-y-2 text-sm font-semibold text-slate-600">
                        <a href="/products" class="block transition hover:text-slate-900">Products</a>
                        <a href="/categories" class="block transition hover:text-slate-900">Categories</a>
                        <a href="/contact" class="block transition hover:text-slate-900">Support</a>
                    </div>
                    <div class="space-y-2 text-sm font-semibold text-slate-600">
                        <a href="/cart" class="block transition hover:text-slate-900">Cart</a>
                        <a href="/checkout" class="block transition hover:text-slate-900">Checkout</a>
                        <a href="/account/orders" class="block transition hover:text-slate-900">Account</a>
                    </div>
                </div>
                <div class="mt-10 flex flex-wrap items-center justify-between gap-3 border-t border-slate-200/70 pt-6 text-xs text-slate-500">
                    <span>© {{ date('Y') }} {{ config('app.name', 'ShopNest') }}. Crafted in Laravel.</span>
                    <span>Luxury layout refresh · April {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>
