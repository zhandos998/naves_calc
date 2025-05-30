<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Чат #{{ $chat->id }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
                <div><strong>Пользователь:</strong> {{ $chat->user_id ?? 'Аноним' }}</div>

                <div>
                    <strong>Вопрос:</strong>
                    <p class="mt-1 p-3 bg-gray-100 rounded border">{{ $chat->user_message }}</p>
                </div>

                <div>
                    <strong>Ответ:</strong>
                    <div id="bot-reply" class="prose prose-sm max-w-none mt-2 bg-blue-50 p-4 rounded"></div>
                </div>

                <div class="text-gray-500 text-sm mt-2">Дата: {{ $chat->created_at->format('d.m.Y H:i') }}</div>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const raw = @json($chat->bot_reply);
            document.getElementById('bot-reply').innerHTML = window.marked.parse(raw);
        });
    </script>
</x-app-layout>
