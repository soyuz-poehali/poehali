EDIT.block.case = {
	container_style_old: '',
	text_style_old: '',


	button_edit(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/case/button_edit', form, function(data){
			EDIT.status()
			DAN.modal.add(data.content)

			// Установка цвета текста кнопки из предустановленных цветов
			let button_color_s = DAN.$('e_block_modal_bg_color_wrap').getElementsByClassName('e_block_modal_color_round')

			for (var i = 0; i < button_color_s.length; i++) {
				button_color_s[i].onclick = (e) => {
					DAN.$('e_block_modal_bg_color').value = e.target.dataset.color
				}
			}

			// Установка цвета текста кнопки из установок
			let button_bg_color_s = DAN.$('e_block_modal_text_color_wrap').getElementsByClassName('e_block_modal_color_round')

			for(var i = 0; i < button_bg_color_s.length; i++){
				button_bg_color_s[i].onclick = (e) => {
					DAN.$('e_block_modal_text_color').value = e.target.dataset.color
				}
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.case.button_update(id)
			}
		})
	},


	// Обновить данные кнопки
	button_update(id){
		let on = DAN.$('e_block_modal_on').checked ? 1 : 0;
		let button_text = DAN.$('e_block_modal_text').value;
		let bg_color = DAN.$('e_block_modal_bg_color').value;
		let text_color = DAN.$('e_block_modal_text_color').value;
		let style = DAN.$('e_block_modal_style').value;
		let radius = DAN.$('e_block_modal_radius').value;

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('on', on)
		form.append('text', button_text)
		form.append('bg_color', bg_color)
		form.append('text_color', text_color)
		form.append('style', style)
		form.append('radius', radius)

		EDIT.ajax('/edit/block/case/button_update', form, function(data){})
	},


	del(id){
		let content =
			'<div class="e_modal_title">Удалить блок</div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div><input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить"></div>' + 
				'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = () => {
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)		

			EDIT.ajax('/edit/block/case/delete', form, function(data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status()
			})
		}
	},


	// Проверка типа и размера файла
	file(e){
		let file = e.target.files
		console.log(file)
		if (file[0].size > 3000000) {
			alert('Размер исходного изображения слишком большой')
			return
		}

		if (file[0].type != 'image/jpeg' && file[0].type !=  'image/gif' && file[0].type != 'image/png' && file[0].type != 'image/webp') {
			alert('Неверный формат изображения')
			return
		}
	},


	// Добавить изображение
	image_add(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let image_wrap = EDIT.obj.childNodes[1].childNodes[0];
		let padding = image_wrap.style.padding != '' ? parseInt(image_wrap.style.padding) : 0
		let w = image_wrap.clientWidth - padding*2
		let title = 'Добавить изображение'

		if(num)
			title = 'Заменить изображение'

		let content =
		'<div class="dan_2_modal_content_center_mobile">' +
		'<h2>' + title + '</h2>' +
		'<table class="e_table_admin">' +
			'<tr><td class="e_td_right">Оптимальная ширина изображения для текущих настроек блока:</td><td class="e_text_16_b">' + w + ' px</td></tr>' +
			'<tr><td class="e_td_right">Новое изображение</td><td><input id="e_block_case_file" type="file" name="file"></td></tr>' +
		'</table>' +
		'<div id="e_block_image_modal_message" class="e_text_16_b" style="text-align:center;color:#4CAF50;"></div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>' + 
				'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
			'</div>'
		'</div>'

		DAN.modal.add(content)
		let e_block_case_file = DAN.$('e_block_case_file')
		e_block_case_file.onchange = EDIT.block.case.file
		DAN.$('e_modal_cancel').onclick = DAN.modal.del

		// Отправить данные методом POST
		DAN.$('e_modal_submit').onclick = () => {
			let file = e_block_case_file.files[0]
			var form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)
			form.append('file', file)
			if(num)
				form.append('num', num)

			DAN.modal.spinner()

			EDIT.ajax('/edit/block/case/image_update', form, (data) => {})
		}
	},


	// Удалить изображение
	image_delete(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/case/image_delete', form, function(data){})
	},


	// Порядок следования изображений после drag n drop
	image_update_ordering(r){
		let target = DAN.$(r.target_id)
		let arr = target.getElementsByClassName('e_block_item')

		let images_arr = []

		for (i = 0; i < arr.length; i++) {
			images_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', r.object_id)
		form.append('url', EDIT.url)
		form.append('images', images_arr)

		DAN.modal.del()
		let block_id = 'block_' + r.object_id
		localStorage.setItem('anchor', block_id)
		EDIT.status()

		EDIT.ajax('/edit/block/case/images_ordering', form, function(data){
		})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.case.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.case.text_style_old = EDIT.obj.getElementsByClassName('block_case_1_text_wrap')[0].getAttribute('style')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/case/settings', form, (data) => {
			if (data.message) {
				DAN.modal.add(data.message)
			} else {
				DAN.modal.add(data.content, 600)
				EDIT.block.settings.container()	
				EDIT.block.case.size()

				// Отправить данные методом POST
				DAN.$('e_modal_submit').onclick = function(){
					EDIT.block.case.settings_update(id)
				}

				// Возвращаем старые стили
				DAN.$('e_modal_cancel').onclick = EDIT.block.case.style_reset
			}
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()
		let bg_type = DAN.$('e_block_modal_bg_type').value
		let bg_color = DAN.$('e_block_modal_container_bg_color_input').value
		let bg_image = DAN.$('e_block_modal_bg_image_file').files[0]
		let bg_image_size_1 = DAN.$('e_block_modal_bg_image_size_1') // cover
		let bg_image_size = '';
		let max_width = DAN.$('e_block_modal_max_width').value
		let margin = DAN.$('e_block_modal_margin').value
		let padding = DAN.$('e_block_modal_padding').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		} 

		if (bg_image_size_1.checked) 
			bg_image_size = 'cover';

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('bg_type', bg_type)
		if(bg_type == 'i') 
			form.append('bg_image', bg_image)
		form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('max_width', max_width)
		form.append('margin', margin)
		form.append('padding', padding)

		EDIT.ajax('/edit/block/case/settings_update', form, (data) => {
			if (data.message) {
				DAN.modal.add(data.message)
			}
		})
	},


	// Установка размера
	size(){
		let wrap_width = DAN.$('e_block_modal_max_width')
		let wrap_margin = DAN.$('e_block_modal_margin')
		let wrap_padding = DAN.$('e_block_modal_padding')

		wrap_width.onchange = () => {
			w = wrap_width.value == 100 ? '100%' : wrap_width.value + 'px'
			EDIT.obj.childNodes[1].style.maxWidth = w
		}

		wrap_margin.onchange = () => {
			EDIT.obj.childNodes[1].style.margin = wrap_margin.value + 'px auto'		
		}

		wrap_padding.onchange = () => {
			EDIT.obj.getElementsByClassName('block_case_1_text_wrap')[0].style.padding = wrap_padding.value + 'px'	
		}
	},


	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.case.container_style_old)
		EDIT.block.case.container_style_old = '';
		EDIT.obj.getElementsByClassName('block_case_1_text_wrap')[0].setAttribute('style', EDIT.block.case.text_style_old)
		EDIT.block.case.case = '';
		EDIT.obj = '';
		DAN.modal.del()
	},


	// Редактировать текст
	text_edit(id){
		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		let txt = EDIT.obj.getElementsByClassName('block_case_1_text_wrap')[0].childNodes[0]
		EDIT.obj = txt

		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", () => {
			let content_new = CKEDITOR.instances.e_editor.getData()
			let id = EDIT.obj.parentNode.parentNode.getAttribute('data-id')

			EDIT.obj.parentNode.id = ''
			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let form = new FormData()
				form.append('id', id)
				form.append('p', EDIT.p)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/case/text_update', form, function(data){
					EDIT.status(true)
				})
			}
		});
	},
}