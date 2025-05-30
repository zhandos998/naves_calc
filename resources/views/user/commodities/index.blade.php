<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Магазин
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Фильтры и сортировка --}}
            <div class="flex flex-wrap items-center justify-between mb-6 bg-white p-6 rounded-lg shadow-sm">
                <form method="GET" class="flex flex-wrap items-center gap-4 w-full md:w-auto">

                    {{-- Материал --}}
                    <select name="material" class="border-gray-300 rounded-md">
                        <option value="">Материал</option>
                        <option value="Поликарбонат" {{ request('material') == 'Поликарбонат' ? 'selected' : '' }}>Поликарбонат</option>
                        <option value="Металлочерепица" {{ request('material') == 'Металлочерепица' ? 'selected' : '' }}>Металлочерепица</option>
                    </select>

                    {{-- Сортировка --}}
                    <select name="sort" class="border-gray-300 rounded-md">
                        <option value="">Сортировка</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена по возрастанию</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена по убыванию</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Применить
                    </button>
                </form>
            </div>

            {{-- Карточки товаров --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @forelse ($commodities as $commodity)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col">
                        @if ($commodity->image)
                            <img src="{{ asset('storage/' . $commodity->image) }}" alt="{{ $commodity->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                Нет изображения
                            </div>
                        @endif

                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $commodity->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($commodity->description, 100) }}</p>
                            </div>

                            <div class="mt-auto">
                                @if($commodity->price)
                                    <div class="text-xl font-bold text-blue-600 mb-4">
                                        {{ number_format($commodity->price, 0, '', ' ') }} ₸
                                    </div>
                                @endif
                                <a href="{{ route('commodities.show', $commodity->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-600">
                        Товары не найдены.
                    </div>
                @endforelse
            </div>

            {{-- Пагинация --}}
            <div class="mt-8">
                {{ $commodities->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
