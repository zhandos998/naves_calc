import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

const scene = new THREE.Scene();
scene.background = new THREE.Color(0xf0f0f0);

const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.2, 1000);
camera.position.set(15, 2, 0);


const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;

const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(5, 10, 5);
scene.add(light);
scene.add(new THREE.AmbientLight(0x404040));

const metalMaterial = new THREE.MeshStandardMaterial({ color: 0x888888, metalness: 0.7, roughness: 0.3 });

const canopy = new THREE.Group();
scene.add(canopy);

const params = {
    width: 10,
    depth: 4,
    height: 5,
    postThickness: 0.2,
    frameType: "arched", 
};


class ArchCurve extends THREE.Curve {
    constructor(startX, endX, height) {
        super();
        this.startX = startX;
        this.endX = endX;
        this.height = height;
    }

    getPoint(t) {
        const x = THREE.MathUtils.lerp(this.startX, this.endX, t);
        const y = this.height + Math.sin(t * Math.PI) * (this.height / 2);
        return new THREE.Vector3(x, y, 0);
    }
}

function createCanopyArched() {
    canopy.clear();

    
    const foundation = new THREE.Mesh(
        new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1),
        new THREE.MeshStandardMaterial({ color: 0xaaaaaa })
    );
    foundation.position.y = -0.1;
    canopy.add(foundation);

    
    const numPosts = Math.max(2, Math.ceil(params.width / 2));
    const postGeometry = new THREE.BoxGeometry(params.postThickness, params.height, params.postThickness);
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
        [-params.depth / 2, params.depth / 2].forEach(z => {
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, params.height / 2, z);
            canopy.add(post);
        });
    }

    
    const roofSegments = numPosts - 1;
    const beamGeometry = new THREE.BoxGeometry(params.width / roofSegments + 1, params.postThickness, params.postThickness);
    for (let i = 0; i < roofSegments; i++) {
        let x = -params.width / 2 + (i * params.width) / roofSegments + params.width / (2 * roofSegments);
        [-params.depth / 2, params.depth / 2].forEach(z => {
            const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            beam.position.set(x, params.height, z);
            canopy.add(beam);
        });
    }

    
    let roofPoints = [];
    const numArches = numPosts;
    const archSegments = 50;

    for (let i = 0; i < numPosts; i++) {
        let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
        
        
        let archCurve;

        
        archCurve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height, -params.depth / 2),
            new THREE.Vector3(x, params.height + params.depth * 0.225, -params.depth / 4),
            new THREE.Vector3(x, params.height + params.depth * 0.3, 0),
            new THREE.Vector3(x, params.height + params.depth * 0.225, params.depth / 4),
            new THREE.Vector3(x, params.height, params.depth / 2)
        ], false);

        
        const size = params.postThickness; 
        const squareShape = new THREE.Shape();
        squareShape.moveTo(-size / 2, -size / 2);
        squareShape.lineTo(size / 2, -size / 2);
        squareShape.lineTo(size / 2, size / 2);
        squareShape.lineTo(-size / 2, size / 2);
        squareShape.lineTo(-size / 2, -size / 2); 

        
        const extrudeSettings = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve 
        };

        
        const geometry = new THREE.ExtrudeGeometry(squareShape, extrudeSettings);
        const mesh = new THREE.Mesh(geometry, metalMaterial);
        canopy.add(mesh);

        
        const smoothPoints = archCurve.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + 0.05 + params.postThickness/2-0.1, p.z)
        );
        roofPoints.push(...smoothPoints);
    }

    
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

    
    const roofMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3399ff, 
        side: THREE.DoubleSide, 
        transparent: true, 
        opacity: 0.5 
    });

    
    const roof = new THREE.Mesh(roofGeometry, roofMaterial);
    roof.position.y = params.height + 0.1;
    canopy.add(roof);
}

