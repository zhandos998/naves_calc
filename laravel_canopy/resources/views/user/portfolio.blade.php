<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Наши работы') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                @forelse ($portfolios as $work)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        @if ($work->image)
                            <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                Нет изображения
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-blue-700 mb-2">{{ $work->title }}</h3>
                            <p class="text-gray-600 text-sm">{{ $work->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-600">
                        Пока нет работ.
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
