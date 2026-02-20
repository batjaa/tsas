<x-layouts.storefront title="Хэрэглэгч">
    <section class="py-12 lg:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-storefront.section-heading title="Хэрэглэгч" />

            <div class="bg-white p-8 text-center reveal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <p class="text-gray-500 text-lg font-oswald mb-4">Нэвтрэх эсвэл бүртгүүлэх</p>
                <div class="flex justify-center gap-4">
                    <a href="/login" class="inline-flex items-center px-6 py-3 bg-safety text-white font-oswald font-semibold text-sm uppercase tracking-wider hover:bg-orange-700 transition-colors">
                        Нэвтрэх
                    </a>
                    <a href="/register" class="inline-flex items-center px-6 py-3 border-2 border-charcoal text-charcoal font-oswald font-semibold text-sm uppercase tracking-wider hover:bg-charcoal hover:text-white transition-colors">
                        Бүртгүүлэх
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="h-14 lg:hidden"></div>
</x-layouts.storefront>