function createCanopyHalfArched() {
    canopy.clear();

    
    const foundation = new THREE.Mesh(
        new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1),
        new THREE.MeshStandardMaterial({ color: 0xaaaaaa })
    );
    foundation.position.y = -0.1;
    canopy.add(foundation);

    
    const numPosts = Math.max(2, Math.ceil(params.width / 2));
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
    
        
        const zPositions = [-params.depth / 2, params.depth / 2];
    
        zPositions.forEach(z => {
            
            let isLeft = z < 0; 
            let postHeight = params.height;
    
            postHeight = isLeft
                ? params.height + params.depth * 0.3/1.5 
                : params.height;      
            
    
            const postGeometry = new THREE.BoxGeometry(params.postThickness, postHeight, params.postThickness);
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, postHeight / 2, z);
            canopy.add(post);
        });
    }

    
    const roofSegments = numPosts - 1;
    const beamLength = params.width / roofSegments + 1;
    const beamGeometry = new THREE.BoxGeometry(beamLength, params.postThickness, params.postThickness);

    for (let i = 0; i < roofSegments; i++) {
        let x = -params.width / 2 + (i * params.width) / roofSegments + params.width / (2 * roofSegments);
        [-params.depth / 2, params.depth / 2].forEach(z => {
            let isLeft = z < 0; 
            let beamHeight = params.height;

            beamHeight = isLeft
                ? params.height + params.depth * 0.3/1.5 
                : params.height;          const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            beam.position.set(x, beamHeight, z);
            canopy.add(beam);
        });
    }

    
    let roofPoints = [];
    const numArches = numPosts;
    const archSegments = 50;

    for (let i = 0; i < numPosts; i++) {
        let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
        let archCurve;

        
        archCurve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, -params.depth / 2),
            new THREE.Vector3(x, params.height + params.depth * 0.275/1.5, -params.depth / 4),
            new THREE.Vector3(x, params.height + params.depth * 0.225/1.5, 0),
            new THREE.Vector3(x, params.height + params.depth * 0.140/1.5, params.depth / 4),
            new THREE.Vector3(x, params.height + params.depth * 0.0, params.depth / 2)
        ], false);
        
        const size = params.postThickness; 
        const squareShape = new THREE.Shape();
        squareShape.moveTo(-size / 2, -size / 2);
        squareShape.lineTo(size / 2, -size / 2);
        squareShape.lineTo(size / 2, size / 2);
        squareShape.lineTo(-size / 2, size / 2);
        squareShape.lineTo(-size / 2, -size / 2); 

        
        const extrudeSettings = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve 
        };

        
        const geometry = new THREE.ExtrudeGeometry(squareShape, extrudeSettings);
        const mesh = new THREE.Mesh(geometry, metalMaterial);
        canopy.add(mesh);

        
        const smoothPoints = archCurve.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + params.postThickness/2 - 0.05, p.z)
        );
        roofPoints.push(...smoothPoints);
    }

    
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

    const roofMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3399ff, 
        side: THREE.DoubleSide, 
        transparent: true, 
        opacity: 0.5 
    });

    const roof = new THREE.Mesh(roofGeometry, roofMaterial);
    roof.position.y = params.height + 0.1;
    canopy.add(roof);
}

