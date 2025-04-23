import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

// Создание сцены
const scene = new THREE.Scene();
scene.background = new THREE.Color(0xf0f0f0); // Светло-серый фон

// Камера
const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.2, 1000);
camera.position.set(15, 2, 0); // Устанавливаем положение камеры

// Рендерер
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement); // Добавляем рендер в DOM

// Управление камерой (вращение, приближение, перемещение)
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true; // Плавное движение

// Освещение сцены
const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(5, 10, 5);
scene.add(light);

const ambientLight = new THREE.AmbientLight(0x404040);
scene.add(ambientLight);

// Материалы
const metalMaterial = new THREE.MeshStandardMaterial({ color: 0x888888, metalness: 0.7, roughness: 0.3 }); // Металлический материал для стоек
const roofMaterial = new THREE.MeshStandardMaterial({ color: 0x3399ff, transparent: true, opacity: 0.5 }); // Полупрозрачная крыша

// Группа объектов навеса
const canopy = new THREE.Group();
scene.add(canopy);

// Параметры навеса
const params = {
    width: 10, // Ширина
    depth: 4,  // Глубина
    height: 5, // Высота
    postThickness: 0.2, // Толщина стоек
    // frameType: "arched", // Тип крыши (по умолчанию арочный)
    frameType: "half-arched", // Тип крыши (по умолчанию арочный)
};

// Фундамент (основание навеса)
const foundationGeometry = new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1);
const foundationMaterial = new THREE.MeshStandardMaterial({ color: 0xaaaaaa });
const foundation = new THREE.Mesh(foundationGeometry, foundationMaterial);
foundation.position.y = -0.1;
canopy.add(foundation);

// Функция обновления навеса
function createCanopy() {
    // Очистка предыдущих элементов
    while (canopy.children.length > 0) {
        canopy.remove(canopy.children[0]);
    }

    // Пересоздание фундамента с новыми размерами
    const foundationGeometry = new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1);
    const foundation = new THREE.Mesh(foundationGeometry, foundationMaterial);
    foundation.position.y = -0.1;
    canopy.add(foundation);

    // Количество стоек (зависит от ширины)
    const numPosts = Math.max(2, Math.ceil(params.width / 2)); // Минимум 2 стойки
    const postGeometry = new THREE.BoxGeometry(params.postThickness, params.height, params.postThickness);

    // Добавляем стойки по краям
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
        for (let z of [-params.depth / 2, params.depth / 2]) {
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, params.height / 2, z);
            canopy.add(post);
        }
    }

    // Балки для крыши (горизонтальные перекладины)
    const roofSegments = numPosts - 1;
    const beamGeometry = new THREE.BoxGeometry(params.width / roofSegments + 1, 0.2, 0.2);

    for (let i = 0; i < roofSegments; i++) {
        let x = -params.width / 2 + (i * params.width) / roofSegments + params.width / (2 * roofSegments);
        for (let z of [-params.depth / 2, params.depth / 2]) {
            const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            beam.position.set(x, params.height, z);
            canopy.add(beam);
        }
    }

    // Удаляем предыдущую крышу, если есть
    canopy.children.forEach(child => {
        if (child.name === "roof") canopy.remove(child);
    });

    // Создание крыши в зависимости от выбранного типа
    let roof;
    if (params.frameType === "arched") {
        const roofPoints = [];
        const numArches = numPosts;
        const archSegments = 50;

        // Создаем арочные балки
        for (let i = 0; i < numPosts; i++) {
            let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
            let archCurve = new THREE.CatmullRomCurve3([
                new THREE.Vector3(x, params.height, -params.depth / 2),
                new THREE.Vector3(x, params.height + params.depth * 0.225, -params.depth / 4),
                new THREE.Vector3(x, params.height + params.depth * 0.3, 0),
                new THREE.Vector3(x, params.height + params.depth * 0.225, params.depth / 4),
                new THREE.Vector3(x, params.height, params.depth / 2)
            ], false);

            let tubeGeometry = new THREE.TubeGeometry(archCurve, 50, 0.1, 8, false);
            const arc = new THREE.Mesh(tubeGeometry, metalMaterial);
            canopy.add(arc);
            roofPoints.push(...archCurve.getPoints(archSegments));
        }

        // Создаем поверхность крыши
        const roofGeometry = new THREE.BufferGeometry();
        const vertices = [];
        const indices = [];
        const rowLength = archSegments + 1;

        for (let i = 0; i < numArches; i++) {
            for (let j = 0; j < rowLength - 1; j++) {
                let index1 = i * rowLength + j;
                let index2 = (i + 1) * rowLength + j;
                let index3 = i * rowLength + j + 1;
                let index4 = (i + 1) * rowLength + j + 1;

                if (roofPoints[index1] && roofPoints[index2] && roofPoints[index3] && roofPoints[index4]) {
                    vertices.push(
                        roofPoints[index1].x, roofPoints[index1].y, roofPoints[index1].z,
                        roofPoints[index2].x, roofPoints[index2].y, roofPoints[index2].z,
                        roofPoints[index3].x, roofPoints[index3].y, roofPoints[index3].z,
                        roofPoints[index4].x, roofPoints[index4].y, roofPoints[index4].z
                    );

                    let baseIndex = (i * (rowLength - 1) + j) * 4;
                    indices.push(
                        baseIndex, baseIndex + 1, baseIndex + 2,
                        baseIndex + 2, baseIndex + 1, baseIndex + 3
                    );
                }
            }
        }

        roofGeometry.setAttribute('position', new THREE.BufferAttribute(new Float32Array(vertices), 3));
        roofGeometry.setIndex(indices);
        roofGeometry.computeVertexNormals();

        roof = new THREE.Mesh(roofGeometry, roofMaterial);
        canopy.add(roof);
    }

    if (roof) {
        roof.name = "roof";
        roof.position.y = params.height + 0.1;
        canopy.add(roof);
    }
}

createCanopy();

// Анимация сцены
function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}
animate();

// Адаптация к изменению размеров окна
window.addEventListener('resize', () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
});
