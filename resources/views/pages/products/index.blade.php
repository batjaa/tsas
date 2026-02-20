<x-layouts.storefront title="Бүтээгдэхүүн">
    <section class="py-10 lg:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 reveal">
                <h1 class="font-oswald text-3xl sm:text-4xl font-bold text-charcoal uppercase tracking-wide">
                    @if($currentCategory)
                        {{ $currentCategory }}
                    @else
                        Бүтээгдэхүүн
                    @endif
                </h1>
                <p class="mt-2 text-gray-500">
                    {{ $products->count() }} бүтээгдэхүүн
                    @if($currentCategory)
                        <a href="/products" class="text-safety hover:underline ml-2">× Шүүлт цэвэрлэх</a>
                    @endif
                </p>
            </div>

            <!-- Category filter bar -->
            <div class="flex flex-wrap gap-2 mb-8 reveal">
                <a href="/products"
                   class="px-4 py-2 text-sm font-oswald font-medium uppercase tracking-wider transition-colors {{ !$currentCategory ? 'bg-charcoal text-white' : 'bg-white text-charcoal hover:bg-gray-100' }}">
                    Бүгд
                </a>
                @foreach($categories as $cat)
                    <a href="/products?category={{ urlencode($cat) }}"
                       class="px-4 py-2 text-sm font-oswald font-medium uppercase tracking-wider transition-colors {{ $currentCategory === $cat ? 'bg-charcoal text-white' : 'bg-white text-charcoal hover:bg-gray-100' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Product grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @php
                        $colors = $product->variants->pluck('color')->unique()->map(fn($c) => \App\Helpers\ColorMap::hex($c))->values()->all();
                    @endphp
                    <x-storefront.product-card
                        :name="$product->name"
                        :sku="$product->variants->first()?->sku ?? ''"
                        :image="$product->primary_image_url"
                        :price="$product->min_variant_price ?? $product->variants->min('price') ?? 0"
                        :colors="$colors"
                        :badge="$product->badge"
                        :href="'/products/' . $product->id"
                    />
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="text-center py-16 reveal">
                    <p class="text-gray-400 text-lg font-oswald">Бүтээгдэхүүн олдсонгүй</p>
                    <a href="/products" class="mt-4 inline-block text-safety hover:underline text-sm">Бүх бүтээгдэхүүн үзэх</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Phone CTA -->
    <x-storefront.phone-cta />

    <!-- Bottom padding for mobile bottom bar -->
    <div class="h-14 lg:hidden"></div>
</x-layouts.storefront>
