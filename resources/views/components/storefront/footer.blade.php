<footer class="bg-charcoal text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Brand -->
            <div>
                <h3 class="font-oswald text-2xl font-bold text-white mb-4">TSAS</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Мэргэжлийн ажлын хувцас, тоног төхөөрөмжийн худалдаа. 2015 оноос хойш Монголын зах зээлд үйл ажиллагаа явуулж байна.
                </p>
            </div>

            <!-- Quick links -->
            <div>
                <h4 class="font-oswald text-sm font-semibold uppercase tracking-wider text-gray-400 mb-4">Цэс</h4>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-300 hover:text-safety transition-colors text-sm">Нүүр</a></li>
                    <li><a href="/products" class="text-gray-300 hover:text-safety transition-colors text-sm">Бүтээгдэхүүн</a></li>
                    <li><a href="/about" class="text-gray-300 hover:text-safety transition-colors text-sm">Бидний тухай</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <h4 class="font-oswald text-sm font-semibold uppercase tracking-wider text-gray-400 mb-4">Ангилал</h4>
                <ul class="space-y-2">
                    <li><a href="/products?category=Тогооч" class="text-gray-300 hover:text-safety transition-colors text-sm">Тогооч</a></li>
                    <li><a href="/products?category=Эмнэлэг" class="text-gray-300 hover:text-safety transition-colors text-sm">Эмнэлэг</a></li>
                    <li><a href="/products?category=Нярав / Үйлчилгээ" class="text-gray-300 hover:text-safety transition-colors text-sm">Нярав / Үйлчилгээ</a></li>
                    <li><a href="/products?category=Нарийн боовчин" class="text-gray-300 hover:text-safety transition-colors text-sm">Нарийн боовчин</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-oswald text-sm font-semibold uppercase tracking-wider text-gray-400 mb-4">Холбоо барих</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-safety shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <a href="tel:+976{{ config('site.phone') }}" class="text-gray-300 hover:text-safety transition-colors text-sm font-mono">{{ substr(config('site.phone'), 0, 4) }}-{{ substr(config('site.phone'), 4) }}</a>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-safety shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <a href="mailto:info@tsas.mn" class="text-gray-300 hover:text-safety transition-colors text-sm">info@tsas.mn</a>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-safety shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-300 text-sm">Улаанбаатар хот, Сүхбаатар дүүрэг</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-10 pt-6 text-center">
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} TSAS. Бүх эрх хуулиар хамгаалагдсан.</p>
        </div>
    </div>
</footer>
