<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Добро пожаловать') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                    <a href="{{ url('/about') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">О нас</h3>
                        <p class="text-gray-600 text-sm">Узнайте больше о нашей компании.</p>
                    </a>

                    <a href="{{ url('/contacts') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">Контакты</h3>
                        <p class="text-gray-600 text-sm">Как с нами связаться.</p>
                    </a>

                    <a href="{{ url('/vacancies') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">Вакансии</h3>
                        <p class="text-gray-600 text-sm">Актуальные вакансии в нашей компании.</p>
                    </a>

                    <a href="{{ url('/reviews') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">Отзывы</h3>
                        <p class="text-gray-600 text-sm">Отзывы наших клиентов.</p>
                    </a>

                    <a href="{{ url('/portfolio') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">Наши работы</h3>
                        <p class="text-gray-600 text-sm">Примеры выполненных проектов.</p>
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