function createCanopySingleSlope() {
    canopy.clear();

    const foundation = new THREE.Mesh(
        new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1),
        new THREE.MeshStandardMaterial({ color: 0xaaaaaa })
    );
    foundation.position.y = -0.1;
    canopy.add(foundation);

    const numPosts = Math.max(2, Math.ceil(params.width / 2));
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
    
        const zPositions = [-params.depth / 2, params.depth / 2];
    
        zPositions.forEach(z => {
            
            let isLeft = z < 0; 
            let postHeight = params.height;
    
            postHeight = isLeft
                ? params.height + params.depth * 0.3/1.5 
                : params.height;      
    
            const postGeometry = new THREE.BoxGeometry(params.postThickness, postHeight, params.postThickness);
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, postHeight / 2, z);
            canopy.add(post);
        });
    }

    const roofSegments = numPosts - 1;
    const beamLength = params.width / roofSegments + 1;
    const beamGeometry = new THREE.BoxGeometry(beamLength, params.postThickness, params.postThickness);

    for (let i = 0; i < roofSegments; i++) {
        let x = -params.width / 2 + (i * params.width) / roofSegments + params.width / (2 * roofSegments);

        [-params.depth / 2, params.depth / 2].forEach(z => {
            let isLeft = z < 0; 
            let beamHeight = params.height;

            beamHeight = isLeft
                ? params.height + params.depth * 0.3/1.5 
                : params.height;          const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            beam.position.set(x, beamHeight, z);
            canopy.add(beam);
        });
    }

    let roofPoints = [];
    const numArches = numPosts;
    const archSegments = 50;

    for (let i = 0; i < numPosts; i++) {
        let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
        let archCurve;

        archCurve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, -params.depth / 2),
            
            
            
            new THREE.Vector3(x, params.height + params.depth * 0.0, params.depth / 2)
        ], false);
        
        const size = params.postThickness; 
        const squareShape = new THREE.Shape();
        squareShape.moveTo(-size / 2, -size / 2);
        squareShape.lineTo(size / 2, -size / 2);
        squareShape.lineTo(size / 2, size / 2);
        squareShape.lineTo(-size / 2, size / 2);
        squareShape.lineTo(-size / 2, -size / 2); 

        const extrudeSettings = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve 
        };

        const geometry = new THREE.ExtrudeGeometry(squareShape, extrudeSettings);
        const mesh = new THREE.Mesh(geometry, metalMaterial);
        canopy.add(mesh);

        
        const smoothPoints = archCurve.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + params.postThickness/2 - 0.05, p.z)
        );
        roofPoints.push(...smoothPoints);
    }

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

    const roofMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3399ff, 
        side: THREE.DoubleSide, 
        transparent: true, 
        opacity: 0.5 
    });

    
    const roof = new THREE.Mesh(roofGeometry, roofMaterial);
    roof.position.y = params.height + 0.1;
    canopy.add(roof);
}

