<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Наши работы
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
                <a href="{{ route('portfolio.create') }}" class="inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">
                    Добавить работу
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portfolios as $work)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col">
                        @if($work->image)
                            <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                Нет изображения
                            </div>
                        @endif

                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-semibold mb-2">{{ $work->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ $work->description }}</p>
                            </div>

                            <div class="flex justify-between items-center mt-auto">
                                <a href="{{ route('portfolio.edit', $work->id) }}" class="text-blue-600 hover:underline">Редактировать</a>

                                <form action="{{ route('portfolio.destroy', $work->id) }}" method="POST" onsubmit="return confirm('Удалить работу?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
