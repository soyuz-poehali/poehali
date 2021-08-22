window.addEventListener('resize', function(){
	//var container = DAN.$('block_slider_container');
	//var h = container.offsetWidth * BLOCK.slider.ratio;
	//container.style.height = h + 'px';	
});


BLOCK.slider_1 = class {
	constructor(_id){
		// --- Настройки ---
		this.id = _id
		this.dots = 1 // Вывести точки
		this.effect = 'opacity' // Эффект анимации
		this.interval = 3000 // Интервал
		this.ratio = 0.3 // Высота / ширина слайдера

		this.num = 0 // Номер слайда
		this.slides = new Array()
		this.timerId = 0

		this.container = DAN.$('block_slider_container_' + _id)
		this.init = false // Инициализация при первом запуске
	}


	animation(_num){
		let slide = this.slides[_num]

		// Текст внизу
		let text = ''

		if(slide.text) text = '<div class="block_slide_1_text">' + slide.text + '</div>'
	
		// Точки вверху
		if(this.dots == 1){
			var dt = ''
			for(var i = 0; i < this.slides.length; i++){
				if(i == _num) dt += '<div class="block_slide_1_dot_active"></div>'
					else dt += '<div onclick="event.preventDefault();slider_' + this.id + '.goTo(' + i + ');" class="block_slide_1_dot"></div>'
			}

			var dots = '<div class="block_slide_1_dots_container">' + dt + '</div>'
		}
		else{
			var dots = ''
		}

		if(slide.link){ // Гиперссылка
			var slide_new = '<a href="' + slide.link + '" class="block_slide_1 block_slide_1_effect_' + this.effect + '">' + dots + text + '<img class="block_slide_1_img" src="' + slide.file + '"></a>'
		}
		else{
			var slide_new = '<div class="block_slide_1 block_slide_1_effect_' + this.effect + '">' + dots + text + '<img class="block_slide_1_img" src="' + slide.file + '"></div>'		
		}

		this.container.insertAdjacentHTML('afterBegin', slide_new)
		if(this.container.childNodes[2]) this.container.removeChild(this.container.childNodes[2])
	}


	goTo(_num){
		this.stop()
		this.num = _num
		this.play()
	}


	initialization(){
		this.init = true
		let h = this.container.offsetWidth * this.ratio // Получаем высоту слайдера в пикселях
		let vh = Math.round((h / document.body.clientWidth) * 10000) / 100 // Получаем высоту слайдера в vh (% от высоты экрана)
		this.container.style.height = vh + 'vw' // Берём значение высоты от ширины
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