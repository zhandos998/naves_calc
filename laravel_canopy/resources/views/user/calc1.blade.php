<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Калькулятор навесов</h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

            {{-- Левая колонка — форма --}}
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Введите параметры</h3>

                <form method="POST" action="{{ route('calc.calculate') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Ширина (м)</label>
                        <input type="number" step="0.1" name="width" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Длина (м)</label>
                        <input type="number" step="0.1" name="length" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Высота (м)</label>
                        <input type="number" step="0.1" name="height" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Толщина столбцов</label>
                        <select name="post_thickness" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="60x60">60 x 60 мм</option>
                            <option value="80x80">80 x 80 мм</option>
                            <option value="100x100">100 x 100 мм</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Форма фермы</label>
                        <select name="roof_shape" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="arched">Арочная</option>
                            <option value="semi-arched">Полуарочная</option>
                            <option value="flat">Прямая</option>
                        </select>
                    </div>

                    <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Рассчитать
                    </button>

                    @if(session('result'))
                        <div class="text-green-600 font-semibold">
                            Примерная стоимость: {{ session('result') }} ₸
                        </div>
                    @endif
                </form>

            </div>

            {{-- Правая колонка — 3D рендер --}}
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Визуализация</h3>
                <div id="three-canvas" class="w-full h-[500px] bg-gray-200 rounded-lg shadow-inner flex items-center justify-center">
                    <span class="text-gray-500">3D модель загружается...</span>
                </div>
            </div>

        </div>
    </div>

    {{-- Подключение Three.js (вставь свою логику сюда) --}}
    <script src="https://cdn.jsdelivr.net/npm/three@0.157.0/build/three.min.js"></script>
    <script>
        // сюда вставить свою функцию отрисовки
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        const container = document.getElementById('three-canvas');
        renderer.setSize(container.clientWidth, container.clientHeight);
        container.innerHTML = '';
        container.appendChild(renderer.domElement);

        const geometry = new THREE.BoxGeometry(1, 1, 1);
        const material = new THREE.MeshStandardMaterial({ color: 0x0077ff });
        const cube = new THREE.Mesh(geometry, material);
        scene.add(cube);

        const light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(2, 2, 5);
        scene.add(light);

        camera.position.z = 3;

        function animate() {
            requestAnimationFrame(animate);
            cube.rotation.y += 0.01;
            renderer.render(scene, camera);
        }

        animate();
    </script>
</x-app-layout>
