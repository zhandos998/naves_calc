<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            Калькулятор навеса
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Левая колонка — параметры --}}
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <h3 class="text-lg font-semibold text-blue-700">Параметры навеса</h3>

                <label class="block">
                    <span class="text-gray-700">Ширина (м)</span>
                    <input type="number" id="input-width" value="4" step="0.1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                </label>

                <label class="block">
                    <span class="text-gray-700">Длина (м)</span>
                    <input type="number" id="input-depth" value="8" step="0.1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                </label>

                <label class="block">
                    <span class="text-gray-700">Высота (м)</span>
                    <input type="number" id="input-height" value="3" step="0.1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                </label>

                <label class="block">
                    <span class="text-gray-700">Толщина столбцов</span>
                    <select id="input-post-thickness" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="0.06">60 × 60 мм</option>
                        <option value="0.08">80 × 80 мм</option>
                        <option value="0.10">100 × 100 мм</option>
                        <option value="0.12">120 × 120 мм</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-gray-700">Форма</span>
                    <select id="input-frame-type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="arched">Арочный</option>
                        <option value="half-arched">Полуарочный</option>
                        <option value="single-slope">Односкатный</option>
                        <option value="triangular">Треугольный</option>
                        <option value="channel">Швелер</option>
                        <option value="double-slope">Двухскатный</option>
                    </select>
                </label>

                <button class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Применить параметры
                </button>
            </div>

            {{-- Правая колонка — Three.js визуализация --}}
            <div class="bg-white rounded-lg shadow relative flex flex-col">

                <canvas id="three-canvas" class="w-full h-full min-h-[600px] bg-gray-100 rounded-t"></canvas>

                {{-- Информация --}}
                <div class="absolute top-4 left-4 bg-white/80 text-sm p-2 rounded shadow">
                    <p>Ширина: <span id="width">6</span> м</p>
                    <p>Длина: <span id="depth">4</span> м</p>
                    <p>Высота: <span id="height">3</span> м</p>
                </div>

                <div class="absolute top-4 right-4 bg-white/80 text-sm p-2 rounded shadow">
                    <p>Камера: <span id="camera-pos">—</span></p>
                </div>

                {{-- Кнопка сохранить --}}
                <div class="p-4 border-t">
                    <button id="save-canvas-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Скачать изображение
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Three.js --}}
    <script type="importmap">
        {
            "imports": {
                "three": "https://cdn.jsdelivr.net/npm/three@0.149.0/build/three.module.js",
                "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.149.0/examples/jsm/"
            }
        }
    </script>

    <script type="module" src="{{ asset('js/main_v2_comm.js') }}"></script>
</x-app-layout>
