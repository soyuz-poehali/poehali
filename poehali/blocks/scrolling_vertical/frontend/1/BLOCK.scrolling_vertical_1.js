document.addEventListener("DOMContentLoaded", function(event) {
	BLOCK.scrolling_vertical.start()
});


BLOCK.scrolling_vertical = {
	touch_start: {
		x: 0,
		y: 0
	},
	touch_last: {
		x: 0,
		y: 0
	},
	margin_start: {  // Начальное значение margin top - для touch
		top: 0,
		left: 0
	},  
	touch_dist_start: 0,  // Начальная дистанция щипка
	date: false,   // Временная метка начала перетаскивания - lkz touch
	zoom_start: 1,

	start(){
		if (!BLOCK) 
			return

		let wrap_arr = document.getElementsByClassName("block_scrolling_vertical_image_wrap");

		// mousemove
		for (i = 0; i < wrap_arr.length; i++) {
			let img = wrap_arr[i].childNodes[0]
			img.dataset.mode = 'true'
			img.dataset.zoom = 1

			BLOCK.scrolling_vertical.play(img)

			wrap_arr[i].addEventListener('mousemove', BLOCK.scrolling_vertical.mousemove)

			wrap_arr[i].addEventListener('mouseenter', function(e){
				e.preventDefault()
				let img = this.childNodes[0]
				img.dataset.mode = ''
			})

			wrap_arr[i].addEventListener('mouseout', function(e){
				e.preventDefault()
				let img = this.childNodes[0]
				img.dataset.mode = 'true'
			})

			wrap_arr[i].addEventListener('touchstart', function(e){
				e.preventDefault()
				let tt = e.targetTouches
				let wrap = e.target.parentNode
				let img = this.childNodes[0]

				img.dataset.mode = ''
				BLOCK.scrolling_vertical.zoom_start = img.dataset.zoom

				BLOCK.scrolling_vertical.touch_start = {
					x: e.touches[0].pageX - wrap.getBoundingClientRect().left,
					y: e.touches[0].clientY - wrap.getBoundingClientRect().top
				}

				if (tt.length >= 2) {
					// Щипок
					BLOCK.scrolling_vertical.touch_dist_start = BLOCK.scrolling_vertical.touch_pinch_distance(tt[0], tt[1])
				}

				BLOCK.scrolling_vertical.margin_start.top = Number(img.style.marginTop.substring(0, img.style.marginTop.length - 2))
				BLOCK.scrolling_vertical.margin_start.left = Number(img.style.marginLeft.substring(0, img.style.marginLeft.length - 2))
				BLOCK.scrolling_vertical.date = new Date();
			})

			wrap_arr[i].addEventListener('touchend', function(e){
				e.preventDefault()

				let img = this.childNodes[0]
				img.dataset.mode = 'true'

				let delta_y = BLOCK.scrolling_vertical.touch_last.y - BLOCK.scrolling_vertical.touch_start.y
				let delta_time = new Date() - BLOCK.scrolling_vertical.date

				let v = delta_y/delta_time
				BLOCK.scrolling_vertical.touch_auto(img, v)
			})

			wrap_arr[i].addEventListener('touchmove', function(e){
				let wrap = this
				let img = this.childNodes[0]
				let tt = e.targetTouches

				if (tt.length >= 2) {
					// Если есть щипотка - режим увеличения
					let zoom = (BLOCK.scrolling_vertical.touch_pinch_distance(tt[0], tt[1]) - BLOCK.scrolling_vertical.touch_dist_start)/BLOCK.scrolling_vertical.touch_dist_start
					let zoom_new = Number(BLOCK.scrolling_vertical.zoom_start) + Number(zoom)

					BLOCK.scrolling_vertical.set_zoom(img, zoom_new)
				} else {
					// Режим смещения
					let x = e.touches[0].clientX - wrap.getBoundingClientRect().left
					let y = e.touches[0].clientY - wrap.getBoundingClientRect().top
					BLOCK.scrolling_vertical.touchmove(wrap, img, x, y)  // wrap, img, x, y
				}
			})

			if (img.offsetHeight > wrap_arr[i].offsetHeight) {
				BLOCK.scrolling_vertical.play(img)
			}
		}
	},

	mousemove(e){
		e.preventDefault()
		let wrap = this
		let x = e.pageX - wrap.getBoundingClientRect().left - window.pageXOffset
		let y = e.pageY - wrap.getBoundingClientRect().top - window.pageYOffset
		BLOCK.scrolling_vertical.output(wrap, x, y)
	},

	// Перемещение при движении
	touchmove(wrap, img, x, y){
		BLOCK.scrolling_vertical.touch_last = {'x': x, 'y': y}

		let margin_top = Math.round(y - BLOCK.scrolling_vertical.touch_start.y)
		let margin_top_new = BLOCK.scrolling_vertical.margin_start.top + margin_top

		// Проверка попадания в границу wrap
		if (margin_top_new > 0)
			margin_top_new = 0
		if (-margin_top_new > img.getBoundingClientRect().height - wrap.getBoundingClientRect().height)
			margin_top_new = -(img.getBoundingClientRect().height - wrap.getBoundingClientRect().height)

		if (Number(img.dataset.zoom > 1)) {
			let margin_left = Math.round(x - BLOCK.scrolling_vertical.touch_start.x)
			let margin_left_new = BLOCK.scrolling_vertical.margin_start.left + margin_left

			// Проверка попадания в границу wrap
			if (margin_left_new > 0)
				margin_left_new = 0
			if (-margin_left_new > img.getBoundingClientRect().width - wrap.getBoundingClientRect().width)
				margin_left_new = -(img.getBoundingClientRect().width - wrap.getBoundingClientRect().width)

			img.style.marginLeft = margin_left_new + 'px'
		}

		img.style.marginTop = margin_top_new + 'px'
	},

	// Автоматическое завершение прокрутки с замедляющимся скролом при быстром листании
	touch_auto(img, v){
		let wrap = img.parentNode
		let sign = Math.sign(v)
		let v_abs = Math.abs(v) - 0.05  // 0.05 - показатель уменьшения скорости
		let v_new = sign*v_abs

		let margin_top_old = Number(img.style.marginTop.substring(0, img.style.marginTop.length - 2))
		let margin_top_new = margin_top_old + v_new*60

		if (margin_top_new > 0)
			margin_top_new = 0

		if (-margin_top_new > img.getBoundingClientRect().height - wrap.getBoundingClientRect().height)
			margin_top_new = -(img.getBoundingClientRect().height - wrap.getBoundingClientRect().height)

		img.style.marginTop = margin_top_new + 'px'

		if (v_abs > 0.1) {
			setTimeout(function(){
				requestAnimationFrame(() => {
					BLOCK.scrolling_vertical.touch_auto(img, v_new)
				})
			}, 0)
		}
	},

	// Рачёт растояния между точками щипка
	touch_pinch_distance(t_1, t_2){	
		return (Math.sqrt(Math.pow((t_1.clientX - t_2.clientX), 2) + Math.pow((t_1.clientY - t_2.clientY), 2)));
	},

	// Установка масштаба увеличения
	set_zoom(img, zoom){
		if (zoom > 5)
			zoom = 5
		if (zoom < 1)
			zoom = 1

		let wrap = img.parentNode

		let margin_left = Number(img.style.marginLeft.substring(0, img.style.marginLeft.length - 2))
		// Проверка, что бы не было выхода блока при уменьшении
		if (img.getBoundingClientRect().width < wrap.getBoundingClientRect().width - margin_left) {		
			img.style.marginLeft = wrap.getBoundingClientRect().width - img.getBoundingClientRect().width + 'px'
		}

		img.dataset.zoom = zoom
		img.style.maxWidth = zoom*100 + '%'
	},

	// Автоматическое проигрывание анимации
	play(img, step=1){
		if (!img.dataset.mode)
			return

		let timer = setTimeout(function(){
			let wrap = img.parentNode
			let margin_top = Number(img.style.marginTop.substring(0, img.style.marginTop.length - 2))
			let margin_top_new = Number(img.style.marginTop.substring(0, img.style.marginTop.length - 2)) - step;  // Смещаем с отрицательной величиной ('-1' - шаг в 1 пиксель)

			// Доходим до конца
			if (- margin_top > img.offsetHeight - wrap.offsetHeight)
				step = -1

			// Поднимаемся до начала
			if (- margin_top < 0)
				step = 1

			img.style.marginTop = margin_top_new + 'px';

			requestAnimationFrame(() => {
				BLOCK.scrolling_vertical.play(img, step)
			})
		}, 1)
	},

	// Движение изображения
	output(wrap, x, y){
		let img = wrap.childNodes[0]
		let img_height = img.getBoundingClientRect().height
		let wrap_height = wrap.getBoundingClientRect().height
		let wrap_width = wrap.getBoundingClientRect().width

		if (x < 0)
			x = 0
		if (x > wrap_width)
			x = wrap_width
		if (y < 0)
			y = 0
		if (y > wrap_height)
			y = wrap_height	

		// На 50 пикселей не подходим сверху и снизу
		let k = (img_height - wrap_height) / (wrap_height - 100)
		let mt = Math.round(parseFloat(k*(y - 50)))

		if (mt < 0)
			mt = 0;

		if (mt > (img_height - wrap_height))
			mt = img_height - wrap_height

		img.style.marginTop = '-' + mt + 'px'
	},
}