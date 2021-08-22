document.addEventListener("DOMContentLoaded", function(event) {
	BLOCK.virtual_tour.start()
});


BLOCK.virtual_tour = {
	container: {},
	ratio: 2,
	camera: {
		aspect: 0
	},
	scene: {},
	renderer: {},
	isUserInteracting: false,
	onMouseDownMouseX: 0,
	onMouseDownMouseY: 0,
	lon: 180,
	onMouseDownLon: 0,
	lat: 0,
	onMouseDownLat: 0,
	phi: 0,
	theta: 0,

	start: function(){
		BLOCK.virtual_tour.container = DAN.$('block_virtual_tour_container')
		BLOCK.virtual_tour.image = DAN.$('block_virtual_tour_image')
		let image_url = BLOCK.virtual_tour.image.dataset.image
		let loader = new THREE.TextureLoader();
		loader.load (
			image_url,
			function(texture){
				BLOCK.virtual_tour.init(texture)
			}
		)
	},
	
	init: function(texture){
		BLOCK.virtual_tour.ratio = texture.image.naturalWidth / texture.image.naturalHeight
		BLOCK.virtual_tour.camera = new THREE.PerspectiveCamera(75, BLOCK.virtual_tour.ratio, 1, 1100)
		BLOCK.virtual_tour.camera.target = new THREE.Vector3(0, 0, 0)
		BLOCK.virtual_tour.scene = new THREE.Scene()

		let geometry = new THREE.SphereBufferGeometry(500, 60, 40)
		// invert the geometry on the x-axis so that all of the faces point inward
		geometry.scale(-1, 1, 1)

		let material = new THREE.MeshBasicMaterial({map: texture})
		let mesh = new THREE.Mesh(geometry, material)
		BLOCK.virtual_tour.scene.add(mesh)

		BLOCK.virtual_tour.renderer = new THREE.WebGLRenderer()
		BLOCK.virtual_tour.renderer.setPixelRatio(window.devicePixelRatio)
		BLOCK.virtual_tour.renderer.setSize(BLOCK.virtual_tour.container.clientWidth, BLOCK.virtual_tour.container.clientWidth / BLOCK.virtual_tour.ratio)
		// BLOCK.virtual_tour.renderer.setSize(window.innerWidth, window.innerHeight)
		BLOCK.virtual_tour.container.appendChild(BLOCK.virtual_tour.renderer.domElement)

		document.addEventListener('mousedown', BLOCK.virtual_tour.onPointerStart, false)
		document.addEventListener('mousemove', BLOCK.virtual_tour.onPointerMove, false)
		document.addEventListener('mouseup', BLOCK.virtual_tour.onPointerUp, false)
		// document.addEventListener('wheel', BLOCK.virtual_tour.onDocumentMouseWheel, false)
		document.addEventListener('touchstart', BLOCK.virtual_tour.onPointerStart, false)
		document.addEventListener('touchmove', BLOCK.virtual_tour.onPointerMove, false)
		document.addEventListener('touchend', BLOCK.virtual_tour.onPointerUp, false)
		document.addEventListener('dragover', function(event){
			event.preventDefault()
			event.dataTransfer.dropEffect = 'copy'
		}, false)
		/*
		document.addEventListener('dragenter', function(){
			document.body.style.opacity = 0.5
		}, false)
		document.addEventListener('dragleave', function(){
			document.body.style.opacity = 1
		}, false)
		*/
		/*
		document.addEventListener('drop', function(event){
			event.preventDefault()
			let reader = new FileReader()
			reader.addEventListener('load', function(event){
				material.map.image.src = event.target.result
				material.map.needsUpdate = true
			}, false)
			reader.readAsDataURL(event.dataTransfer.files[0])
			document.body.style.opacity = 1
		}, false)
		*/
		window.addEventListener('resize', BLOCK.virtual_tour.onWindowResize, false)
		BLOCK.virtual_tour.animate()		
	},

	onPointerStart: function(event){
		BLOCK.virtual_tour.isUserInteracting = true
		let clientX = event.clientX || event.touches[0].clientX
		let clientY = event.clientY || event.touches[0].clientY
		BLOCK.virtual_tour.onMouseDownMouseX = clientX
		BLOCK.virtual_tour.onMouseDownMouseY = clientY
		BLOCK.virtual_tour.onMouseDownLon = BLOCK.virtual_tour.lon
		BLOCK.virtual_tour.onMouseDownLat = BLOCK.virtual_tour.lat
	},

	onPointerMove: function(event){
		if(BLOCK.virtual_tour.isUserInteracting){
			let clientX = event.clientX || event.touches[0].clientX
			let clientY = event.clientY || event.touches[0].clientY
			BLOCK.virtual_tour.lon = (BLOCK.virtual_tour.onMouseDownMouseX - clientX) * 0.1 + BLOCK.virtual_tour.onMouseDownLon
			BLOCK.virtual_tour.lat = (clientY - BLOCK.virtual_tour.onMouseDownMouseY) * 0.1 + BLOCK.virtual_tour.onMouseDownLat
		}
	},

	onPointerUp: function(){
		BLOCK.virtual_tour.isUserInteracting = false;
	},

	onDocumentMouseWheel: function(event){
		let fov = BLOCK.virtual_tour.camera.fov + event.deltaY * 0.05
		BLOCK.virtual_tour.camera.fov = THREE.Math.clamp(fov, 10, 75)
		BLOCK.virtual_tour.camera.updateProjectionMatrix()
	},

	onWindowResize: function(){
		BLOCK.virtual_tour.camera.aspect = BLOCK.virtual_tour.ratio
		BLOCK.virtual_tour.camera.updateProjectionMatrix()
		BLOCK.virtual_tour.renderer.setSize(BLOCK.virtual_tour.container.clientWidth, BLOCK.virtual_tour.container.clientWidth / BLOCK.virtual_tour.ratio)
		// BLOCK.virtual_tour.renderer.setSize(window.innerWidth, window.innerHeight)
	},

	animate: function(){
		requestAnimationFrame(BLOCK.virtual_tour.animate)
		BLOCK.virtual_tour.update()
	},

	update: function(){
		if (!BLOCK.virtual_tour.isUserInteracting){
			BLOCK.virtual_tour.lon += 0.1;
		}
		BLOCK.virtual_tour.lat = Math.max(-85, Math.min(85, BLOCK.virtual_tour.lat))
		BLOCK.virtual_tour.phi = THREE.Math.degToRad(90 - BLOCK.virtual_tour.lat)
		BLOCK.virtual_tour.theta = THREE.Math.degToRad(BLOCK.virtual_tour.lon)

		BLOCK.virtual_tour.camera.target.x = 500 * Math.sin(BLOCK.virtual_tour.phi) * Math.cos(BLOCK.virtual_tour.theta)
		BLOCK.virtual_tour.camera.target.y = 500 * Math.cos(BLOCK.virtual_tour.phi)
		BLOCK.virtual_tour.camera.target.z = 500 * Math.sin(BLOCK.virtual_tour.phi) * Math.sin(BLOCK.virtual_tour.theta)

		BLOCK.virtual_tour.camera.lookAt(BLOCK.virtual_tour.camera.target)

		// distortion
		// BLOCK.virtual_tour.camera.position.copy(BLOCK.virtual_tour.camera.target).negate()

		BLOCK.virtual_tour.renderer.render(BLOCK.virtual_tour.scene, BLOCK.virtual_tour.camera)
	}
}