function createCanopyTriangular() {
    canopy.clear();

    const foundation = new THREE.Mesh(
        new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1),
        new THREE.MeshStandardMaterial({ color: 0xaaaaaa })
    );
    foundation.position.y = -0.1;
    canopy.add(foundation);

    
    const numPosts = Math.max(2, Math.ceil(params.width / 2));
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
    
        
        const zPositions = [-params.depth / 2, params.depth / 2];
    
        zPositions.forEach(z => {
            
            let isLeft = z < 0; 
            let postHeight = params.height;

            const postGeometry = new THREE.BoxGeometry(params.postThickness, postHeight, params.postThickness);
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, postHeight / 2, z);
            canopy.add(post);
        });
    }

    const roofSegments = numPosts - 1;
    const beamLength = params.width / roofSegments + 1;
    const beamGeometry = new THREE.BoxGeometry(beamLength, 0.2, 0.2);

    for (let i = 0; i < roofSegments; i++) {
        let x = -params.width / 2 + (i * params.width) / roofSegments + params.width / (2 * roofSegments);

        [-params.depth / 2, params.depth / 2].forEach(z => {
            let isLeft = z < 0; 
            let beamHeight = params.height;

            beamHeight = isLeft
                ? params.height + params.depth * 0.3/1.5 
                : params.height;          const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            beam.position.set(x, beamHeight, z);
            canopy.add(beam);
            if(isLeft){
                let beamHeight = params.height;
                const beam = new THREE.Mesh(beamGeometry, metalMaterial);
                beam.position.set(x, beamHeight, z);
                canopy.add(beam);
            }
        });
    }

    let roofPoints = [];
    const numArches = numPosts;
    const archSegments = 50;
    for (let i = 0; i < numPosts; i++) {
        let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
        let archCurve,archCurve2,archCurve1;

        archCurve1 = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height, -params.depth / 2),
            new THREE.Vector3(x, params.height, params.depth / 2)
        ], false);

        const size = params.postThickness; 
        const squareShape = new THREE.Shape();
        squareShape.moveTo(-size / 2, -size / 2);
        squareShape.lineTo(size / 2, -size / 2);
        squareShape.lineTo(size / 2, size / 2);
        squareShape.lineTo(-size / 2, size / 2);
        squareShape.lineTo(-size / 2, -size / 2); 

        const extrudeSettings1 = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve1 
        };

        const geometry1 = new THREE.ExtrudeGeometry(squareShape, extrudeSettings1);
        const mesh1 = new THREE.Mesh(geometry1, metalMaterial);
        canopy.add(mesh1);
        
        archCurve2 = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, -params.depth / 2),
            new THREE.Vector3(x, params.height, -params.depth / 2)
        ], false);
        
        const extrudeSettings2 = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve2 
        };

        const geometry2 = new THREE.ExtrudeGeometry(squareShape, extrudeSettings2);
        const mesh2 = new THREE.Mesh(geometry2, metalMaterial);
        canopy.add(mesh2);

        archCurve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, -params.depth / 2),
            new THREE.Vector3(x, params.height + params.depth * 0.0, params.depth / 2)
        ], false);

        const extrudeSettings = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve 
        };

        const geometry = new THREE.ExtrudeGeometry(squareShape, extrudeSettings);
        const mesh = new THREE.Mesh(geometry, metalMaterial);
        canopy.add(mesh);

        const smoothPoints = archCurve.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + 0.05, p.z)
        );
        roofPoints.push(...smoothPoints);
    }

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

    const roofMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3399ff, 
        side: THREE.DoubleSide, 
        transparent: true, 
        opacity: 0.5 
    });

    const roof = new THREE.Mesh(roofGeometry, roofMaterial);
    roof.position.y = params.height + 0.1;
    canopy.add(roof);
}

