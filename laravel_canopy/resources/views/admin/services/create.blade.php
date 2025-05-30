<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Добавить услугу
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @include('admin.services._form', ['service' => new \App\Models\Service])

                    <div>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
