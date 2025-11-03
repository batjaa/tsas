<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public function with(): array
    {
        return [
            'products' => Product::with(['images', 'variants'])->get(),
        ];
    }
}; ?>

<x-layouts.app>
    @volt('products.index')
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('products.title') }}</h1>
                    <p class="mt-2 text-gray-600">{{ __('products.browse') }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        @php
                            $available = $product->variants->contains(fn($v) => $v->is_available && $v->stock > 0);
                            $minPrice = $product->min_variant_price ?? $product->variants->min('price');
                        @endphp
                        <a href="/products/{{ $product->id }}" class="group block rounded-lg overflow-hidden bg-white shadow-md transition hover:shadow-lg">
                            @if($product->primary_image_url)
                                <img
                                    src="{{ $product->primary_image_url }}"
                                    alt="{{ $product->name }}"
                                    class="aspect-square w-full object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80"
                                />
                            @else
                                <div class="aspect-square w-full bg-gray-100 flex items-center justify-center lg:aspect-auto lg:h-80">
                                    <span class="text-gray-400">{{ __('products.no_image') }}</span>
                                </div>
                            @endif

                            <div class="p-4">
                                <div class="mb-2 flex items-start justify-between">
                                    <h3 class="flex-1 text-lg font-semibold text-gray-900">
                                        {{ $product->name }}
                                    </h3>
                                    @if($available)
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                            {{ __('products.in_stock') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                                            {{ __('products.out_of_stock') }}
                                        </span>
                                    @endif
                                </div>

                                <p class="mb-3 line-clamp-2 text-sm text-gray-600">
                                    {{ $product->description }}
                                </p>

                                <div class="mb-3 flex items-center gap-2 text-sm text-gray-500">
                                    <span class="rounded bg-gray-100 px-2 py-1">{{ $product->category }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-gray-900">
                                        @if($minPrice)
                                            {{ __('products.currency_format', ['amount' => number_format($minPrice, (int) __('products.currency_decimals'))]) }}
                                        @else
                                            --
                                        @endif
                                    </span>
                                    <span class="text-sm text-gray-500">{{ __('products.from') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('products.no_products') }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endvolt
</x-layouts.app>
