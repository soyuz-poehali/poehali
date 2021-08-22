EDIT.block.slider = {
	container_style_old: '',
	wrap_style_old: '',

	del(id){
		let content =
			'<h2>Удалить блок</h2>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' +
					'<input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить">' +
				'</div>' +
				'<div>' +
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
				'</div>' +
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let req = new XMLHttpRequest()
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)

			EDIT.ajax('/edit/block/slider/delete', form, function(_data){
				if (_data.answer == 'success'){
					EDIT.obj.parentNode.removeChild(EDIT.obj);
					DAN.modal.del()
					EDIT.status(true)
				}
			})
		}
	},


	// Проверка размеров изображения
	file(file){
		if (file.size > 3000000) {
			alert('Размер исходного изображения слишком большой')
			return
		}

		if (!file.type.match(/image.*/)) {
			alert('Неверный формат изображения')
			return
		}

		let reader = new FileReader();
		reader.onload = function(event) {

			var dataUri = event.target.result
			let img = new Image()
			img.src = dataUri;

			img.onload = function(){
				let slide_w = parseInt(DAN.$('e_block_modal_slider_w').innerHTML)
				let slide_h = parseInt(DAN.$('e_block_modal_slider_h').innerHTML)
				let slide_r = Math.round((slide_h / slide_w) * 100) / 100
				let image_w = parseInt(img.naturalWidth)
				let image_h = parseInt(img.naturalHeight)
				let image_r = Math.round((image_h / image_w) * 100) / 100
				let message = ''

				// Проверка на маленький размер по ширине
				if (image_w < slide_w) {
					if (image_w < slide_w/2) {
						message += 'Изображение очень низкого разрешения \nРазмер изображения: ' + image_w + ' х ' + image_h + ' Нужный размер: ' + slide_w + ' х ' + slide_h + '\nВсё будет очень плохо!\nНе будем грузить файл!\n'
						alert(message)
						DAN.modal.del()
						return
					} else {
						message += 'Изображение низкого разрешения \nРазмер изображения: ' + image_w + ' х ' + image_h + ' Нужный размер: ' + slide_w + ' х ' + slide_h + '\nСлайд будет нечёткий\n'
					}
				}

				// Проверка на большой размер по ширине
				if (image_w > slide_w * 1.3) {
					if (image_w > slide_w * 2) {
						message += 'Изображение очень большое \nРазмер изображения: ' + image_w + ' х ' + image_h + ' Нужный размер: ' + slide_w + ' х ' + slide_h + '\nСайт будет долго загружаться\nНе будем грузить файл!\n'
						alert(message)
						DAN.modal.del()
						return
					} else {
						message += 'Размер изображения больше нужного \nРазмер изображения: ' + image_w + ' х ' + image_h + ' Нужный размер: ' + slide_w + ' х ' + slide_h + '\nСайт будет дольше загружаться\n'
					}
				}

				// Проверка соотношений сторон
				if (image_r > slide_r * 1.1 || image_r < slide_r * 0.9) {
					message += 'У загружаемого изображения неверные пропорции\nВысота / ширина вашего изображения: ' + image_r * 100 + '% Должно быть: ' + slide_r * 100 + '%\n'
				}

				if (message != '') 
					alert(message)
			}
		};

		reader.readAsDataURL(file);
	},


	interval: function(){
		DAN.$('e_block_modal_slider_interval_out').innerHTML = DAN.$('e_block_modal_slider_interval').value
	},


	ratio: function(){
		DAN.$('e_block_modal_slider_ratio_out').innerHTML = DAN.$('e_block_modal_slider_ratio').value
	},


	// Выводит настройки в модальном окне
	settings(id, style=false){
console.log('style', style)
		EDIT.block.slider.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.slider.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')
		// EDIT.block.slider.h2_old = EDIT.obj.getElementsByTagName('h2')[0].getAttribute('style')

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if (style)
			form.append('style', style)

		EDIT.ajax('/edit/block/slider/settings', form, (data)=>{
			DAN.modal.add(data.content, 550)
			let style = data.style

			// --- ИНИЦИАЛИЗАЦИЯ НАСТРОЕК ---
			// Тип 1
			if (!style || style == 1)
				EDIT.block.settings.init()

			// Тип 2
			if (style == 2) {
				if (DAN.$('e_block_modal_container')) 
					EDIT.block.settings.container()

				DAN.accordion('e_block_modal_accordion_head', 'e_block_modal_accordion_body')
				let fog_opacity = DAN.$('e_block_modal_slider_fog_opacity')

				fog_opacity.onmousemove = ()=>{
					DAN.$('e_block_modal_slider_fog_opacity_out').innerHTML = fog_opacity.value
				}
			}


			let style_but = DAN.$('e_block_modal_slider_style')
			style_but.onchange = ()=>{
				alert('Тип слайдера изменится после сохранения')
				DAN.modal.spinner()
				EDIT.block.slider.settings(id, style_but.value)
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.slider.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Обновляет настройки на ajax
	settings_update: function(id){
		let req = new XMLHttpRequest()
		let form = new FormData()

		let style = DAN.$('e_block_modal_slider_style').value
		let dots = DAN.$('e_block_modal_slider_dots').checked ? 1 : 0
		let effect = DAN.$('e_block_modal_slider_effect') ? DAN.$('e_block_modal_slider_effect').value : false
		let ratio = DAN.$('e_block_modal_slider_ratio').value
		let interval = DAN.$('e_block_modal_slider_interval').value
		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file') ? DAN.$('e_block_modal_bg_image_file').files[0] : false
		let bg_image_size = DAN.$('e_block_modal_bg_image_size_1') && DAN.$('e_block_modal_bg_image_size_1').checked ? 'cover' : '';
		let wrap_bg_check = DAN.$('e_block_modal_wrap_bg_color_check') && DAN.$('e_block_modal_wrap_bg_color_check').checked ? 1 : 0
		let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color') ? DAN.$('e_block_modal_wrap_bg_color').value : false
		let wrap_bg_opacity = DAN.$('e_block_modal_wrap_opacity') ? DAN.$('e_block_modal_wrap_opacity').value : false
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let margin = DAN.$('e_block_modal_margin') ? DAN.$('e_block_modal_margin').value : false
		let padding = DAN.$('e_block_modal_padding') ? DAN.$('e_block_modal_padding').value : false
		let font_select = DAN.$('e_block_modal_font_select') ? DAN.$('e_block_modal_font_select').value : false
		let font_size = DAN.$('e_block_modal_font_size') ? DAN.$('e_block_modal_font_size').value : false
		let line_height = DAN.$('e_block_modal_line_height') ? DAN.$('e_block_modal_line_height').value :false
		let color = DAN.$('e_block_modal_font_color').value
		let fog_color = DAN.$('e_block_modal_slider_fog_color') ? DAN.$('e_block_modal_slider_fog_color').value : false
		let fog_opacity = DAN.$('e_block_modal_slider_fog_opacity') ? DAN.$('e_block_modal_slider_fog_opacity').value : false
		let text_1_size = DAN.$('e_block_modal_slider_text_1_size') ? DAN.$('e_block_modal_slider_text_1_size').value : false
		let text_2_size = DAN.$('e_block_modal_slider_text_2_size') ? DAN.$('e_block_modal_slider_text_2_size').value : false

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if(bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))){
			alert ('Не выбрано изображение')
			return
		}


		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('style', style)
		form.append('dots', dots)
		if(effect) form.append('effect', effect)
		form.append('ratio', ratio)
		form.append('interval', interval)
		if(bg_type) form.append('bg_type', bg_type)
		if(bg_type == 'i') form.append('bg_image', bg_image)
		if(bg_color) form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		if(wrap_bg_check) form.append('wrap_bg_check', wrap_bg_check)
		if(wrap_bg_color) form.append('wrap_bg_color', wrap_bg_color)
		if(wrap_bg_opacity) form.append('wrap_bg_opacity', wrap_bg_opacity)
		if(max_width) form.append('max_width', max_width)
		if(margin) form.append('margin', margin)
		if(padding) form.append('padding', padding)
		if(font_select) form.append('font_select', font_select)
		if(font_size) form.append('font_size', font_size)
		if(line_height) form.append('line_height', line_height)
		form.append('color', color)
		if(fog_color) form.append('fog_color', fog_color)
		if(fog_opacity) form.append('fog_opacity', fog_opacity)
		if(text_1_size) form.append('text_1_size', text_1_size)
		if(text_2_size) form.append('text_2_size', text_2_size)

		EDIT.ajax('/edit/block/slider/settings_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},


	slides(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/slider/slides', form, function(data){
			DAN.modal.add(data.content, 550)

			// Сохраняем порядок только в том случае, если он изменён, для проверки заводим строку 'initial_str'
			let arr_initial = document.getElementsByClassName('e_block_modal_item')
			let slider_arr_initial = []

			for(i = 0; i < arr_initial.length; i++){
				slider_arr_initial[i] = arr_initial[i].getAttribute('data-item-num')
			}

			let initial_str = slider_arr_initial.join(' '); // Переводим в строку с разделителем ('2 22' != '22 2')

			EDIT.block.initialize()
			DRAG_DROP()

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = function(){

				// Проверяем новый порядок и исходный, если совпадает - прерываем отправку
				let arr = document.getElementsByClassName('e_block_modal_item')
				let slides_arr = []

				for(i = 0; i < arr.length; i++){
					slides_arr[i] = arr[i].getAttribute('data-item-num')
				}

				let result_str = slides_arr.join(' ')

				if(result_str == initial_str){
					DAN.modal.del()
					return;
				}
				EDIT.block.slider.slides_ordering(id, slides_arr)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	slide_add(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/slider/slide_add', form, function(data){
			DAN.modal.add(data.content, 550)
			let f = DAN.$('e_block_modal_slider_file')

			f.onchange = function(){
				let file = f.files[0]
				EDIT.block.slider.file(file)
			}

			DAN.$('e_modal_submit').onclick = function(){
				EDIT.block.slider.slide_update(id)
			}
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	slide_edit(id){
		let slide_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('slide_num', slide_num)

		EDIT.ajax('/edit/block/slider/slide_edit', form, function(data){
			DAN.modal.add(data.content, 550)
			let f = DAN.$('e_block_modal_slider_file')

			f.onchange = function(){
				let file = f.files[0]
				EDIT.block.slider.file(file)
			}

			DAN.$('e_modal_submit').onclick = function(){
				EDIT.block.slider.slide_update(id, slide_num)
			}
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	slide_delete(id){
		let slide_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('slide_num', slide_num)

		EDIT.ajax('/edit/block/slider/slide_delete', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},


	slide_update(id, slide_num = false){
		let file = DAN.$('e_block_modal_slider_file').files[0]
		let text_1 = DAN.$('e_block_modal_slider_text_1').value
		let text_2 = DAN.$('e_block_modal_slider_text_2').value
		let link = DAN.$('e_block_modal_slider_link').value

		DAN.modal.spinner()

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if(slide_num) form.append('slide_num', slide_num)
		form.append('file', file)
		form.append('text_1', text_1)
		form.append('text_2', text_2)
		form.append('link', link)

		EDIT.ajax('/edit/block/slider/slide_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},


	slides_ordering(id, slides_arr){
console.log('--- ORDERING ---')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('slides', slides_arr)

		EDIT.ajax('/edit/block/slider/slides_ordering', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	}
}