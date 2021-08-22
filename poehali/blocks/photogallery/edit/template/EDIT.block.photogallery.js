EDIT.block.photogallery = {
	container_style_old: '',
	wrap_style_old: '',

	add(id){
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/photogallery/photo_add', form, function(data){
			DAN.modal.add(data.content, 550)
			EDIT.status(true)

			DAN.$('e_block_modal_photogallery_file').onchange = EDIT.block.photogallery.file
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.photogallery.photo_update(id)
			}
		})
	},


	del(id){
		let content =
			'<div class="e_modal_title">Удалить блок</div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div><input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить"></div>' + 
				'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
			'</div>'


		DAN.modal.add(content, 350, 150)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = ()=>{
			let req = new XMLHttpRequest()				
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)

			EDIT.ajax('/edit/block/photogallery/delete', form, function(data){
				if (data.answer == 'success') {
					EDIT.obj.parentNode.removeChild(EDIT.obj);
					DAN.modal.del()
					EDIT.status(true)			
				} else {
					EDIT.errLog('Ошибка')
					alert('Ошибка сохранения данных')						
				}
			})
		}
	},


	file(){
		file = this.files[0]

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
				let image_w = parseInt(img.naturalWidth)
				let image_h = parseInt(img.naturalHeight)

				if (image_w < 500 || image_h < 400){
					alert('Размер изображения слишком маленький')
				}
			}
		};

		reader.readAsDataURL(file);
	},


	photo_delete(id) {
		let photo_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('photo_num', photo_num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/photogallery/photo_delete', form, function(data){
			EDIT.obj.parentNode.removeChild(EDIT.obj);
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	photo_edit(id){
		let photo_num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('photo_num', photo_num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/photogallery/photo_edit', form, function(_data){
			DAN.modal.add(_data.content, 550)
			EDIT.status(true)

			DAN.$('e_block_modal_photogallery_file').onchange = EDIT.block.photogallery.file
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.photogallery.photo_update(id, photo_num)
			}
		})
	},


	photo_update(id, photo_num = false){
		let file = DAN.$('e_block_modal_photogallery_file').files[0]
		let text_1 = DAN.$('e_block_modal_photogallery_text_1').value
		let text_2 = DAN.$('e_block_modal_photogallery_text_2').value
		//let link = DAN.$('e_block_modal_photogallery_link').value

		DAN.modal.spinner()

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if (photo_num) 
			form.append('photo_num', photo_num)
		form.append('file', file)
		form.append('text_1', text_1)
		form.append('text_2', text_2)
		//form.append('link', link)

		EDIT.ajax('/edit/block/photogallery/photo_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			localStorage.setItem('anchor', 'block_' + id)
			document.location.href = '/' + EDIT.url
		})
	},


	// Выводит настройки в модальном окне
	settings(id, style=false) {
		EDIT.block.photogallery.container_style_old = EDIT.obj.getAttribute('style')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if (style)
			form.append('style', style)

		EDIT.ajax('/edit/block/photogallery/settings_edit', form, (data)=>{
			DAN.modal.add(data.content, 550)
			let style = data.style

			let container = DAN.$('block_photogallery_container_' + id)
			let items_wrap = container.getElementsByClassName('block_photogallery_photo_' + style + '_wrap')
			let items_image = container.getElementsByClassName('block_photogallery_photo_' + style + '_image')
			let items_title = container.getElementsByClassName('block_photogallery_photo_' + style + '_title')
			let items_text = container.getElementsByClassName('block_photogallery_photo_' + style + '_text')

			// Ширина
			let width = DAN.$('e_block_modal_max_width')
			width.onchange = ()=>{
				w = width.value == 100 ? '100%' : width.value + 'px'
				EDIT.obj.childNodes[1].style.maxWidth = w
			}			

			// margin - отступ от контейнера
			let margin = DAN.$('e_block_modal_margin')
			margin.onchange = ()=>{
				EDIT.obj.childNodes[1].style.margin = margin.value + 'px auto'
			}

			// padding - отступы между блоками
			let padding = DAN.$('e_block_modal_padding')
			padding.onchange = ()=>{
				if (items_wrap.length > 0) {
					for (let i = 0; i < items_wrap.length; i++) {
						items_wrap[i].style.padding = padding.value + 'px'
					}
				}
			}

			// Цвет фона
			let bg_type = DAN.$('e_block_modal_bg_type')
			bg_type.oninput = ()=> {
				let bg_mannuale_container = DAN.$('e_block_modal_container_bg_color_mannuale')
				let bg_image_input = DAN.$('e_block_modal_container_bg_color_input')
				switch (bg_type.value) {
					case '1': out = '<table class="e_table_admin"><tr>' + 
						'<td class="e_td_right">Цвет 1 из настроек сайта</td>' + 
						'<td><div id="e_block_modal_bg_color_var" style="background-color: var(--color-1)">&nbsp;</div></td>' + 
						'</tr></table>'
						bg_mannuale_container.style.display = 'none'
						EDIT.obj.style.setProperty('background-color', 'var(--color-1)')
						break

					case '2': out = '<table class="e_table_admin"><tr>' + 
						'<td class="e_td_right">Цвет 2 из настроек сайта</td>' + 
						'<td><div id="e_block_modal_bg_color_var" style="background-color: var(--color-2)">&nbsp;</div></td>' + 
						'</tr></table>'
						bg_mannuale_container.style.display = 'none'
						EDIT.obj.style.setProperty('background-color', 'var(--color-2)')				
						break

					case '3': out = '<table class="e_table_admin"><tr>' + 
						'<td class="e_td_right">Цвет 3 из настроек сайта</td>' + 
						'<td><div id="e_block_modal_bg_color_var" style="background-color: var(--color-3)">&nbsp;</div></td>' + 
						'</tr></table>'
						bg_mannuale_container.style.display = 'none'
						EDIT.obj.style.setProperty('background-color', 'var(--color-3)')
						break

					case 'c': out = ''
						bg_mannuale_container.style.display = 'table'
						EDIT.obj.style.backgroundColor = bg_image_input.value
						break

					default: out = ''
						bg_mannuale_container.style.display = 'none'
						EDIT.obj.style.backgroundColor = ''
						break
				}

				// Цвет фона - строка в модальном окне
				DAN.$('e_block_modal_container_bg_color').innerHTML = out
			}

			// Изображение фона
			let bg_image_input = DAN.$('e_block_modal_container_bg_color_input')
			bg_image_input.oninput = ()=>{
				EDIT.obj.style.backgroundColor = bg_image_input.value
			}

			// Вуаль - прозрачность
			let fog_opacity = DAN.$('e_block_modal_fog_opacity')
			if (fog_opacity) {
				fog_opacity.onmousemove = ()=>{
					DAN.$('e_block_modal_fog_opacity_out').innerHTML = fog_opacity.value;
				}
			}

			// Размер заголовка
			let title_size = DAN.$('e_block_modal_title_size')
			title_size.onchange = ()=>{
				if (items_title.length > 0) {
					for (let i = 0; i < items_title.length; i++) {
						items_title[i].style.fontSize = title_size.value + 'px'
					}
				}
			}

			// Размер шрифта
			let font_color = DAN.$('e_block_modal_font_color')
			font_color.oninput = ()=>{
				EDIT.obj.style.color = font_color.value
			}

			// Размер текста
			let font_size = DAN.$('e_block_modal_font_size')
			font_size.onchange = ()=>{
				if (items_text.length > 0) {
					for (let i = 0; i < items_text.length; i++) {
						items_text[i].style.fontSize = font_size.value + 'px'
					}
				}
			}

			let input_style = DAN.$('e_block_modal_photogallery_style')
			style.onchange = ()=>{
				DAN.modal.spinner()
				EDIT.block.photogallery.settings(id, input_style.value)
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.photogallery.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.photogallery.style_reset
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()
		let style = DAN.$('e_block_modal_photogallery_style').value
		let format = DAN.$('e_block_modal_photogallery_format').value
		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let margin = DAN.$('e_block_modal_margin') ? DAN.$('e_block_modal_margin').value : false
		let padding = DAN.$('e_block_modal_padding') ? DAN.$('e_block_modal_padding').value : false
		let title_size = DAN.$('e_block_modal_title_size') ? DAN.$('e_block_modal_title_size').value : false
		let font_size = DAN.$('e_block_modal_font_size') ? DAN.$('e_block_modal_font_size').value : false
		let color = DAN.$('e_block_modal_font_color').value
		let fog_color = DAN.$('e_block_modal_fog_color') ? DAN.$('e_block_modal_fog_color').value : false
		let fog_opacity = DAN.$('e_block_modal_fog_opacity') ? DAN.$('e_block_modal_fog_opacity').value : false

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		}

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('style', style)
		form.append('format', format)
		if(bg_type) form.append('bg_type', bg_type)
		if(bg_color) form.append('bg_color', bg_color)
		if(max_width) form.append('max_width', max_width)
		if(margin) form.append('margin', margin)
		if(padding) form.append('padding', padding)
		if(title_size) form.append('title_size', title_size)
		if(font_size) form.append('font_size', font_size)
		form.append('color', color)
		if(fog_color) form.append('fog_color', fog_color)
		if(fog_opacity) form.append('fog_opacity', fog_opacity)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/photogallery/settings_update', form, function(data) {
			DAN.modal.del()
			EDIT.status(true)
			localStorage.setItem('anchor', 'block_' + id)
			document.location.href = '/' + EDIT.url
		})
	},

	// Возвращает стили объекта
	style_reset: function(){
		EDIT.obj.setAttribute('style', EDIT.block.photogallery.container_style_old)
		EDIT.obj = '';
		DAN.modal.del()
	},


	update_ordering: function(_r){
		let target = DAN.$(_r.target_id)
		let arr = target.getElementsByClassName('e_block_item')

		let photo_arr = []

		for(i = 0; i < arr.length; i++){
			photo_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', _r.object_id)
		form.append('url', EDIT.url)
		form.append('photos', photo_arr)

		EDIT.ajax('/edit/block/photogallery/photo_ordering', form, function(_data){
			EDIT.status(true)
			// document.location.href = '/'
		})
	}
}