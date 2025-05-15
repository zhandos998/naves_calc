<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Список заявок</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Дата</th>
                        <th class="px-4 py-2">Имя</th>
                        <th class="px-4 py-2">Телефон</th>
                        <th class="px-4 py-2">Итого</th>
                        <th class="px-4 py-2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $req->created_at }}</td>
                            <td class="px-4 py-2">{{ $req->name }}</td>
                            <td class="px-4 py-2">{{ $req->phone }}</td>
                            <td class="px-4 py-2">{{ number_format($req->final_price, 0, '.', ' ') }} ₸</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('calc.from_request', $req->id) }}"
                                   class="text-blue-600 hover:underline">Открыть</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Заявки отсутствуют</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
