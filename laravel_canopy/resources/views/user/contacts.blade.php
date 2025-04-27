<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Контакты') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 space-y-6">

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Наш офис</h3>
                    <p class="text-gray-600">
                        г. Алматы, ул. Абая 123
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Телефон</h3>
                    <p class="text-gray-600">
                        +7 (777) 123-45-67
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Электронная почта</h3>
                    <p class="text-gray-600">
                        info@supercanopy.kz
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Время работы</h3>
                    <p class="text-gray-600">
                        Пн–Пт: 09:00–18:00 <br>
                        Сб: 10:00–16:00
                    </p>
                </div>

                {{-- Карта (если нужна) --}}
                <div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!..."
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
