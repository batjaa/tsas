@props(['flipped' => false])

<div class="w-full overflow-hidden leading-none {{ $flipped ? 'rotate-180' : '' }}">
    <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-8 sm:h-12" preserveAspectRatio="none">
        <path d="M0 30C240 60 480 0 720 30C960 60 1200 0 1440 30V60H0V30Z" fill="currentColor" class="text-white" />
    </svg>
</div>
