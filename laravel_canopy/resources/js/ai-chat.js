import { marked } from 'marked';

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('ai-chat-toggle');
    const closeBtn  = document.getElementById('ai-chat-close');
    const widget    = document.getElementById('ai-chat-widget');
    const sendBtn   = document.getElementById('ai-chat-send');
    const input     = document.getElementById('ai-chat-input');
    const msgs      = document.getElementById('ai-chat-messages');

    // Открыть/закрыть
    toggleBtn.addEventListener('click', () => {
      widget.classList.toggle('hidden');
    });
    closeBtn.addEventListener('click', () => {
      widget.classList.add('hidden');
    });

    // Отправка сообщения
    sendBtn.addEventListener('click', async () => {
        const text = input.value.trim();
        if (!text) return;

        // Добавляем ваше сообщение
        msgs.innerHTML += `
        <div class="mb-2 flex justify-end">
            <div class="bg-blue-300 text-gray-900 px-3 py-2 rounded-l-lg max-w-[80%]">
            ${text}
            </div>
        </div>`;
        input.value = '';
        msgs.scrollTop = msgs.scrollHeight;

        // Запрос к API
        try {
            const res = await fetch('/api/ai/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: text }),
            });
            const { reply } = await res.json();

            // Добавляем ответ бота
            msgs.innerHTML += `
            <div class="mb-2 flex justify-start">
                <div class="bg-blue-300 text-gray-900 px-3 py-2 rounded-r-lg max-w-[80%] prose prose-sm">
                ${marked(reply)}
                </div>
            </div>`;
            msgs.scrollTop = msgs.scrollHeight;
        } catch (e) {
            msgs.innerHTML += `<div class="mb-2 text-left text-red-600">Ошибка при соединении с ботом.</div>`;
            msgs.scrollTop = msgs.scrollHeight;
        }
    });

    // Отправлять по Enter
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendBtn.click();
        }
    });
  });
