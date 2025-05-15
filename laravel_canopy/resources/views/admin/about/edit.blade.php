<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Редактировать "О нас"') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="text-gray-800">
                    <h1 class="text-2xl font-bold mb-6">Редактирование страницы "О нас"</h1>

                    <form action="{{ route('admin.about.update', 1) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Текст "О нас"
                            </label>
                            <textarea
                                id="content"
                                name="content"
                                rows="10"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            >{{ $about->content }}</textarea>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200 transition"
                            >
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
