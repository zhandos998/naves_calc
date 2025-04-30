<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Настройки калькулятора</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.calc.update') }}">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    <x-input-label for="base_price_per_m2" value="Базовая цена за 1 м²" />
                    <x-text-input type="number" step="0.01" name="base_price_per_m2" :value="$settings->base_price_per_m2" required />

                    <x-input-label for="materials_coef" value="Коэффициент материалов" />
                    <x-text-input type="number" step="0.01" name="materials_coef" :value="$settings->materials_coef" required />

                    <x-input-label for="consumables_coef" value="Коэффициент расходников" />
                    <x-text-input type="number" step="0.01" name="consumables_coef" :value="$settings->consumables_coef" required />

                    <x-input-label for="manufacturing_coef" value="Коэффициент производства" />
                    <x-text-input type="number" step="0.01" name="manufacturing_coef" :value="$settings->manufacturing_coef" required />

                    <x-input-label for="installation_coef" value="Коэффициент монтажа" />
                    <x-text-input type="number" step="0.01" name="installation_coef" :value="$settings->installation_coef" required />

                    <x-input-label for="delivery_price" value="Цена доставки (₸)" />
                    <x-text-input type="number" step="1" name="delivery_price" :value="$settings->delivery_price" required />

                    <x-input-label for="discount_amount" value="Скидка (₸)" />
                    <x-text-input type="number" step="1" name="discount_amount" :value="$settings->discount_amount" required />

                    <x-primary-button class="mt-4">Сохранить настройки</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
