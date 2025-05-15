<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Товары
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6">

            <a href="{{ route('admin.commodities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Добавить товар
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full">
                    <thead class="text-left text-gray-600">
                        <tr>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach ($commodities as $commodity)
                            <tr class="border-b">
                                <td class="py-2">{{ $commodity->title }}</td>
                                <td class="py-2">{{ number_format($commodity->price, 0, '', ' ') }} ₸</td>
                                <td class="py-2 space-x-2">
                                    <a href="{{ route('admin.commodities.edit', $commodity) }}" class="text-blue-600 hover:underline">Редактировать</a>

                                    <form action="{{ route('admin.commodities.destroy', $commodity) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Удалить товар?')" class="text-red-600 hover:underline">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $commodities->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
