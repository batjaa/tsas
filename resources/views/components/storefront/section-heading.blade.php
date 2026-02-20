@props(['title', 'count' => null])

<div class="flex items-center gap-4 mb-8 reveal">
    <div class="w-1 h-10 bg-safety"></div>
    <div>
        <h2 class="font-oswald text-2xl sm:text-3xl font-bold text-charcoal uppercase tracking-wide">{{ $title }}</h2>
        @if($count !== null)
            <p class="text-sm text-gray-500 mt-1">{{ $count }} бүтээгдэхүүн</p>
        @endif
    </div>
</div>