function createCanopyChannel() {
    canopy.clear();

    const foundation = new THREE.Mesh(
        new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1),
        new THREE.MeshStandardMaterial({ color: 0xaaaaaa })
    );
    foundation.position.y = -0.1;
    canopy.add(foundation);
    const numPosts = Math.max(2, Math.ceil(params.width / 2));
    const maxHeight = params.height + params.width * 0.1; 
    const minHeight = params.height;     
    
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
    
        const zPositions = [-params.depth / 2, params.depth / 2];
    
        
        const progress = i / (numPosts - 1);
        
        
        const postHeight = minHeight + progress * (maxHeight - minHeight);
    
        zPositions.forEach(z => {
            const postGeometry = new THREE.BoxGeometry(params.postThickness, postHeight, params.postThickness);
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, postHeight / 2, z);
            canopy.add(post);
        });
    }
    
    const roofSegments = numPosts - 1;
    const beamThickness = params.postThickness;

    for (let i = 0; i < roofSegments; i++) {
        let x1 = -params.width / 2 + (i * params.width) / roofSegments;
        let x2 = -params.width / 2 + ((i + 1) * params.width) / roofSegments;

        let progress1 = i / (numPosts - 1);
        let progress2 = (i + 1) / (numPosts - 1);

        const maxHeight = params.height + params.width * 0.1;
        const minHeight = params.height;
        const height1 = minHeight + progress1 * (maxHeight - minHeight);
        const height2 = minHeight + progress2 * (maxHeight - minHeight);

        const dx = x2 - x1;
        const dy = height2 - height1;
        const length = Math.sqrt(dx * dx + dy * dy) + params.postThickness * 5;
        const angle = Math.atan2(dy, dx); 

        [-params.depth / 2, params.depth / 2].forEach(z => {
            
            const beamGeometry = new THREE.BoxGeometry(length, beamThickness, beamThickness);
            const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            const centerX = (x1 + x2) / 2;
            const centerY = (height1 + height2) / 2;

            beam.position.set(centerX, centerY, z);

            
            beam.rotation.z = angle;

            canopy.add(beam);
        });
    }

    let roofPoints = [];
    const numArches = numPosts;
    const archSegments = 50;
    const maxRoofHeight = params.height + params.width * 0.1;
    const minRoofHeight = params.height;

    for (let i = 0; i < numPosts; i++) {
        let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
        const progress = i / (numPosts - 1); 
        let archCurve;

        const height = minRoofHeight + progress * (maxRoofHeight - minRoofHeight);
        
        archCurve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, height, -params.depth / 2),
            new THREE.Vector3(x, height, params.depth / 2)
        ], false);
        
        const size = params.postThickness; 
        const squareShape = new THREE.Shape();
        squareShape.moveTo(-size / 2, -size / 2);
        squareShape.lineTo(size / 2, -size / 2);
        squareShape.lineTo(size / 2, size / 2);
        squareShape.lineTo(-size / 2, size / 2);
        squareShape.lineTo(-size / 2, -size / 2); 

        const extrudeSettings = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve 
        };

        const geometry = new THREE.ExtrudeGeometry(squareShape, extrudeSettings);
        const mesh = new THREE.Mesh(geometry, metalMaterial);
        canopy.add(mesh);

        const smoothPoints = archCurve.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + 0.05, p.z)
        );
        roofPoints.push(...smoothPoints);
    }

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

    const roofMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3399ff, 
        side: THREE.DoubleSide, 
        transparent: true, 
        opacity: 0.5 
    });

    const roof = new THREE.Mesh(roofGeometry, roofMaterial);
    roof.position.y = params.height + 0.1;
    canopy.add(roof);
}

