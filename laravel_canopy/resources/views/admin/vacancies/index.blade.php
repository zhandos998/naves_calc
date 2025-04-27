<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Вакансии
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
                <a href="{{ route('vacancies.create') }}" class="inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">
                    Добавить вакансию
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                @foreach($vacancies as $vacancy)
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-semibold">{{ $vacancy->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $vacancy->description }}</p>

                        <div class="flex space-x-4">
                            <a href="{{ route('vacancies.edit', $vacancy->id) }}" class="text-blue-600 hover:underline">Редактировать</a>

                            <form action="{{ route('vacancies.destroy', $vacancy->id) }}" method="POST" onsubmit="return confirm('Удалить вакансию?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Удалить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
