document.getElementById('ai-send').addEventListener('click', async () => {
    const input = document.getElementById('ai-input');
    const text  = input.value.trim();
    if (!text) return;

    const msgs = document.getElementById('messages');
    msgs.innerHTML += `<div class="user">Вы: ${text}</div>`;
    input.value = '';

    const res = await fetch('/api/ai/chat', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({message: text})
    });
    const {reply} = await res.json();
    msgs.innerHTML += `<div class="bot">Бот: ${reply}</div>`;
    msgs.scrollTop = msgs.scrollHeight;
  });
