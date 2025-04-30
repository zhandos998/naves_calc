<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Редактировать "Контакты"
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <form action="{{ route('admin.contacts.update', 1) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2">Телефон</label>
                        <input type="text" name="phone" value="{{ $contacts->phone }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="text" name="email" value="{{ $contacts->email }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Адрес</label>
                        <input type="text" name="address" value="{{ $contacts->address }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                    </div>

                    <div>
                        <button class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
