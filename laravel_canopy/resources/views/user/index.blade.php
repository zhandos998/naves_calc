<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-800">
            Добро пожаловать в SuperCanopy
        </h1>
    </x-slot>

    <div class="bg-gray-100">
        {{-- Слайдер (просто изображение, можно заменить на компонент JS слайдера) --}}
        <div class="overflow-hidden shadow-lg">
            <img src="/storage/images/slider.png" alt="Навесы SuperCanopy" class="w-full object-cover" style="height:45rem">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 py-12">
            {{-- Информация о сайте --}}
            <div class="bg-white p-8 rounded shadow-md text-gray-700">
                <h2 class="text-2xl font-semibold text-blue-800 mb-4">О компании SuperCanopy</h2>
                <p>
                    Мы специализируемся на производстве и установке навесов различных форм: арочные, односкатные, полуарочные и многие другие.
                    С нашим 3D калькулятором вы можете рассчитать конструкцию и стоимость навеса онлайн. Доставка, монтаж, гарантия и качество — наш приоритет.
                </p>
            </div>

            {{-- Ссылка на 3D калькулятор --}}
            <div class="text-center">
                <a href="/calc" class="inline-block bg-blue-600 text-white font-semibold px-8 py-3 rounded hover:bg-blue-700 transition">
                    Перейти в 3D калькулятор навесов
                </a>
            </div>

            {{-- Популярные товары из магазина --}}
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Популярные товары</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($commodities as $item)
                        <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover rounded">
                            <div class="mt-4">
                                <h3 class="font-bold text-lg">{{ $item->title }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ Str::limit($item->description, 80) }}</p>
                                <span class="text-blue-700 font-semibold">{{ number_format($item->price, 0, '', ' ') }} ₸</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Последние статьи/услуги --}}
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Полезные статьи</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="bg-white p-6 rounded shadow hover:shadow-md transition">
                            <h3 class="text-lg font-semibold text-blue-700 mb-2">{{ $service->title }}</h3>
                            <p class="text-gray-600 text-sm">{{ Str::limit($service->description, 80) }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" class="text-blue-500 hover:underline mt-2 inline-block">Читать далее</a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
