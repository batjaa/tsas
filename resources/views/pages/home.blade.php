<x-layouts.storefront title="Нүүр">
    <!-- Hero -->
    <x-storefront.hero />

    <!-- Divider -->
    <x-storefront.wavy-divider />

    <!-- Professions / Categories -->
    <section class="py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-storefront.section-heading title="Мэргэжлээр" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['title' => 'Тогооч', 'subtitle' => 'Гал тогооны хувцас', 'count' => 3, 'image' => 'https://picsum.photos/seed/cat-chef/400/300.webp', 'icon' => '🍳'],
                    ['title' => 'Эмнэлэг', 'subtitle' => 'Эмнэлгийн хувцас', 'count' => 2, 'image' => 'https://picsum.photos/seed/cat-medical/400/300.webp', 'icon' => '🏥'],
                    ['title' => 'Нярав / Үйлчилгээ', 'subtitle' => 'Үйлчилгээний хувцас', 'count' => 2, 'image' => 'https://picsum.photos/seed/cat-service/400/300.webp', 'icon' => '🧹'],
                    ['title' => 'Нарийн боовчин', 'subtitle' => 'Боовны цехийн хувцас', 'count' => 1, 'image' => 'https://picsum.photos/seed/cat-baker/400/300.webp', 'icon' => '🧁'],
                ] as $cat)
                    <x-storefront.profession-card
                        :title="$cat['title']"
                        :subtitle="$cat['subtitle']"
                        :count="$cat['count']"
                        :image="$cat['image']"
                        :icon="$cat['icon']"
                        :href="'/products?category=' . urlencode($cat['title'])"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Divider -->
    <x-storefront.wavy-divider :flipped="true" />

    <!-- Featured Products -->
    <section class="bg-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-storefront.section-heading title="Онцлох бүтээгдэхүүн" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['name' => 'Тогоочийн хантааз — Классик цагаан', 'sku' => 'TC-001', 'image' => 'https://picsum.photos/seed/prod-chef-jacket/400/530.webp', 'price' => 65000, 'colors' => ['#FFFFFF', '#2D2926'], 'badge' => 'Шинэ'],
                    ['name' => 'Эмчийн халад — Цэнхэр', 'sku' => 'EM-001', 'image' => 'https://picsum.photos/seed/prod-med-coat/400/530.webp', 'price' => 55000, 'colors' => ['#4A6FA5', '#FFFFFF'], 'badge' => null],
                    ['name' => 'Зөөгчийн цамц — Хар', 'sku' => 'ZC-001', 'image' => 'https://picsum.photos/seed/prod-waiter-shirt/400/530.webp', 'price' => 45000, 'colors' => ['#2D2926', '#FFFFFF'], 'badge' => 'Хит'],
                    ['name' => 'Нарийн боовчны фартук', 'sku' => 'NB-001', 'image' => 'https://picsum.photos/seed/prod-baker-apron/400/530.webp', 'price' => 35000, 'colors' => ['#E8651A', '#2D2926'], 'badge' => null],
                ] as $prod)
                    <x-storefront.product-card
                        :name="$prod['name']"
                        :sku="$prod['sku']"
                        :image="$prod['image']"
                        :price="$prod['price']"
                        :colors="$prod['colors']"
                        :badge="$prod['badge']"
                        href="/products"
                    />
                @endforeach
            </div>

            <div class="text-center mt-10 reveal">
                <a href="/products" class="inline-flex items-center px-8 py-3 bg-safety text-white font-oswald font-semibold text-base uppercase tracking-wider hover:bg-orange-700 transition-colors">
                    Бүгдийг үзэх
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <x-storefront.wavy-divider />

    <!-- About / Quote -->
    <x-storefront.about-quote />

    <!-- Phone CTA -->
    <x-storefront.phone-cta />

    <!-- Bottom padding for mobile bottom bar -->
    <div class="h-14 lg:hidden"></div>
</x-layouts.storefront>
