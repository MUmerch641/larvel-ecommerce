@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <div class="inline-block rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-600 mb-4">
                Contact
            </div>
            <h1 class="text-4xl font-black tracking-tight text-slate-900 mb-2">Contact Us</h1>
            <p class="text-lg text-slate-500">Have questions or feedback? Send us a message and we’ll respond as soon as possible.</p>
        </div>
        <div class="surface p-8">

            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 p-4 mb-6">
                    <ul class="text-rose-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 mb-6">
                    <p class="text-emerald-700">{{ session('success') }}</p>
                </div>
            @endif

            <form action="https://formspree.io/f/xojrvawb" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                        Name <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-1 focus:ring-emerald-200"
                        placeholder="Your name"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-1 focus:ring-emerald-200"
                            placeholder="your@email.com"
                        />
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">
                            Phone (Optional)
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-1 focus:ring-emerald-200"
                            placeholder="+1 (555) 000-0000"
                        />
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">
                        Subject <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-1 focus:ring-emerald-200"
                        placeholder="What is your message about?"
                    />
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700 mb-2">
                        Message <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-1 focus:ring-emerald-200"
                        placeholder="Your message..."
                    ></textarea>
                </div>

                <div class="flex gap-2 pt-4">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-slate-900 px-4 py-3 font-semibold text-white hover:bg-slate-800 transition duration-200 shadow-sm"
                    >
                        Send Message
                    </button>
                    <a
                        href="/"
                        class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-3 font-semibold text-slate-700 hover:border-slate-400 hover:bg-slate-50 transition duration-200 text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
