EDIT.block.image = {
	container_style_old: '',
	wrap_style_old: '',

	copy(id){
		let content =
			'<h2>Копировать блок</h2>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' +
					'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Копировать">' +
				'</div>' +
				'<div>' +
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
				'</div>' +
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)

			EDIT.ajax('/edit/block/image/copy', form, function(_data){
				EDIT.obj.insertAdjacentHTML('afterEnd', _data.content)
				DAN.jumpTo('block_' + _data.id, 500)
				DAN.modal.del()
				EDIT.status(true)
				EDIT.block.initialize()
			})
		}
	},


	del(id){
		let content =
			'<h2>Удалить блок</h2>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' +
					'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Удалить">' +
				'</div>' +
				'<div>' +
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
				'</div>' +
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)


			EDIT.ajax('/edit/block/image/delete', form, function(_data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	edit_text(id){
		let txt_1 = EDIT.obj.getElementsByClassName('block_image_1_text')
		let txt_2 = EDIT.obj.getElementsByClassName('block_image_2_text')
		EDIT.obj = txt_1.length ? txt_1[0].childNodes[0] : txt_2[0].childNodes[0]

		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", function(){

			let content_new = CKEDITOR.instances.e_editor.getData()
			EDIT.obj.parentNode.id = ''
			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let req = new XMLHttpRequest()
				let form = new FormData()
				form.append('id', id)
				form.append('p', EDIT.p)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/image/text_update', form, (data)=>{
					EDIT.status(true)
				})
			}
		});
	},


	edit_image(id) {
		let image_wrap = EDIT.obj.childNodes[1].childNodes[0];
		let parring = image_wrap.style.padding != '' ? parseInt(image_wrap.style.padding) : 0
		let w = image_wrap.clientWidth - parring * 2

		let content =
		'<div class="dan_2_modal_content_center_mobile">' +
			'<h2>Заменить изображение</h2>' +
			'<table class="e_table_admin">' +
				'<tr><td class="e_td_right">Новое изображение</td><td><input onchange="EDIT.block.image.file(this.files);" type="file" name="file" data-width="' + w + '"></td></tr>' +
				'<tr><td class="e_td_right"><span style="font-size:12px">Оптимальная ширина изображения для текущих настроек блока:</span></td><td class="e_text_16_b">' + w + ' px</td></tr>' +
			'</table>' +
			'<table class="e_table_admin">' +
				'<tr><td class="e_td_right">Альтернативный текст <b>alt</b></td><td><input id="e_modal_alt" class="dan_input"></td></tr>' +
			'</table>' +
			'<div id="e_block_image_modal_message" class="e_text_16_b" style="text-align:center;color:#4CAF50;"></div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' +
					'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">' +
				'</div>' +
				'<div>' +
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
				'</div>' +
			'</div>' +
		'</div>'

		DAN.modal.add(content)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del

		let alt = DAN.$('e_modal_alt');
		let image = EDIT.obj.getElementsByClassName('block_images_image')[0]
		alt.value = image.getAttribute('alt')

		// Отправить данные методом POST
		DAN.$('e_modal_submit').onclick = ()=>{
			if (!IMAGE_RESIZE.obj.file) {
				alert('Новый файл не выбран!')
			}

			DAN.modal.spinner()

			var form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)
			form.append('w', w)
			form.append('scale', IMAGE_RESIZE.obj.scale)
			form.append('x1', IMAGE_RESIZE.obj.x1)
			form.append('x2', IMAGE_RESIZE.obj.x2)
			form.append('y1', IMAGE_RESIZE.obj.y1)
			form.append('y2', IMAGE_RESIZE.obj.y2)
			form.append('file', IMAGE_RESIZE.obj.file)
			form.append('alt', alt.value)

			EDIT.ajax('/edit/block/image/image_update', form, (data)=>{
				EDIT.status(true)
				localStorage.setItem('anchor', 'block_' + data.id)
				document.location.href = '/' + EDIT.url
			})
		}
	},


	// отправляем данные на IMAGE_RESIZE
	file(image_file){
		let image_wrap = EDIT.obj.childNodes[1].childNodes[0]
		let w = image_wrap.clientWidth - parseInt(image_wrap.style.padding) * 2

		IMAGE_RESIZE.options.w = w
		IMAGE_RESIZE.options.h = parseInt(w * 3/4)
		IMAGE_RESIZE.options.scale = 'auto'
		IMAGE_RESIZE.options.zIndex = 10100

		if(image_file[0].size > 3000000){
			alert('Размер исходного изображения слишком большой')
			return
		}

		if(image_file[0].type != 'image/jpeg' && image_file[0].type !=  'image/gif' && image_file[0].type != 'image/png' && image_file[0].type != 'image/webp'){
			alert('Неверный формат изображения')
			return
		}

		IMAGE_RESIZE.win(image_file, function(){
			document.getElementById('e_block_image_modal_message').innerHTML = 'Новый файл прикреплён'
		})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.image.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.image.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/image/settings', form, function(_data){
			DAN.modal.add(_data.content, 600)
			EDIT.block.settings.init() // Инициализация общих настроек
			// EDIT.block.image.title()

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = function(){
				EDIT.block.image.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.image.style_reset
		})
	},


	// Обновляет настройки на ajax
	settings_update: function(id){
		let form = new FormData()
		let bg_type = DAN.$('e_block_modal_bg_type').value
		let bg_color = DAN.$('e_block_modal_container_bg_color_input').value
		let bg_image = DAN.$('e_block_modal_bg_image_file').files[0]
		let bg_image_size = DAN.$('e_block_modal_bg_image_size_1').checked ? 'cover' : '';
		let wrap_bg_check = DAN.$('e_block_modal_wrap_bg_color_check').checked ? 1 : 0
		let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color').value
		let wrap_bg_opacity = DAN.$('e_block_modal_wrap_opacity').value
		let max_width = DAN.$('e_block_modal_max_width').value
		let margin = DAN.$('e_block_modal_margin').value
		let padding = DAN.$('e_block_modal_padding').value
		let font_select = DAN.$('e_block_modal_font_select').value
		let font_size = DAN.$('e_block_modal_font_size').value
		let line_height = DAN.$('e_block_modal_line_height').value
		let color = DAN.$('e_block_modal_font_color').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		}

		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('bg_type', bg_type)
		if(bg_type == 'i') form.append('bg_image', bg_image)
		form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('wrap_bg_check', wrap_bg_check)
		form.append('wrap_bg_color', wrap_bg_color)
		form.append('wrap_bg_opacity', wrap_bg_opacity)
		form.append('max_width', max_width)
		form.append('margin', margin)
		form.append('padding', padding)
		form.append('font_select', font_select)
		form.append('font_size', font_size)
		form.append('line_height', line_height)		
		form.append('color', color)

		EDIT.ajax('/edit/block/image/settings_update', form, function(data){
			if (data.answer == 'success') {
				DAN.modal.del()
				EDIT.status(true)
			} else {
				EDIT.errLog('Ошибка')
				alert('Ошибка сохранения данных')
			}
		})
	},


	// Возвращает стили объекта
	style_reset: function(){
		EDIT.obj.setAttribute('style', EDIT.block.image.container_style_old)
		EDIT.block.image.container_style_old = '';
		EDIT.obj.childNodes[1].setAttribute('style', EDIT.block.image.wrap_style_old)
		EDIT.block.image.wrap_style_old = '';
		EDIT.obj = '';
		DAN.modal.del()
	},

/*
	update_ordering: function(_r){
		// Получаем массив блоков
		let b_c = DAN.$('block_' + _r.target_id).childNodes[1]
		let items = b_c.childNodes

		let arr = []
		for(i = 0; i < items.length; i++){
			arr.push(items[i].getAttribute('data-id'))
		}

		let form = new FormData()
		form.append('id', _r.target_id)
		form.append('p', EDIT.p)
		form.append('items_id', arr)

		EDIT.ajax('/edit/block/image/image_ordering', form, function(_data){
			DAN.modal.del()
			EDIT.status(true)
			EDIT.block.initialize()
		})
	}
*/
}