<header class="sticky top-0 z-50 bg-white shadow-sm" x-data="{ mobileOpen: false }">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 shrink-0">
                <img src="/images/logo.png" alt="{{ config('app.name', 'TSAS') }}" class="h-8 w-auto" />
                <span class="font-oswald font-bold text-xl text-charcoal hidden sm:block">TSAS</span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="/" class="nav-link font-oswald text-sm font-medium uppercase tracking-wider text-charcoal hover:text-safety transition-colors">Нүүр</a>
                <a href="/products" class="nav-link font-oswald text-sm font-medium uppercase tracking-wider text-charcoal hover:text-safety transition-colors">Бүтээгдэхүүн</a>
                <a href="/about" class="nav-link font-oswald text-sm font-medium uppercase tracking-wider text-charcoal hover:text-safety transition-colors">Бидний тухай</a>
            </div>

            <!-- Desktop phone + cart -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="tel:+976{{ config('site.phone') }}" class="flex items-center gap-2 text-charcoal hover:text-safety transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <span class="font-mono text-sm font-medium">{{ substr(config('site.phone'), 0, 4) }}-{{ substr(config('site.phone'), 4) }}</span>
                </a>
                <a href="/cart" class="relative p-2 text-charcoal hover:text-safety transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </a>
            </div>

            <!-- Mobile hamburger -->
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-charcoal hover:text-safety transition-colors" aria-label="Toggle menu">
                <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile menu -->
    <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-3">
            <a href="/" class="block font-oswald text-base font-medium uppercase tracking-wider text-charcoal hover:text-safety transition-colors py-2">Нүүр</a>
            <a href="/products" class="block font-oswald text-base font-medium uppercase tracking-wider text-charcoal hover:text-safety transition-colors py-2">Бүтээгдэхүүн</a>
            <a href="/about" class="block font-oswald text-base font-medium uppercase tracking-wider text-charcoal hover:text-safety transition-colors py-2">Бидний тухай</a>
            <div class="border-t border-gray-100 pt-3">
                <a href="tel:+976{{ config('site.phone') }}" class="flex items-center gap-2 text-charcoal hover:text-safety transition-colors py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <span class="font-mono text-sm font-medium">{{ substr(config('site.phone'), 0, 4) }}-{{ substr(config('site.phone'), 4) }}</span>
                </a>
                <a href="/cart" class="flex items-center gap-2 text-charcoal hover:text-safety transition-colors py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span class="text-sm font-medium">Сагс</span>
                </a>
            </div>
        </div>
    </div>
</header>
