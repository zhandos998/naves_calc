<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Редактировать вакансию
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <form action="{{ route('admin.vacancies.update', $vacancy->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2">Название вакансии</label>
                        <input type="text" name="title" value="{{ old('title', $vacancy->title) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Описание</label>
                        <textarea name="description" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">{{ old('description', $vacancy->description) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Обновить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
