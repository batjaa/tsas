<x-layouts.storefront :title="$product->name">
    <section class="bg-white py-10 lg:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm reveal">
                <ol class="flex items-center gap-2 text-gray-400">
                    <li><a href="/" class="hover:text-safety transition-colors">Нүүр</a></li>
                    <li>/</li>
                    <li><a href="/products" class="hover:text-safety transition-colors">Бүтээгдэхүүн</a></li>
                    <li>/</li>
                    <li><a href="/products?category={{ urlencode($product->category) }}" class="hover:text-safety transition-colors">{{ $product->category }}</a></li>
                    <li>/</li>
                    <li class="text-charcoal">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="lg:grid lg:grid-cols-2 lg:gap-12"
                 x-data="{
                     selectedColor: null,
                     selectedSize: null,
                     variants: {{ $product->variants->map(fn($v) => [
                         'color' => $v->color,
                         'size' => $v->size,
                         'price' => $v->price,
                         'is_available' => $v->is_available,
                         'stock' => $v->stock,
                         'hex' => \App\Helpers\ColorMap::hex($v->color),
                     ])->toJson() }},
                     colors: {{ $product->variants->pluck('color')->unique()->values()->toJson() }},
                     sizes: {{ $product->variants->pluck('size')->unique()->values()->toJson() }},
                     minPrice: {{ $product->min_variant_price ?? $product->variants->min('price') ?? 0 }},

                     get selectedVariant() {
                         if (!this.selectedColor || !this.selectedSize) return null;
                         return this.variants.find(v =>
                             v.color === this.selectedColor &&
                             v.size === this.selectedSize
                         );
                     },

                     get displayPrice() {
                         if (this.selectedVariant) return this.selectedVariant.price;
                         return this.minPrice;
                     },

                     get canBuy() {
                         const v = this.selectedVariant;
                         return v && v.is_available && v.stock > 0;
                     },

                     colorHex(color) {
                         const v = this.variants.find(v => v.color === color);
                         return v ? v.hex : '#CCCCCC';
                     },

                     isColorDisabled(color) {
                         if (!this.selectedSize) {
                             return !this.variants.some(v => v.color === color && v.is_available && v.stock > 0);
                         }
                         return !this.variants.some(v => v.color === color && v.size === this.selectedSize && v.is_available && v.stock > 0);
                     },

                     isSizeDisabled(size) {
                         if (!this.selectedColor) {
                             return !this.variants.some(v => v.size === size && v.is_available && v.stock > 0);
                         }
                         return !this.variants.some(v => v.size === size && v.color === this.selectedColor && v.is_available && v.stock > 0);
                     },

                     toggleColor(color) {
                         this.selectedColor = this.selectedColor === color ? null : color;
                     },

                     toggleSize(size) {
                         this.selectedSize = this.selectedSize === size ? null : size;
                     }
                 }">

                <!-- Image gallery -->
                <div class="reveal">
                    @php
                        $images = $product->images->sortBy('order');
                        $primaryImage = $images->where('is_primary', true)->first() ?? $images->first();
                        $otherImages = $images->where('id', '!=', optional($primaryImage)->id)->take(3);
                    @endphp

                    @if($primaryImage && $primaryImage->disk)
                        <x-storefront.responsive-image
                            :image="$primaryImage"
                            :alt="$product->name"
                            class="w-full aspect-[3/4] object-cover"
                            sizes="(min-width: 1024px) 50vw, 100vw"
                        />
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400 font-oswald">Зураггүй</span>
                        </div>
                    @endif

                    @if($otherImages->isNotEmpty())
                        <div class="grid grid-cols-3 gap-3 mt-3">
                            @foreach($otherImages as $image)
                                @if($image->disk)
                                    <x-storefront.responsive-image
                                        :image="$image"
                                        :alt="$product->name"
                                        class="w-full aspect-square object-cover cursor-pointer hover:opacity-80 transition-opacity"
                                        sizes="(min-width: 1024px) 16vw, 33vw"
                                    />
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product info -->
                <div class="mt-8 lg:mt-0 reveal">
                    @if($product->badge)
                        <span class="inline-block bg-safety text-white text-xs font-oswald font-semibold uppercase px-3 py-1 tracking-wider mb-3">{{ $product->badge }}</span>
                    @endif

                    <p class="font-mono text-xs text-gray-400 mb-1">{{ $product->variants->first()?->sku }}</p>

                    <h1 class="font-oswald text-2xl sm:text-3xl font-bold text-charcoal">{{ $product->name }}</h1>

                    <p class="mt-2 text-sm text-gray-500">{{ $product->category }}</p>

                    <!-- Price -->
                    <div class="mt-4">
                        <span class="font-oswald text-3xl font-bold text-charcoal" x-text="'₮' + Number(displayPrice).toLocaleString()"></span>
                    </div>

                    <!-- Color picker -->
                    <div class="mt-6">
                        <h2 class="font-oswald text-sm font-semibold uppercase tracking-wider text-charcoal mb-3">Өнгө</h2>
                        <div class="flex flex-wrap items-center gap-3">
                            <template x-for="color in colors" :key="color">
                                <button
                                    @click="toggleColor(color)"
                                    :disabled="isColorDisabled(color)"
                                    :class="{
                                        'ring-2 ring-offset-2 ring-safety': selectedColor === color,
                                        'opacity-30 cursor-not-allowed': isColorDisabled(color)
                                    }"
                                    class="w-8 h-8 rounded-full border border-gray-200 transition-all focus:outline-none"
                                    :style="'background-color: ' + colorHex(color)"
                                    :title="color">
                                </button>
                            </template>
                        </div>
                        <p x-show="selectedColor" x-text="selectedColor" class="text-xs text-gray-500 mt-2"></p>
                    </div>

                    <!-- Size picker -->
                    <div class="mt-6">
                        <h2 class="font-oswald text-sm font-semibold uppercase tracking-wider text-charcoal mb-3">Размер</h2>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="size in sizes" :key="size">
                                <button
                                    @click="toggleSize(size)"
                                    :disabled="isSizeDisabled(size)"
                                    :class="{
                                        'bg-charcoal text-white border-charcoal': selectedSize === size,
                                        'bg-white text-charcoal border-gray-300 hover:border-charcoal': selectedSize !== size && !isSizeDisabled(size),
                                        'bg-gray-100 text-gray-300 border-gray-200 cursor-not-allowed': isSizeDisabled(size)
                                    }"
                                    class="min-w-[3rem] px-3 py-2 border text-sm font-oswald font-medium uppercase transition-colors focus:outline-none"
                                    x-text="size">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Add to cart -->
                    <button
                        type="button"
                        :disabled="!canBuy"
                        class="mt-8 w-full py-3 px-6 font-oswald font-semibold text-base uppercase tracking-wider transition-colors focus:outline-none disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed bg-safety text-white hover:bg-orange-700">
                        <span x-show="!selectedColor || !selectedSize">Өнгө, размер сонгоно уу</span>
                        <span x-show="selectedColor && selectedSize && canBuy">Сагсанд нэмэх</span>
                        <span x-show="selectedColor && selectedSize && !canBuy">Дууссан</span>
                    </button>

                    <p x-show="selectedVariant && !canBuy" x-cloak class="mt-2 text-sm text-red-600">Уучлаарай, энэ хувилбар дууссан байна.</p>

                    <!-- Description -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h2 class="font-oswald text-sm font-semibold uppercase tracking-wider text-charcoal mb-3">Тайлбар</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Phone CTA inline -->
                    <div class="mt-6 bg-concrete p-4 flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-safety shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Захиалга өгөх, лавлах</p>
                            <a href="tel:+976{{ config('site.phone') }}" class="font-mono font-semibold text-charcoal hover:text-safety transition-colors">{{ substr(config('site.phone'), 0, 4) }}-{{ substr(config('site.phone'), 4) }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related products -->
            @if($relatedProducts->isNotEmpty())
                <div class="mt-16 border-t border-gray-200 pt-12">
                    <x-storefront.section-heading title="Төстэй бүтээгдэхүүн" />

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $rel)
                            @php
                                $relColors = $rel->variants->pluck('color')->unique()->map(fn($c) => \App\Helpers\ColorMap::hex($c))->values()->all();
                            @endphp
                            <x-storefront.product-card
                                :name="$rel->name"
                                :sku="$rel->variants->first()?->sku ?? ''"
                                :image="$rel->primary_image_url"
                                :price="$rel->min_variant_price ?? $rel->variants->min('price') ?? 0"
                                :colors="$relColors"
                                :badge="$rel->badge"
                                :href="'/products/' . $rel->id"
                            />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Bottom padding for mobile bottom bar -->
    <div class="h-14 lg:hidden"></div>
</x-layouts.storefront>
