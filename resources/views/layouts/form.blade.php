<div class="bg-gray-100 p-6 rounded-md max-w-7xl mx-auto mt-10">
    {{-- max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 py-12 --}}
    <h3 class="text-lg font-semibold mb-4">Оставьте заявку</h3>
    <form id="lead-form" class="space-y-4">
        <div class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="name" placeholder="Имя"
                   class="w-full sm:w-1/3 p-3 border border-gray-300 rounded" required/>
            <input type="email" name="email" placeholder="Email"
                    class="w-full sm:w-1/3 p-3 border border-gray-300 rounded" />
            <input type="text" name="phone" placeholder="+7(7XX)XXX-XX-XX"
                    class="w-full sm:w-1/3 p-3 border border-gray-300 rounded" required/>
        </div>
        <textarea name="message" rows="4" placeholder="Написать комментарий..."
                  class="w-full p-2 border border-gray-300 rounded"></textarea>
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded transition">
                Отправить
            </button>
        </div>
        <div id="lead-success" class="hidden text-green-600 mt-3">✅ Ваша заявка отправлена!</div>
    </form>
</div>
<script>
    document.getElementById('lead-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const form = e.target;

      const data = {
        name: form.name.value,
        email: form.email.value,
        phone: form.phone.value,
        message: form.message.value,
        source: 'form'
      };

      const res = await fetch('/api/crm/leads', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });

      if (res.ok) {
        form.reset();
        document.getElementById('lead-success').classList.remove('hidden');
      }
    });
</script>
