<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Наши услуги
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            @foreach ($services as $service)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    @if ($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $service->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($service->description, 100) }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="inline-block text-blue-600 hover:underline">
                            Подробнее →
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="mt-8">
            {{ $services->links() }}
        </div>
    </div>
</x-app-layout>
