EDIT.block.scrolling_vertical = {
	container_style_old: '',
	wrap_style_old: '',

	// Редактировать текст
	text_edit(id){
		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		EDIT.obj = EDIT.obj.getElementsByClassName('block_scrolling_vertical_text_wrap')[0]

		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", function(){
			let content_new = CKEDITOR.instances.e_editor.getData()
			let id = EDIT.obj.parentNode.parentNode.getAttribute('data-id')

			EDIT.obj.parentNode.id = ''
			EDIT.editorDestroy()

			if(content_new != EDIT.content_old){
				let req = new XMLHttpRequest()
				let form = new FormData()
				form.append('id', id)
				form.append('p', EDIT.p)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/scrolling_vertical/text_update', form, function(_data){
					EDIT.status(true)
				})
			}
		});
	},


	// Обновить изображение
	image(id){
		let image_wrap = EDIT.obj.childNodes[1].childNodes[0];
		let parring = image_wrap.style.padding != '' ? parseInt(image_wrap.style.padding) : 0
		let w = image_wrap.clientWidth - parring * 2

		let content =
		'<h2>Заменить изображение</h2>' +
		'<table class="e_table_admin">' +
			'<tr><td class="e_td_right">Оптимальная ширина изображения для текущих настроек блока:</td><td class="e_text_16_b">' + w + ' px</td></tr>' +
			'<tr><td class="e_td_right">Новое изображение</td><td><input id="e_modal_file" onchange="EDIT.block.scrolling_vertical.file(this.files);" type="file" name="file"></td></tr>' +
		'</table>' +
		'<div id="e_modal_message" class="e_text_16_b" style="text-align:center;color:#4CAF50;"></div>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
		'</div>'

		DAN.modal.add(content)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del

		let file_input = DAN.$('e_modal_file').onchange = EDIT.block.scrolling_vertical.check_file

		// Отправить данные методом POST
		DAN.$('e_modal_submit').onclick = () => {
			file = DAN.$('e_modal_file').files[0]
			var form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)
			form.append('file', file)

			DAN.modal.spinner()

			EDIT.ajax('/edit/block/scrolling_vertical/image_update', form, function(_data){
				EDIT.status(true)
				localStorage.setItem('anchor', 'block_' + _data.id)
				document.location.href = '/' + EDIT.url
			})
		}
	},


	check_file(){
		file = this.files

		if(file[0].size > 3000000){
			alert('Размер исходного изображения слишком большой')
			return
		}

		if(file[0].type != 'image/jpeg' && file[0].type !=  'image/gif' && file[0].type != 'image/png' && file[0].type != 'image/webp'){
			alert('Неверный формат изображения')
			return
		}
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

			EDIT.ajax('/edit/block/scrolling_vertical/delete', form, function(_data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status()
			})
		}
	},


	settings_edit(id){
		EDIT.block.scrolling_vertical.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.scrolling_vertical.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/scrolling_vertical/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 600)
			EDIT.block.settings.container()
			EDIT.block.settings.font()

			// Установка размера
			EDIT.block.scrolling_vertical.size()

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.scrolling_vertical.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.scrolling_vertical.style_reset
		})
	},


	settings_update(id){
		let form = new FormData()
		let bg_type = DAN.$('e_block_modal_bg_type').value
		let bg_color = DAN.$('e_block_modal_container_bg_color_input').value
		let bg_image = DAN.$('e_block_modal_bg_image_file').files[0]
		let bg_image_size_1 = DAN.$('e_block_modal_bg_image_size_1') // cover
		let bg_image_size = '';
		let max_width = DAN.$('e_block_modal_max_width').value
		let height = DAN.$('e_block_modal_height').value
		let margin = DAN.$('e_block_modal_margin').value
		let color = DAN.$('e_block_modal_font_color').value
		let font_size = DAN.$('e_block_modal_font_size').value
		let line_height = DAN.$('e_block_modal_line_height').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		}
		if(bg_image_size_1.checked) bg_image_size = 'cover';

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('bg_type', bg_type)
		if (bg_type == 'i') 
			form.append('bg_image', bg_image)
		form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('max_width', max_width)
		form.append('height', height)
		form.append('margin', margin)
		form.append('color', color)
		form.append('font_size', font_size)
		form.append('line_height', line_height)

		EDIT.ajax('/edit/block/scrolling_vertical/settings_update', form, function(_data){
			if (_data.message) 
				DAN.modal.add(_data.message)
			else {
				DAN.modal.del()
				EDIT.status(true)
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
			}
		})
	},


	size(){
		let wrap_width = DAN.$('e_block_modal_max_width')
		let wrap_margin = DAN.$('e_block_modal_margin')
		let wrap_image_height = DAN.$('e_block_modal_height')

		wrap_width.onchange = function(){
			if (wrap_width.value == 100) {
				w = '100%'
				EDIT.obj.childNodes[1].childNodes[0].classList.add('block_scrolling_vertical_text_wrap_100')
				EDIT.obj.childNodes[1].childNodes[0].classList.remove('block_scrolling_vertical_text_wrap')
			} else {
				w = wrap_width.value + 'px'
				EDIT.obj.childNodes[1].childNodes[0].classList.add('block_scrolling_vertical_text_wrap')
				EDIT.obj.childNodes[1].childNodes[0].classList.remove('block_scrolling_vertical_text_wrap_100')
			}

			EDIT.obj.childNodes[1].style.maxWidth = w
		}

		wrap_margin.onchange = function(){
			EDIT.obj.childNodes[1].style.margin = wrap_margin.value + 'px auto'		
		}

		wrap_image_height.onchange = function(){
			EDIT.obj.getElementsByClassName('block_scrolling_vertical_image_wrap')[0].style.height = wrap_image_height.value + 'px'	
		}
	},


	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.scrolling_vertical.container_style_old)
		EDIT.obj.childNodes[1].setAttribute('style', EDIT.block.scrolling_vertical.wrap_style_old)
		EDIT.block.scrolling_vertical.container_style_old = '';
		EDIT.block.scrolling_vertical.wrap_style_old = ''

		EDIT.obj = '';
		DAN.modal.del()
	},
}