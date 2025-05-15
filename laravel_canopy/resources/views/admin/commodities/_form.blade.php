<div class="space-y-4">

    <div>
        <label class="block text-sm font-medium text-gray-700">Название</label>
        <input type="text" name="title" value="{{ old('title', $commodity->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Описание</label>
        <textarea name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $commodity->description) }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Цена</label>
            <input type="number" name="price" value="{{ old('price', $commodity->price) }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Размер</label>
            <input type="text" name="size" value="{{ old('size', $commodity->size) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Материал</label>
            <input type="text" name="material" value="{{ old('material', $commodity->material) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Тип</label>
        <input type="text" name="type" value="{{ old('type', $commodity->type) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Фото</label>
        <input type="file" name="image" class="mt-1 block w-full text-gray-700">
        @if ($commodity->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $commodity->image) }}" alt="" class="h-32 rounded-md shadow">
            </div>
        @endif
    </div>

</div>
