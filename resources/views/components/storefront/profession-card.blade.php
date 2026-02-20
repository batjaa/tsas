@props(['title', 'subtitle' => '', 'count' => 0, 'image' => '', 'icon' => '', 'href' => '#'])

<a href="{{ $href }}" class="group block bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow reveal">
    <div class="relative h-48 overflow-hidden">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
        @else
            <div class="w-full h-full bg-gray-200"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-charcoal/70 to-transparent"></div>
        @if($icon)
            <div class="absolute top-4 left-4 w-10 h-10 bg-safety text-white flex items-center justify-center text-lg">
                {{ $icon }}
            </div>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-oswald text-lg font-semibold text-charcoal group-hover:text-safety transition-colors">{{ $title }}</h3>
        @if($subtitle)
            <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
        @endif
        <p class="text-xs text-gray-400 mt-2 font-mono">{{ $count }} бүтээгдэхүүн</p>
    </div>
</a>
