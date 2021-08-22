document.addEventListener("DOMContentLoaded", function(event) {
	// BLOCK.image_360.init()
	/*
	let container_id = 'block_image_360_wrap'
	let image_id = 'block_image_360_img'
	let path = DAN.$('block_image_360_wrap').dataset.path
	let img_360_1 = new DAN_image_360(container_id, image_id, path)
	img_360_1.start()
	*/
	BLOCK.image_360.init()
});

BLOCK.image_360 = {
	first_start: true,  // Первый старт
	num_current: 1,
	img_360: [],
	init() {
		let path_1 = DAN.$('block_image_360_wrap').dataset.path
		this.start(1, path_1)  // Первый экземпляр класса == нажатию на первую кнопку (num=1)
		let buttons = document.getElementsByClassName('block_image_360_nav_images')
		for (var i = 0; i < buttons.length; i++) {
			buttons[i].onclick = (e)=>{
				this.first_start = false
				buttons[this.num_current-1].classList.remove('active')
				let but = e.target
				but.classList.add('active')
				let num = but.dataset.num
				let path = but.dataset.path
				this.num_current = num
				this.start(num, path)
			}
		}
	},

	start(num, path) {
		let container_id = 'block_image_360_wrap'
		DAN.$(container_id).innerHTML = ''

		image_id = 'block_image_360_img'

		DAN.$(container_id).dataset.path = path

		if (!this.img_360[num])
			this.img_360[num] = new DAN_image_360(container_id, image_id, path)

		let n = Math.round(this.img_360[num].options.n_count/2) - 1
		let m = Math.round(this.img_360[num].options.m_count/2) - 1

		let src = path + n + '_' + m + '.jpg';
		DAN.$(container_id).innerHTML = '<img id="block_image_360_img" src="' + src + '" class="dan_image_360_img" style="opacity: 1;">'

		if (!this.first_start) {  // Если это не первый старт - то режим 'over'
			this.img_360[num].options.mode = 'over'
		}

		this.img_360[num].start()
	}
}
