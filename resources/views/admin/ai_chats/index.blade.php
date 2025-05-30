<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Чаты AI-консультанта
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            {{-- <th class="px-4 py-2 border">Пользователь</th> --}}
                            <th class="px-4 py-2 border">Вопрос</th>
                            <th class="px-4 py-2 border">Ответ</th>
                            <th class="px-4 py-2 border"></th>
                            <th class="px-4 py-2 border">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($chats as $chat)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $chat->id }}</td>
                                {{-- <td class="px-4 py-2 border text-gray-600">
                                    {{ $chat->user_id ?? 'Аноним' }}
                                </td> --}}
                                <td class="px-4 py-2 border text-gray-800">{{ Str::limit($chat->user_message, 100) }}</td>
                                <td class="px-4 py-2 border text-gray-700">{{ Str::limit($chat->bot_reply, 100) }}</td>
                                <td class="px-4 py-2 border text-gray-700"><a href="{{ route('admin.ai-chats.show', $chat->id) }}" class="text-blue-600 hover:underline">Открыть</a></td>
                                <td class="px-4 py-2 border text-gray-500">{{ $chat->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">Чатов пока нет</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $chats->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>