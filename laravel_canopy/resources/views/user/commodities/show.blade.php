<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $commodity->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Фото товара --}}
                <div>
                    @if ($commodity->image)
                        <img src="{{ asset('storage/' . $commodity->image) }}" alt="{{ $commodity->title }}" class="w-full h-auto rounded-lg shadow-sm">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg text-gray-400">
                            Нет изображения
                        </div>
                    @endif
                </div>

                {{-- Информация о товаре --}}
                <div class="space-y-6">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $commodity->title }}</h1>

                    @if($commodity->price)
                        <div class="text-2xl text-blue-600 font-bold">
                            {{ number_format($commodity->price, 0, '', ' ') }} ₸
                        </div>
                    @endif

                    <div class="text-gray-700 leading-relaxed">
                        {{ $commodity->description }}
                    </div>

                    <div class="space-y-2 text-gray-600">
                        @if ($commodity->size)
                            <div><span class="font-semibold">Размер:</span> {{ $commodity->size }}</div>
                        @endif
                        @if ($commodity->material)
                            <div><span class="font-semibold">Материал:</span> {{ $commodity->material }}</div>
                        @endif
                        @if ($commodity->type)
                            <div><span class="font-semibold">Тип:</span> {{ $commodity->type }}</div>
                        @endif
                    </div>

                    {{-- Кнопка Заказать --}}
                    <a href="https://wa.me/77001234567?text=Здравствуйте! Хочу заказать товар: {{ urlencode($commodity->title) }}"
                       target="_blank"
                       class="inline-block mt-4 px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-lg font-semibold">
                        Заказать в WhatsApp
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
