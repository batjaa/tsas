<x-layouts.storefront title="Бидний тухай">
    <section class="bg-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-storefront.section-heading title="Бидний тухай" />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="reveal">
                    <img src="https://picsum.photos/seed/about-team/600/400.webp" alt="TSAS баг" class="w-full h-80 object-cover" />
                </div>
                <div class="reveal">
                    <p class="text-gray-600 leading-relaxed mb-4">
                        TSAS нь 2015 оноос хойш Монголын зах зээлд мэргэжлийн ажлын хувцас, тоног төхөөрөмж нийлүүлж байна. Бид тогооч, эмч, зөөгч, нарийн боовчин зэрэг бүх мэргэжлийн хүмүүст зориулсан чанартай хувцсыг нэг дороос санал болгодог.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Манай бүтээгдэхүүнүүд нь тав тух, бат бөх чанар, мэргэжлийн дүр төрхийг хослуулсан байдаг. Бид Монгол даяар хүргэлтийн үйлчилгээ үзүүлдэг бөгөөд байгууллагын захиалга авч ажилладаг.
                    </p>
                    <div class="mt-6">
                        <a href="/products" class="inline-flex items-center px-6 py-3 bg-safety text-white font-oswald font-semibold text-sm uppercase tracking-wider hover:bg-orange-700 transition-colors">
                            Бүтээгдэхүүн үзэх
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-storefront.about-quote />
    <x-storefront.phone-cta />

    <div class="h-14 lg:hidden"></div>
</x-layouts.storefront>
