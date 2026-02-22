@props(['title', 'subtitle' => '', 'count' => 0, 'image' => '', 'icon' => '', 'href' => '#', 'accent' => '#2D2926'])

@php
    $accentColors = [
        'charcoal' => '#2D2926',
        'steel' => '#4A6FA5',
        'safety' => '#E8651A',
    ];
    $borderColor = $accentColors[$accent] ?? $accent;
@endphp

<a href="{{ $href }}" class="group block bg-white overflow-hidden border border-gray-200 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 reveal text-center p-6 border-t-4" style="border-top-color: {{ $borderColor }}">
    @if($icon)
        <div class="w-11 h-11 mx-auto mb-4 rounded-full bg-concrete flex items-center justify-center">
            {!! $icon !!}
        </div>
    @endif
    @if($image)
        <div class="overflow-hidden rounded mb-4">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
    @endif
    <h3 class="font-oswald text-sm font-bold uppercase tracking-wider text-charcoal mb-1">{{ $title }}</h3>
    @if($subtitle)
        <p class="text-xs text-gray-400">{{ $subtitle }}</p>
    @endif
    <p class="text-xs text-gray-300 mt-1 font-mono">{{ $count }} бүтээгдэхүүн</p>
</a>
