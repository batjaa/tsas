<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public Product $product;

    public function mount($id): void
    {
        $this->product = Product::with(['images', 'variants'])->findOrFail($id);
    }

    public function getMinPriceProperty(): ?float
    {
        return $this->product->min_variant_price ?? $this->product->variants->min('price');
    }

    public function getRelatedProductsProperty()
    {
        return Product::with(['images', 'variants'])
            ->where('category', $this->product->category)
            ->where('id', '!=', $this->product->id)
            ->take(4)
            ->get();
    }
}; ?>

<x-layouts.app>
    @volt('products.show')
        <div class="bg-white">
            <main class="mx-auto mt-8 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">

                <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8"
                     x-data="{
                         selectedColor: null,
                         selectedSize: null,
                         variants: {{ $product->variants->map(fn($v) => [
                             'color' => $v->color,
                             'size' => $v->size,
                             'price' => $v->price,
                             'is_available' => $v->is_available,
                             'stock' => $v->stock
                         ])->toJson() }},
                         colors: {{ $product->variants->pluck('color')->filter()->unique()->values()->toJson() }},
                         sizes: {{ $product->variants->pluck('size')->filter()->unique()->values()->toJson() }},
                         minPrice: {{ $this->minPrice ?? 'null' }},

                         get selectedVariant() {
                             if (!this.selectedColor || !this.selectedSize) return null;
                             return this.variants.find(v =>
                                 v.color === this.selectedColor &&
                                 v.size === this.selectedSize
                             );
                         },

                         get displayPrice() {
                             if (this.selectedVariant) {
                                 return this.selectedVariant.price;
                             }
                             return this.minPrice;
                         },

                         get canBuy() {
                             const v = this.selectedVariant;
                             return v && v.is_available && v.stock > 0;
                         },

                         isColorDisabled(color) {
                             if (!this.selectedSize) {
                                 return !this.variants.some(v =>
                                     v.color === color && v.is_available && v.stock > 0
                                 );
                             }
                             return !this.variants.some(v =>
                                 v.color === color &&
                                 v.size === this.selectedSize &&
                                 v.is_available &&
                                 v.stock > 0
                             );
                         },

                         isSizeDisabled(size) {
                             if (!this.selectedColor) {
                                 return !this.variants.some(v =>
                                     v.size === size && v.is_available && v.stock > 0
                                 );
                             }
                             return !this.variants.some(v =>
                                 v.size === size &&
                                 v.color === this.selectedColor &&
                                 v.is_available &&
                                 v.stock > 0
                             );
                         },

                         toggleColor(color) {
                             if (this.selectedColor === color) {
                                 this.selectedColor = null;
                             } else {
                                 this.selectedColor = color;
                             }
                         },

                         toggleSize(size) {
                             if (this.selectedSize === size) {
                                 this.selectedSize = null;
                             } else {
                                 this.selectedSize = size;
                             }
                         }
                     }">
                    <div class="lg:col-span-5 lg:col-start-8">
                        <div class="flex justify-between">
                            <h1 class="text-xl font-medium text-gray-900">{{ $product->name }}</h1>
                            <p class="text-xl font-medium text-gray-900">
                                <span x-show="displayPrice !== null" x-text="'{{ __('products.currency_format', ['amount' => '']) }}'.replace('', Number(displayPrice).toFixed({{ (int) __('products.currency_decimals') }}))"></span>
                                <span x-show="displayPrice === null">--</span>
                            </p>
                        </div>
                    </div>

                    <!-- Image gallery -->
                    <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                        <h2 class="sr-only">{{ __('products.images') }}</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                            @if($product->images->isNotEmpty())
                                @php
                                    $images = $product->images->sortBy('order');
                                    $primaryImage = $images->where('is_primary', true)->first() ?? $images->first();
                                    $otherImages = $images->where('id', '!=', $primaryImage->id)->take(2);
                                @endphp

                                <img src="{{ $primaryImage->image_url }}" alt="{{ $product->name }}" class="rounded-lg lg:col-span-2 lg:row-span-2" />
                                @foreach($otherImages as $image)
                                    <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="hidden rounded-lg lg:block" />
                                @endforeach
                            @else
                                <div class="rounded-lg lg:col-span-2 lg:row-span-2 flex items-center justify-center bg-gray-100 h-96">
                                    <span class="text-gray-400">{{ __('products.no_image') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 lg:col-span-5">
                        <form>
                            <!-- Color picker -->
                            <div>
                                <h2 class="text-sm font-medium text-gray-900">{{ __('products.color') }}</h2>

                                <fieldset aria-label="{{ __('products.choose_color') }}" class="mt-2">
                                    <div class="flex items-center gap-x-3">
                                        <template x-for="(color, index) in colors" :key="color">
                                            <div class="flex rounded-full outline -outline-offset-1 outline-black/10 has-disabled:opacity-25">
                                                <input :id="'color_' + index"
                                                       type="radio"
                                                       name="color"
                                                       :value="color"
                                                       :aria-label="color"
                                                       :checked="selectedColor === color"
                                                       :disabled="isColorDisabled(color)"
                                                       x-model="selectedColor"
                                                       @click="toggleColor(color)"
                                                       :class="{
                                                           'bg-gray-900 checked:outline-gray-900': color === 'Black',
                                                           'bg-white border border-gray-300 checked:outline-gray-300': color === 'White',
                                                           'bg-blue-600 checked:outline-blue-600': color === 'Blue',
                                                           'bg-red-600 checked:outline-red-600': color === 'Red',
                                                           'bg-blue-900 checked:outline-blue-900': color === 'Navy',
                                                           'bg-gray-500 checked:outline-gray-500': color === 'Gray',
                                                           'bg-gray-700 checked:outline-gray-700': color === 'Charcoal',
                                                           'bg-pink-400 checked:outline-pink-400': color === 'Floral',
                                                           'bg-gradient-to-r from-blue-900 to-white border border-gray-300 checked:outline-gray-300': color === 'Navy/White',
                                                           'bg-gray-200 checked:outline-gray-200': !['Black', 'White', 'Blue', 'Red', 'Navy', 'Gray', 'Charcoal', 'Floral', 'Navy/White'].includes(color)
                                                       }"
                                                       class="size-8 appearance-none rounded-full forced-color-adjust-none checked:outline-2 checked:outline-offset-2 focus-visible:outline-3 focus-visible:outline-offset-3 disabled:cursor-not-allowed" />
                                            </div>
                                        </template>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Size picker -->
                            <div class="mt-8">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-sm font-medium text-gray-900">{{ __('products.size') }}</h2>
                                </div>
                                <fieldset aria-label="{{ __('products.choose_size') }}" class="mt-2">
                                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                                        <template x-for="(size, index) in sizes" :key="size">
                                            <label :for="'size_' + index"
                                                   class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-indigo-600 has-checked:bg-indigo-600 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-indigo-600 has-disabled:border-gray-400 has-disabled:bg-gray-200 has-disabled:opacity-25">
                                                <input :id="'size_' + index"
                                                       type="radio"
                                                       name="size"
                                                       :value="size"
                                                       :aria-label="size"
                                                       :checked="selectedSize === size"
                                                       :disabled="isSizeDisabled(size)"
                                                       @click="toggleSize(size)"
                                                       class="peer absolute inset-0 appearance-none focus:outline-none disabled:cursor-not-allowed" />
                                                <span class="text-sm font-medium text-gray-900 uppercase group-has-checked:text-white" x-text="size"></span>
                                            </label>
                                        </template>
                                    </div>
                                </fieldset>
                            </div>

                            <button type="button"
                                    class="mt-8 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden disabled:bg-gray-300 disabled:cursor-not-allowed"
                                    :disabled="!canBuy">
                                {{ __('products.add_to_cart') }}
                            </button>
                            <p x-show="selectedVariant && !canBuy"
                               x-cloak
                               class="mt-2 text-sm text-red-600">{{ __('products.out_of_stock') }}</p>
                        </form>

                        <!-- Product details -->
                        <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">{{ __('products.description') }}</h2>

                            <div class="mt-4 space-y-4 text-sm/6 text-gray-500">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h2 class="text-sm font-medium text-gray-900">{{ __('products.category') }}</h2>

                            <div class="mt-4 text-sm text-gray-500">
                                {{ $product->category }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related products -->
                <section aria-labelledby="related-heading" class="mt-16 sm:mt-24">
                    <h2 id="related-heading" class="text-lg font-medium text-gray-900">{{ __('products.related_products') }}</h2>

                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                        @forelse($this->relatedProducts as $rel)
                            @php
                                $relMin = $rel->min_variant_price ?? $rel->variants->min('price');
                            @endphp
                            <a href="/products/{{ $rel->id }}" class="group relative block">
                                @if($rel->primary_image_url)
                                    <img src="{{ $rel->primary_image_url }}" alt="{{ $rel->name }}" class="aspect-square w-full rounded-md object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                                @else
                                    <div class="aspect-square w-full rounded-md bg-gray-100 flex items-center justify-center lg:aspect-auto lg:h-80">
                                        <span class="text-gray-400">{{ __('products.no_image') }}</span>
                                    </div>
                                @endif
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-sm text-gray-700">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $rel->name }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ $rel->category }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">
                                        @if($relMin)
                                            {{ __('products.currency_format', ['amount' => number_format($relMin, (int) __('products.currency_decimals'))]) }}
                                        @else
                                            --
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </section>
            </main>
        </div>
    @endvolt
</x-layouts.app>