function createCanopyDoubleSlope() {
    canopy.clear();
    const foundation = new THREE.Mesh(
        new THREE.BoxGeometry(params.width + 1, 0.2, params.depth + 1),
        new THREE.MeshStandardMaterial({ color: 0xaaaaaa })
    );
    foundation.position.y = -0.1;
    canopy.add(foundation);
    const numPosts = Math.max(2, Math.ceil(params.width / 2));
    for (let i = 0; i < numPosts; i++) {
        let x = -params.width / 2 + (i * params.width) / (numPosts - 1);
        const zPositions = [-params.depth / 2, params.depth / 2];
        zPositions.forEach(z => {
            let isLeft = z < 0; 
            let postHeight = params.height;
            const postGeometry = new THREE.BoxGeometry(params.postThickness, postHeight, params.postThickness);
            const post = new THREE.Mesh(postGeometry, metalMaterial);
            post.position.set(x, postHeight / 2, z);
            canopy.add(post);
        });
    }
    
    const roofSegments = numPosts - 1;
    const beamLength = params.width / roofSegments + 1;
    const beamGeometry = new THREE.BoxGeometry(beamLength, params.postThickness, params.postThickness);

    for (let i = 0; i < roofSegments; i++) {
        let x = -params.width / 2 + (i * params.width) / roofSegments + params.width / (2 * roofSegments);

        [-params.depth / 2, params.depth / 2].forEach(z => {
            let isLeft = z < 0; 
            let beamHeight = params.height;
            const beam = new THREE.Mesh(beamGeometry, metalMaterial);
            beam.position.set(x, beamHeight, z);
            canopy.add(beam);
            if(isLeft){
                let beamHeight = params.height + params.depth * 0.3/1.5;
                const beam = new THREE.Mesh(beamGeometry, metalMaterial);
                beam.position.set(x, beamHeight, 0);
                canopy.add(beam);
            }
        });
    }

    let roofPoints1 = [];
    let roofPoints2 = [];
    const numArches = numPosts;
    const archSegments = 50;
    for (let i = 0; i < numPosts; i++) {
        let x = -(params.width + 0.8) / 2 + (i * (params.width + 0.8)) / (numPosts - 1);
        let archCurve3,archCurve4,archCurve2,archCurve1;

        archCurve1 = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height, -params.depth / 2),
            new THREE.Vector3(x, params.height, params.depth / 2)
        ], false);

        const size = params.postThickness; 
        const squareShape = new THREE.Shape();
        squareShape.moveTo(-size / 2, -size / 2);
        squareShape.lineTo(size / 2, -size / 2);
        squareShape.lineTo(size / 2, size / 2);
        squareShape.lineTo(-size / 2, size / 2);
        squareShape.lineTo(-size / 2, -size / 2); 

        const extrudeSettings1 = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve1 
        };

        const geometry1 = new THREE.ExtrudeGeometry(squareShape, extrudeSettings1);
        const mesh1 = new THREE.Mesh(geometry1, metalMaterial);
        canopy.add(mesh1);
        
        archCurve2 = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, 0),
            new THREE.Vector3(x, params.height, 0)
        ], false);
        
        const extrudeSettings2 = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve2 
        };

        const geometry2 = new THREE.ExtrudeGeometry(squareShape, extrudeSettings2);
        const mesh2 = new THREE.Mesh(geometry2, metalMaterial);
        canopy.add(mesh2);

        archCurve3 = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, 0),
            new THREE.Vector3(x, params.height + params.depth * 0.0, params.depth / 2)
        ], false);

        const extrudeSettings3 = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve3 
        };

        const geometry3 = new THREE.ExtrudeGeometry(squareShape, extrudeSettings3);
        const mesh3 = new THREE.Mesh(geometry3, metalMaterial);
        canopy.add(mesh3);

        archCurve4 = new THREE.CatmullRomCurve3([
            new THREE.Vector3(x, params.height + params.depth * 0.0, -params.depth / 2),
            new THREE.Vector3(x, params.height + params.depth * 0.3/1.5, 0)
        ], false);

        const extrudeSettings4 = {
            steps: 100,
            bevelEnabled: false,
            extrudePath: archCurve4 
        };

        const geometry4 = new THREE.ExtrudeGeometry(squareShape, extrudeSettings4);
        const mesh4 = new THREE.Mesh(geometry4, metalMaterial);
        canopy.add(mesh4);
        const smoothPoints1 = archCurve4.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + 0.05, p.z)
        );
        const smoothPoints2 = archCurve3.getPoints(archSegments).map(p =>
            new THREE.Vector3(p.x * 1.025, p.y - params.height + 0.05, p.z)
        );
        roofPoints1.push(...smoothPoints1);
        roofPoints2.push(...smoothPoints2);
    }
    
    const roofGeometry1 = new THREE.BufferGeometry();
    const roofGeometry2 = new THREE.BufferGeometry();
    const vertices1 = [],vertices2 = [];
    const indices1 = [],indices2 = [];
    const rowLength = archSegments + 1;

    for (let i = 0; i < numArches; i++) {
        for (let j = 0; j < rowLength - 1; j++) {
            let index1 = i * rowLength + j;
            let index2 = (i + 1) * rowLength + j;
            let index3 = i * rowLength + j + 1;
            let index4 = (i + 1) * rowLength + j + 1;

            if (roofPoints1[index1] && roofPoints1[index2] && roofPoints1[index3] && roofPoints1[index4]) {
                vertices1.push(
                    roofPoints1[index1].x, roofPoints1[index1].y, roofPoints1[index1].z,
                    roofPoints1[index2].x, roofPoints1[index2].y, roofPoints1[index2].z,
                    roofPoints1[index3].x, roofPoints1[index3].y, roofPoints1[index3].z,
                    roofPoints1[index4].x, roofPoints1[index4].y, roofPoints1[index4].z
                );

                let baseIndex = (i * (rowLength - 1) + j) * 4;
                indices1.push(
                    baseIndex, baseIndex + 1, baseIndex + 2,
                    baseIndex + 2, baseIndex + 1, baseIndex + 3
                );
            }
        }
    }
    roofGeometry1.setAttribute('position', new THREE.BufferAttribute(new Float32Array(vertices1), 3));
    roofGeometry1.setIndex(indices1);
    roofGeometry1.computeVertexNormals();
    
    const roofMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3399ff, 
        side: THREE.DoubleSide, 
        transparent: true, 
        opacity: 0.5 
    });
    const roof1 = new THREE.Mesh(roofGeometry1, roofMaterial);
    roof1.position.y = params.height + 0.1;
    canopy.add(roof1);

    for (let i = 0; i < numArches; i++) {
        for (let j = 0; j < rowLength - 1; j++) {
            let index1 = i * rowLength + j;
            let index2 = (i + 1) * rowLength + j;
            let index3 = i * rowLength + j + 1;
            let index4 = (i + 1) * rowLength + j + 1;
            if (roofPoints2[index1] && roofPoints2[index2] && roofPoints2[index3] && roofPoints2[index4]) {
                vertices2.push(
                    roofPoints2[index1].x, roofPoints2[index1].y, roofPoints2[index1].z,
                    roofPoints2[index2].x, roofPoints2[index2].y, roofPoints2[index2].z,
                    roofPoints2[index3].x, roofPoints2[index3].y, roofPoints2[index3].z,
                    roofPoints2[index4].x, roofPoints2[index4].y, roofPoints2[index4].z
                );
                let baseIndex = (i * (rowLength - 1) + j) * 4;
                indices2.push(
                    baseIndex, baseIndex + 1, baseIndex + 2,
                    baseIndex + 2, baseIndex + 1, baseIndex + 3
                );
            }
        }
    }
    roofGeometry2.setAttribute('position', new THREE.BufferAttribute(new Float32Array(vertices2), 3));
    roofGeometry2.setIndex(indices2);
    roofGeometry2.computeVertexNormals();
    const roof2 = new THREE.Mesh(roofGeometry2, roofMaterial);
    roof2.position.y = params.height + 0.1;
    canopy.add(roof2);
}


