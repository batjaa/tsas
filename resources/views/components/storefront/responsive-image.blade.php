@props(['image' => null, 'alt' => '', 'class' => '', 'sizes' => '100vw'])

@if($image && $image->disk)
    <img
        src="{{ $image->url('medium') }}"
        @if($image->srcset())
            srcset="{{ $image->srcset() }}"
            sizes="{{ $sizes }}"
        @endif
        alt="{{ $alt }}"
        loading="lazy"
        {{ $attributes->merge(['class' => $class]) }}
    />
@else
    <div {{ $attributes->merge(['class' => "bg-gray-200 flex items-center justify-center $class"]) }}>
        <span class="text-gray-400 text-sm">Зураггүй</span>
    </div>
@endif
