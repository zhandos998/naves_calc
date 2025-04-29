<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $service->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md">

            @if ($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-auto rounded-lg mb-8">
            @endif

            <div class="text-gray-800 space-y-4 leading-relaxed">
                {!! $service->content !!}
            </div>

        </div>
    </div>
</x-app-layout>
