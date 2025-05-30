<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Отзывы
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                @foreach($reviews as $review)
                    <div class="border-b py-4">
                        <h3 class="text-lg font-semibold">{{ $review->name }}</h3>
                        <p class="text-gray-600">{{ $review->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
