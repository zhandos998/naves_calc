<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Отзывы') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Список отзывов --}}
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 space-y-8">
                @forelse ($reviews as $review)
                    <div class="border-b pb-6">
                        <div class="flex items-center mb-4">
                            <div class="ml-4">
                                <div class="text-lg font-semibold text-gray-800">{{ $review->name }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y') }}</div>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            "{{ $review->content }}"
                        </p>
                    </div>
                @empty
                    <p class="text-gray-600">Пока нет отзывов.</p>
                @endforelse
            </div>

            {{-- Форма добавления отзыва --}}
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Оставить отзыв</h3>

                @if (session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('reviews.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Ваше имя</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Ваш отзыв</label>
                        <textarea name="content" id="content" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Отправить отзыв
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
