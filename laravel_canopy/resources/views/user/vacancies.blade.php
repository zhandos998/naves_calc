<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Вакансии') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 space-y-8">

                @forelse ($vacancies as $vacancy)
                    <div class="border-b pb-6">
                        <h3 class="text-2xl font-semibold text-blue-700 mb-2">{{ $vacancy->title }}</h3>
                        <p class="text-gray-700 mb-4">{{ $vacancy->description }}</p>
                        <a href="https://wa.me/77001234567?text=Здравствуйте! Хочу откликнуться на вакансию: {{ urlencode($vacancy->title) }}"
                            target="_blank"
                            class="inline-block px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                             Откликнуться в WhatsApp
                         </a>
                    </div>
                @empty
                    <p class="text-gray-600">На данный момент вакансий нет.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
