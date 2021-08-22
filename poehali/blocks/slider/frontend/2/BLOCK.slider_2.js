BLOCK.slider_2 = class {
	constructor(_id){
		// --- Настройки ---
		this.id = _id
		this.dots = 1 // Вывести точки
		this.hover_pause = 0 // Остановка при наведении
		this.navigation = 0 // Отображение навигации
		this.effect = 'opacity' // Эффект анимации
		this.interval = 3000 // Интервал
		this.ratio = 0.3 // Высота / ширина слайдера
		this.color = '#ffffff'
		this.fog_color = '#000000'
		this.fog_opacity = 0.5
		this.text_1_size = 4
		this.text_2_size = 2
		this.link_size = 2

		this.num = 0 // Номер слайда
		this.slides = new Array()
		this.timerId = 0

		this.container = DAN.$('block_slider_container_' + _id)
		this.init = false // Инициализация при первом запуске
	}


	animation(_num){
		let slide = this.slides[_num]

		let text = ''
		let text_1 = ''
		let text_2 = ''
		let link = ''

		if(slide.text_1 !='' || slide.text_2 != '')
		{
			if(slide.text_1 != '') text_1 = '<div class="block_slide_2_text_1" style="font-size:' + this.text_1_size + 'vw;"><div>' + slide.text_1 + '</div></div>'
			if(slide.text_2 != '') text_2 = '<div class="block_slide_2_text_2" style="font-size:' + this.text_2_size + 'vw;"><div>' + slide.text_2 + '</div></div>'
			if(slide.link != '') link = '<div class="block_slide_2_link" style="font-size:' + this.link_size + 'vw;"><a href="' + slide.link + '" style="color:' + this.color + '">Подробнее</a></div>'
			text = '<div class="block_slide_2_text_container">' + text_1 + text_2 + link + '</div>'
		}

		let fog_bg = DAN.hexToRGB(this.fog_color, this.fog_opacity)
		let fog = '<div class="block_slide_2_fog" style="background-color:' + fog_bg + ';"></div>'
		
		// Точки вверху
		if(this.dots == 1){
			var dt = ''
			for(var i = 0; i < this.slides.length; i++){
				if(i == _num) dt += '<div class="block_slide_2_dot_active"></div>'
					else dt += '<div onclick=slider_' + this.id + '.goTo(' + i + '); class="block_slide_2_dot"></div>'
			}

			DAN.$('block_slide_2_dots_container_' + this.id).innerHTML = dt
		}

		// Остановка при наведении мыши сверху
		if(this.hover_pause == 1){
			var f = 'slider_' + this.id
			this.container.onmouseenter = function(){
				window[f].stop()
			}
			this.container.onmouseleave = function(){
				window[f].play()
			}
		}

		var slide_new = '<div class="block_slide_2 block_slide_2_effect_opacity">' + text + fog + '<img class="block_slide_2_img" src="' + slide.f + '"></div>'
		this.container.insertAdjacentHTML('afterBegin', slide_new)

		let slide_arr = this.container.getElementsByClassName('block_slide_2')
		if(slide_arr[2]) this.container.removeChild(slide_arr[2])
	}


	goTo(_num){
		this.stop()
		this.num = _num
		this.play()
	}


	initialization(){
		this.init = true
		this.text_1_size
		this.text_2_size

		if(this.text_1_size < this.text_2_size) this.link_size = this.text_1_size
		else this.link_size = this.text_2_size

		let h = this.container.offsetWidth * this.ratio // Получаем высоту слайдера в пикселях
		let vh = Math.round((h / document.body.clientWidth) * 10000) / 100 // Получаем высоту слайдера в vh (% от высоты экрана)
		this.container.style.height = vh + 'vw' // Берём значение высоты от ширины

		// Точки вверху
		if(this.dots == 1){
			var dots = '<div id="block_slide_2_dots_container_' + this.id + '" class="block_slide_2_dots_container"></div>'
			this.container.insertAdjacentHTML('afterBegin', dots)
		}

		// Элементы навигации
		this.navigation = 1
		if(this.navigation == 1){
			var prev = document.createElement('div')
			prev.classList.add('block_slide_2_nav_prev')
			prev.innerHTML = '<svg class="dan_show_nav"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#prev"></use></svg>'

			var next = document.createElement('div')
			next.classList.add('block_slide_2_nav_next')
			next.innerHTML = '<svg class="dan_show_nav"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#next"></use></svg>'

			this.container.insertAdjacentElement('afterBegin', prev)
			this.container.insertAdjacentElement('afterBegin', next)

			let f = 'slider_' + this.id
			prev.onclick = function(){
				let n = window[f].num
				n = n - 2

				if(n < 0) n = window[f].slides.length - 1

				window[f].goTo(n)
			}

			next.onclick = function(){
				let n = window[f].num
				window[f].goTo(n)
			}
		}
	}


	play(){
		if(!this.init) this.initialization()
		if(this.num > this.slides.length - 1) this.num = 0
		this.animation(this.num)
		this.num++

		// без вызова анонимной функции - будет потерян контекст класса BLOCK.slider, поэтому контекст передаем через .bind(this) внутри вызова анонимной функции
		this.timerId = setTimeout(function(){
			requestAnimationFrame(function(){this.play()}.bind(this))
		}.bind(this), this.interval)
	}


	stop(){
		clearTimeout(this.timerId);
	}
}