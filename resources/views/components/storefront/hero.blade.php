@props(['images' => []])

<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <!-- Text -->
            <div class="reveal">
                <p class="font-mono text-sm text-safety tracking-wider uppercase mb-3">Мэргэжлийн ажлын хувцас</p>
                <h1 class="font-oswald text-4xl sm:text-5xl lg:text-6xl font-bold text-charcoal leading-tight">
                    Чанартай хувцас,<br>
                    <span class="text-safety">мэргэжлийн</span> дүр төрх
                </h1>
                <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-lg">
                    Тогооч, эмч, зөөгч, нарийн боовчин — бүх мэргэжлийн ажлын хувцсыг нэг дороос. Монгол даяар хүргэлттэй.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="/products" class="inline-flex items-center px-8 py-3 bg-safety text-white font-oswald font-semibold text-base uppercase tracking-wider hover:bg-orange-700 transition-colors">
                        Бүтээгдэхүүн үзэх
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="tel:+976{{ config('site.phone') }}" class="inline-flex items-center px-8 py-3 border-2 border-charcoal text-charcoal font-oswald font-semibold text-base uppercase tracking-wider hover:bg-charcoal hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        Залгах
                    </a>
                </div>
            </div>

            <!-- Image collage — editorial spread -->
            <div class="reveal relative h-[28rem] sm:h-[32rem] lg:h-[36rem]">
                @if(isset($images[0]))
                    <div class="absolute top-0 left-0 w-[55%] h-[60%] overflow-hidden shadow-lg">
                        <img src="{{ $images[0]['url'] }}" alt="{{ $images[0]['alt'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
                    </div>
                @endif
                @if(isset($images[1]))
                    <div class="absolute top-6 right-0 w-[40%] h-[45%] overflow-hidden shadow-lg">
                        <img src="{{ $images[1]['url'] }}" alt="{{ $images[1]['alt'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
                    </div>
                @endif
                @if(isset($images[2]))
                    <div class="absolute bottom-0 left-[10%] w-[42%] h-[42%] overflow-hidden shadow-lg">
                        <img src="{{ $images[2]['url'] }}" alt="{{ $images[2]['alt'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
                    </div>
                @endif
                @if(isset($images[3]))
                    <div class="absolute bottom-4 right-[5%] w-[38%] h-[35%] overflow-hidden shadow-lg">
                        <img src="{{ $images[3]['url'] }}" alt="{{ $images[3]['alt'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
                    </div>
                @endif
                <!-- Accent block -->
                <div class="absolute -bottom-3 -left-3 w-24 h-24 bg-safety/10 -z-10"></div>
                <div class="absolute -top-3 -right-3 w-16 h-16 border-2 border-safety/30 -z-10"></div>
            </div>
        </div>
    </div>
</section>
