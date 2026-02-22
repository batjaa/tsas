<x-layouts.storefront title="Нүүр">
    <!-- Hero -->
    <x-storefront.hero :images="$heroImages" />

    <!-- Divider -->
    <x-storefront.wavy-divider />

    <!-- Professions / Categories -->
    <section class="py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-storefront.section-heading title="Мэргэжлээр" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $cat)
                    <x-storefront.profession-card
                        :title="$cat['title']"
                        :subtitle="$cat['subtitle']"
                        :count="$cat['count']"
                        :image="$cat['image']"
                        :icon="$cat['icon']"
                        :accent="$cat['accent']"
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
                @foreach($featuredProducts as $prod)
                    <x-storefront.product-card
                        :name="$prod['name']"
                        :sku="$prod['sku']"
                        :image="$prod['image']"
                        :price="$prod['price']"
                        :colors="$prod['colors']"
                        :badge="$prod['badge']"
                        :href="'/products/' . $prod['id']"
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