createCanopyArched();


function animate() {
    requestAnimationFrame(animate);
    controls.update();
    document.getElementById('camera-pos').textContent = 
        `x: ${camera.position.x.toFixed(2)}, y: ${camera.position.y.toFixed(2)}, z: ${camera.position.z.toFixed(2)}`;
    renderer.render(scene, camera);
}
animate();


window.addEventListener('resize', () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
});


function updateCanopy() {
    params.depth = parseFloat(document.getElementById('input-width').value);
    params.width = parseFloat(document.getElementById('input-depth').value);
    params.height = parseFloat(document.getElementById('input-height').value);
    params.postThickness = parseFloat(document.getElementById('input-post-thickness').value);
    params.frameType = document.getElementById('input-frame-type').value;
    
    switch (params.frameType) {
        case "arched":
            createCanopyArched();
            break;
        case "half-arched":
            createCanopyHalfArched();
            break;
        case "single-slope":
            createCanopySingleSlope();
            break;
        case "triangular":
            createCanopyTriangular();
            break;
        case "channel":
            createCanopyChannel(); 
            break;
        case "double-slope":
            createCanopyDoubleSlope();
            break;
        default:
            console.warn("Неизвестный тип крыши:", params.frameType);
            createCanopyArched(); 
            break;
    }
}


document.getElementById('input-width').oninput = updateCanopy;
document.getElementById('input-depth').oninput = updateCanopy;
document.getElementById('input-height').oninput = updateCanopy;
document.getElementById('input-post-thickness').oninput = updateCanopy;
document.getElementById('input-frame-type').onchange = updateCanopy;
