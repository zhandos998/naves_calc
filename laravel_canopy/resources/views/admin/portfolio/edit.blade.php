<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Редактировать работу
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <form action="{{ route('portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2">Название работы</label>
                        <input type="text" name="title" value="{{ old('title', $portfolio->title) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Текущее изображение</label>
                        @if($portfolio->image)
                            <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" class="w-full h-48 object-cover mb-4 rounded">
                        @else
                            <p class="text-gray-500">Нет изображения</p>
                        @endif
                        <input type="file" name="image" class="block w-full text-gray-700 mt-2">
                        <p class="text-sm text-gray-500 mt-1">Если хотите заменить изображение, загрузите новое</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Описание</label>
                        <textarea name="description" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('description', $portfolio->description) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
