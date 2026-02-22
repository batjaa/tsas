<div class="fixed bottom-0 inset-x-0 z-50 lg:hidden bg-safety text-white shadow-[0_-4px_12px_rgba(0,0,0,0.15)]">
    <a href="tel:+976{{ config('site.phone') }}" class="flex items-center justify-center gap-3 py-3 px-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
        </svg>
        <span class="font-oswald font-semibold text-base tracking-wide">{{ substr(config('site.phone'), 0, 4) }}-{{ substr(config('site.phone'), 4) }} ЗАЛГАХ</span>
    </a>
</div>
