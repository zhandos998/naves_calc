<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Услуги
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="flex justify-end">
                <a href="{{ route('admin.services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Добавить услугу
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left text-gray-600">
                    <thead>
                        <tr>
                            <th class="py-2">Название</th>
                            <th class="py-2">Slug</th>
                            <th class="py-2">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach ($services as $service)
                            <tr class="border-b">
                                <td class="py-2">{{ $service->title }}</td>
                                <td class="py-2">{{ $service->slug }}</td>
                                <td class="py-2 space-x-4">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:underline">Редактировать</a>

                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Удалить услугу?')" class="text-red-600 hover:underline">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $services->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
