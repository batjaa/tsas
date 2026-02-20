@props(['name', 'sku' => '', 'image' => '', 'price' => 0, 'colors' => [], 'href' => '#', 'badge' => null])

<div class="group bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow reveal">
    <a href="{{ $href }}" class="block">
        <div class="relative aspect-[3/4] overflow-hidden">
            @if($image)
                <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400 text-sm">Зураггүй</span>
                </div>
            @endif
            @if($badge)
                <span class="absolute top-3 left-3 bg-safety text-white text-xs font-oswald font-semibold uppercase px-3 py-1 tracking-wider">{{ $badge }}</span>
            @endif
        </div>
    </a>
    <div class="p-4">
        @if($sku)
            <p class="font-mono text-xs text-gray-400 mb-1">{{ $sku }}</p>
        @endif
        <a href="{{ $href }}">
            <h3 class="font-oswald text-base font-semibold text-charcoal group-hover:text-safety transition-colors leading-tight">{{ $name }}</h3>
        </a>
        @if(count($colors) > 0)
            <div class="flex items-center gap-1.5 mt-2">
                @foreach($colors as $color)
                    <span class="w-4 h-4 rounded-full border border-gray-200" style="background-color: {{ $color }};"></span>
                @endforeach
            </div>
        @endif
        <div class="mt-3 flex items-center justify-between">
            <span class="font-oswald text-lg font-bold text-charcoal">₮{{ number_format($price, 0) }}</span>
            <a href="{{ $href }}" class="text-xs font-oswald font-semibold uppercase tracking-wider text-safety hover:text-orange-700 transition-colors">
                Захиалах →
            </a>
        </div>
    </div>
</div>
