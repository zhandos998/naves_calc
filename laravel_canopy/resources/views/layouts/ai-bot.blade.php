<!-- Кнопка-переключатель -->
<button id="ai-chat-toggle"
class="fixed bottom-4 right-4 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg focus:outline-none">
<!-- Иконка чата -->

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
    </svg>
</button>

<!-- Виджет чата -->
<div id="ai-chat-widget"
class="hidden fixed bottom-4 right-4 w-[50vw] h-[50vh] bg-white shadow-lg rounded-lg flex flex-col overflow-hidden">
<!-- Заголовок с кнопкой закрыть -->
<div class="flex justify-between items-center bg-blue-600 text-white p-2">
<h3 class="text-sm font-semibold">AI-Консультант</h3>
<button id="ai-chat-close" class="focus:outline-none">
<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
   viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M6 18L18 6M6 6l12 12"/>
</svg>
</button>
</div>
<!-- Сообщения -->
<div id="ai-chat-messages" class="flex-1 p-4 overflow-y-auto text-sm"></div>
<!-- Поле ввода -->
<div class="p-2 border-t flex">
<input id="ai-chat-input"
   class="flex-1 border rounded px-2 py-1 text-sm focus:outline-none"
   placeholder="Задайте вопрос…" value="какой навес купить ?">
<button id="ai-chat-send"
    class="ml-2 px-3 py-1 bg-blue-300 bg-blue-600 rounded-l-lg rounded-r-lg rounded-lg hover:bg-blue-700 text-white rounded text-sm">
Отправить
</button>
</div>
</div>

<!-- Ваш JS-файл с логикой чата и теперь и с открытием/закрытием -->
@vite('resources/js/ai-chat.js')
