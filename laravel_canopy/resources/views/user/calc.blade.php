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

                <form id="ajax-calc-form" class="space-y-4">
                    {{-- <form method="POST" action="{{ route('calc.calculate') }}" class="space-y-4"> --}}
                    @csrf

                    <label class="block">
                        <span class="text-gray-700">Ширина (м)</span>


                        <input type="number" name="width" id="input-width" value="{{ old('width', $prefill['width'] ?? 4) }}" step="0.1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Длина (м)</span>
                        <input type="number" name="length" id="input-depth" value="{{ old('width', $prefill['length'] ?? 8) }}" step="0.1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Высота (м)</span>
                        <input type="number" name="height" id="input-height" value="{{ old('width', $prefill['height'] ?? 3) }}" step="0.1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Толщина столбцов</span>
                        <select name="post_thickness" id="input-post-thickness" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="0.06" {{ ($prefill['post_thickness'] ?? '') == '0.06' ? 'selected' : '' }}>60 × 60 мм</option>
                            <option value="0.08" {{ ($prefill['post_thickness'] ?? '') == '0.08' ? 'selected' : '' }}>80 × 80 мм</option>
                            <option value="0.10" {{ ($prefill['post_thickness'] ?? '') == '0.10' ? 'selected' : '' }}>100 × 100 мм</option>
                            <option value="0.12" {{ ($prefill['post_thickness'] ?? '') == '0.12' ? 'selected' : '' }}>120 × 120 мм</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Форма</span>
                        <select name="frame_type" id="input-frame-type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="arched" {{ ($prefill['frame_type'] ?? '') == 'arched' ? 'selected' : '' }}>Арочный</option>
                            <option value="half-arched" {{ ($prefill['frame_type'] ?? '') == 'half-arched' ? 'selected' : '' }}>Полуарочный</option>
                            <option value="single-slope" {{ ($prefill['frame_type'] ?? '') == 'single-slope' ? 'selected' : '' }}>Односкатный</option>
                            <option value="triangular" {{ ($prefill['frame_type'] ?? '') == 'triangular' ? 'selected' : '' }}>Треугольный</option>
                            <option value="channel" {{ ($prefill['frame_type'] ?? '') == 'channel' ? 'selected' : '' }}>Швелер</option>
                            <option value="double-slope" {{ ($prefill['frame_type'] ?? '') == 'double-slope' ? 'selected' : '' }}>Двухскатный</option>
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

        {{-- @if(session('calc_result')) --}}
        <div id="calc-result-section" class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <h3 class="text-xl font-bold mb-4">Стоимость навеса:</h3>
                <div id="calc-result">
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
            </div>

            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                @auth
                <div class="flex flex-col space-y-2">
                    {{-- @if(session('calc_result')) --}}
                    {{-- <form method="POST" action="{{ route('request.store') }}"> --}}
                    <form id="ajax-request-form">
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
                    {{-- @endif --}}
                </div>
                @else
                <div class="text-center mt-4 p-4 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded">
                    Чтобы сохранить расчёт и отправить заявку — <a href="{{ route('login') }}" class="underline font-semibold">войдите</a> или <a href="{{ route('register') }}" class="underline font-semibold">зарегистрируйтесь</a>.
                </div>
                @endauth
                <div class="flex flex-col space-y-2">
                    {{-- @if(session('calc_result')) --}}
                        <form method="POST" action="{{ route('request.download_pdf') }}" id="pdfForm">
                            @csrf
                            <input type="hidden" name="canvas_image" id="canvasImageInput">
                            <input type="hidden" name="width" value="{{ session('input.width') }}">
                            <input type="hidden" name="length" value="{{ session('input.length') }}">
                            <input type="hidden" name="height" value="{{ session('input.height') }}">
                            <input type="hidden" name="post_thickness" value="{{ session('input.post_thickness') }}">
                            <input type="hidden" name="frame_type" value="{{ session('input.frame_type') }}">
                            {{--
                            @foreach (session('calc_result') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach --}}

                            <button type="submit" id="save-canvas-btn-2" class="mt-3 w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                                Скачать PDF
                            </button>
                        </form>
                    {{-- @endif --}}

                </div>
            </div>
        </div>
        {{-- @endif --}}

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

    <script>
        document.getElementById('calc-result-section').style.display = 'none';
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('ajax-calc-form');

            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch("{{ route('calc.calculate') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {


                        const result = data.calc_result;
                        document.querySelector('#calc-result').innerHTML = `
                            <ul class="space-y-1 text-sm">
                                <li class="flex justify-between items-center"><span>Площадь:</span><strong>${result.area} м²</strong></li>
                                <li class="flex justify-between items-center"><span>Материалы:</span><span>${result.materials.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center"><span>Расходные материалы:</span><span>${result.consumables.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center"><span>Производство:</span><span>${result.manufacturing.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center"><span>Монтажные работы:</span><span>${result.installation.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center"><span>Доставка:</span><span>${result.delivery.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center font-semibold"><span>Общая стоимость:</span><span>${result.total.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center text-green-700 font-semibold"><span>Скидка:</span><span>-${result.discount.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center text-xl font-bold"><span>Итого:</span><span>${result.final.toLocaleString()} ₸</span></li>
                                <li class="flex justify-between items-center text-sm text-gray-500"><span>Стоимость за 1 м²:</span><span>${result.per_m2.toLocaleString()} ₸</span></li>
                            </ul>
                        `;
                        document.getElementById('canvasImageInput').value = document.getElementById('three-canvas').toDataURL('image/png');

                        const pdfForm = document.getElementById('pdfForm');

                        pdfForm.querySelector('input[name="width"]').value = data.input.width;
                        pdfForm.querySelector('input[name="length"]').value = data.input.length;
                        pdfForm.querySelector('input[name="height"]').value = data.input.height;
                        pdfForm.querySelector('input[name="post_thickness"]').value = data.input.post_thickness;
                        pdfForm.querySelector('input[name="frame_type"]').value = data.input.frame_type;

                        // Перебираем поля расчёта
                        for (const [key, value] of Object.entries(result)) {
                            const input = document.querySelector(`#pdfForm input[name="${key}"]`);
                            if (input) {
                                input.value = value;
                            } else {
                                const hidden = document.createElement('input');
                                hidden.type = 'hidden';
                                hidden.name = key;
                                hidden.value = value;
                                document.getElementById('pdfForm').appendChild(hidden);
                            }
                        }

                        const requestForm = document.getElementById('ajax-request-form');

                        if (requestForm) {
                            // Входные параметры
                            requestForm.querySelector('input[name="width"]').value = data.input.width;
                            requestForm.querySelector('input[name="length"]').value = data.input.length;
                            requestForm.querySelector('input[name="height"]').value = data.input.height;
                            requestForm.querySelector('input[name="post_thickness"]').value = data.input.post_thickness;
                            requestForm.querySelector('input[name="frame_type"]').value = data.input.frame_type;

                            // Результаты расчета
                            for (const [key, value] of Object.entries(result)) {
                                const input = requestForm.querySelector(`input[name="${key}"]`);
                                if (input) {
                                    input.value = value;
                                } else {
                                    const hidden = document.createElement('input');
                                    hidden.type = 'hidden';
                                    hidden.name = key;
                                    hidden.value = value;
                                    requestForm.appendChild(hidden);
                                }
                            }
                        }
                        document.getElementById('calc-result-section').style.display = 'grid';
                    } else {
                        alert('Ошибка при расчёте');
                    }
                })
                .catch(err => {
                    console.error('Ошибка:', err);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('ajax-request-form');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log(form);

                const formData = new FormData(form);

                console.log(formData);
                fetch("{{ route('request.store') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Заявка отправлена успешно!');
                    } else if (data.errors) {
                        alert('Ошибка: ' + Object.values(data.errors).join(', '));
                    }
                })
                .catch(error => {
                    console.error('Ошибка при отправке:', error);
                });
            });
        });
    </script>

    {{-- <script>

        document.getElementById('save-canvas-btn').addEventListener('click', () => {
            renderer.render(scene, camera); // <== ещё раз на всякий случай
            // const canvas = document.getElementById('three-canvas');
            const image = canvas.toDataURL('image/png');

            const link = document.createElement('a');
            link.href = image;
            link.download = 'canopy-visualization.png';
            link.click();
        });

        function captureCanvas() {
            renderer.render(scene, camera); // <== ещё раз на всякий случай
            // const canvas = document.getElementById('three-canvas');
            const image = canvas.toDataURL('image/png');
            document.getElementById('canvasImageInput').value = image;
        }
    </script> --}}

</x-app-layout>
