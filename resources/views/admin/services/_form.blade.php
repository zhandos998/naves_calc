<div class="space-y-4">

    <div>
        <label class="block text-sm font-medium text-gray-700">Название</label>
        <input type="text" name="title" value="{{ old('title', $service->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Краткое описание</label>
        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $service->description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Основной текст</label>
        <textarea name="content" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('content', $service->content) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Изображение</label>
        <input type="file" name="image" class="mt-1 block w-full text-gray-700">
        @if ($service->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $service->image) }}" alt="" class="h-32 rounded-md shadow">
            </div>
        @endif
    </div>

</div>
