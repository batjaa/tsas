<?php

use Livewire\Volt\Component;
use App\Models\Product;
use function Livewire\Volt\{state};

new class extends Component {
    public function with(): array
    {
        return [
            'products' => Product::with('images')->get(),
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
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="aspect-w-4 aspect-h-5 bg-gray-200">
                                @if($product->primary_image_url)
                                    <img
                                        src="{{ $product->primary_image_url }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-64 object-cover"
                                    >
                                @else
                                    <div class="w-full h-64 flex items-center justify-center bg-gray-100">
                                        <span class="text-gray-400">{{ __('products.no_image') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900 flex-1">
                                        {{ $product->name }}
                                    </h3>
                                    @if($product->in_stock)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                            {{ __('products.in_stock') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                            {{ __('products.out_of_stock') }}
                                        </span>
                                    @endif
                                </div>

                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                    {{ $product->description }}
                                </p>

                                <div class="flex items-center gap-2 mb-3 text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $product->category }}</span>
                                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $product->size }}</span>
                                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $product->color }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ __('products.currency_format', ['amount' => number_format($product->price, (int) __('products.currency_decimals'))]) }}
                                    </span>
                                    <button
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                        @if(!$product->in_stock) disabled @endif
                                    >
                                        {{ __('products.add_to_cart') }}
                                    </button>
                                </div>
                            </div>
                        </div>
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
