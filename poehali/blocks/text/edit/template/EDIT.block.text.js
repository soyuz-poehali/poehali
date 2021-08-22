EDIT.block.text = {
	container_style_old: '',
	wrap_style_old: '',


	edit(id){
		EDIT.obj = EDIT.obj.childNodes[1]

		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", function(){

			let text_new = CKEDITOR.instances.e_editor.getData()
			let id = EDIT.obj.parentNode.getAttribute('data-id')

			EDIT.obj.id = ''
			EDIT.editorDestroy()

			if(text_new != EDIT.content_old){
				let req = new XMLHttpRequest()				
				let form = new FormData()
				form.append('id', id)
				form.append('p', EDIT.p)					
				form.append('text', text_new)

				EDIT.ajax('/edit/block/text/save', form, function(data){
					if (data.answer == 'success'){
						EDIT.status(true)
					}
					else{
						EDIT.errLog('Ошибка')
						alert('Ошибка сохранения данных')						
					}
				})
			}
		});
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.text.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.text.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/text/settings', form, (data)=>{
			DAN.modal.add(data.content, 600)
			EDIT.block.settings.init() // Инициализация общих настроек

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.text.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.text.style_reset
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
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

		EDIT.ajax('/edit/block/text/settings_update', form, function(data){
			if (data.answer == 'success') {
				DAN.modal.del()
				EDIT.status(true)
			} else {
				EDIT.errLog('Ошибка')
				alert('Ошибка сохранения данных')
			}
		})
	},


	copy(id){
		let content =
			'<div class="e_modal_title">Копировать блок</div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' + 
					'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Копировать">' + 
				'</div>' + 
				'<div>' + 
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' + 
				'</div>' + 
			'</div>'

		DAN.modal.add(content, 350, 150)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let req = new XMLHttpRequest()
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)
			
			EDIT.ajax('/edit/block/text/copy', form, function(data){
				let new_node = EDIT.obj.cloneNode(true)
				new_node.id = 'block_' + data.id
				new_node.setAttribute('data-id', data.id)
				EDIT.obj.insertAdjacentElement('afterEnd', new_node)

				DAN.jumpTo('block_' + data.id, 500)

				DAN.modal.del()
				EDIT.status(true)
				EDIT.block.initialize()
			})
		}
	},



	del(id){
		let content =
			'<div class="e_modal_title">Удалить блок</div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' + 
					'<input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить">' + 
				'</div>' + 
				'<div>' + 
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' + 
				'</div>' + 
			'</div>'


		DAN.modal.add(content, 350, 150)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = ()=>{
			let req = new XMLHttpRequest()				
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)

			EDIT.ajax('/edit/block/text/delete', form, function(_data){
				if (_data.answer == 'success') {
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


	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.text.container_style_old)
		EDIT.block.text.container_style_old = '';
		EDIT.obj.childNodes[1].setAttribute('style', EDIT.block.text.wrap_style_old)
		EDIT.block.text.wrap_style_old = '';
		EDIT.obj = '';
		DAN.modal.del()
	},


	help(){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', EDIT.obj.dataset.id)

		EDIT.ajax('/edit/block/text/help', form, (data) => {
			DAN.modal.add(data.content)
		})
	}
}