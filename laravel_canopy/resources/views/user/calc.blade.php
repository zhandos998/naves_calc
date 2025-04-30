<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            Калькулятор навеса
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Левая колонка — параметры --}}
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <h3 class="text-lg font-semibold text-blue-700">Параметры навеса</h3>

                <form method="POST" action="{{ route('calc.calculate') }}" class="space-y-4">
                    @csrf

                    <label class="block">
                        <span class="text-gray-700">Ширина (м)</span>
                        <input type="number" name="width" id="input-width" value="4" step="0.1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Длина (м)</span>
                        <input type="number" name="length" id="input-depth" value="8" step="0.1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Высота (м)</span>
                        <input type="number" name="height" id="input-height" value="3" step="0.1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Толщина столбцов</span>
                        <select name="post_thickness" id="input-post-thickness" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="0.06">60 × 60 мм</option>
                            <option value="0.08">80 × 80 мм</option>
                            <option value="0.10">100 × 100 мм</option>
                            <option value="0.12">120 × 120 мм</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Форма</span>
                        <select name="frame_type" id="input-frame-type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="arched">Арочный</option>
                            <option value="half-arched">Полуарочный</option>
                            <option value="single-slope">Односкатный</option>
                            <option value="triangular">Треугольный</option>
                            <option value="channel">Швелер</option>
                            <option value="double-slope">Двухскатный</option>
                        </select>
                    </label>

                    <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Рассчитать стоимость
                    </button>
                </form>
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

        @if(session('calc_result'))
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <h3 class="text-xl font-bold mb-4">Стоимость навеса:</h3>
                <ul class="space-y-1 text-sm">
                    <li class="flex justify-between items-center">
                        <span>Площадь:</span>
                        <strong>{{ session('calc_result.area') }} м²</strong>
                    </li>
                    <li class="flex justify-between items-center">
                        <span>Материалы:</span>
                        <span>{{ number_format(session('calc_result.materials'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span>Расходные материалы:</span>
                        <span>{{ number_format(session('calc_result.consumables'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span>Производство:</span>
                        <span>{{ number_format(session('calc_result.manufacturing'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span>Монтажные работы:</span>
                        <span>{{ number_format(session('calc_result.installation'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span>Доставка:</span>
                        <span>{{ number_format(session('calc_result.delivery'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center font-semibold">
                        <span>Общая стоимость:</span>
                        <span>{{ number_format(session('calc_result.total'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center text-green-700 font-semibold">
                        <span>Скидка:</span>
                        <span>-{{ number_format(session('calc_result.discount'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center text-xl font-bold">
                        <span>Итого:</span>
                        <span>{{ number_format(session('calc_result.final'), 0, '.', ' ') }} ₸</span>
                    </li>
                    <li class="flex justify-between items-center text-sm text-gray-500">
                        <span>Стоимость за 1 м²:</span>
                        <span>{{ number_format(session('calc_result.per_m2'), 0, '.', ' ') }} ₸</span>
                    </li>
                </ul>
            </div>


            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <div class="flex flex-col space-y-2">
                    @if(session('calc_result'))
                    <form method="POST" action="{{ route('request.store') }}">
                        @csrf
                        <input type="hidden" name="width" value="{{ session('input.width') }}">
                        <input type="hidden" name="length" value="{{ session('input.length') }}">
                        <input type="hidden" name="height" value="{{ session('input.height') }}">
                        <input type="hidden" name="post_thickness" value="{{ session('input.post_thickness') }}">
                        <input type="hidden" name="frame_type" value="{{ session('input.frame_type') }}">

                        <input type="hidden" name="area" value="{{ session('calc_result.area') }}">
                        <input type="hidden" name="materials" value="{{ session('calc_result.materials') }}">
                        <input type="hidden" name="consumables" value="{{ session('calc_result.consumables') }}">
                        <input type="hidden" name="manufacturing" value="{{ session('calc_result.manufacturing') }}">
                        <input type="hidden" name="installation" value="{{ session('calc_result.installation') }}">
                        <input type="hidden" name="delivery" value="{{ session('calc_result.delivery') }}">
                        <input type="hidden" name="discount" value="{{ session('calc_result.discount') }}">
                        <input type="hidden" name="total" value="{{ session('calc_result.total') }}">
                        <input type="hidden" name="final" value="{{ session('calc_result.final') }}">
                        <input type="hidden" name="per_m2" value="{{ session('calc_result.per_m2') }}">

                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            Сохранить расчёт и отправить заявку
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endif

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
