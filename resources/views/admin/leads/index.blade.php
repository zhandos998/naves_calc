<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Список заявок
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-200">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Имя</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Номер телефона</th>
                                {{-- <th class="px-4 py-2 border">Источник</th> --}}
                                <th class="px-4 py-2 border">Комментарий</th>
                                <th class="px-4 py-2 border">Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr class="border-t">
                                    <td class="px-4 py-2 border">{{ $lead->id }}</td>
                                    <td class="px-4 py-2 border">{{ $lead->name ?? '—' }}</td>
                                    <td class="px-4 py-2 border">{{ $lead->email ?? '—' }}</td>
                                    <td class="px-4 py-2 border">{{ $lead->phone ?? '—' }}</td>
                                    {{-- <td class="px-4 py-2 border text-gray-500">{{ $lead->source }}</td> --}}
                                    <td class="px-4 py-2 border">{{ Str::limit($lead->message, 100) }}</td>
                                    <td class="px-4 py-2 border text-gray-500">{{ $lead->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Заявок пока нет</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $leads->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
