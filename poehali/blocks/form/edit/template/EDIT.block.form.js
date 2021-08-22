EDIT.block.form = {
	container_style_old: '',
	wrap_style_old: '',


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

		DAN.modal.add(content, 350)

		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)

			DAN.modal.spinner()
			EDIT.ajax('/edit/block/form/delete', form, function(data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	field_add(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/form/field_add', form, function(data){
			DAN.modal.add(data.content, 550)

			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.form.field_update(id)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	field_delete(id){
		let field_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('field_num', field_num)

		EDIT.ajax('/edit/block/form/field_delete', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	field_edit(id){
		let field_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('field_num', field_num)

		EDIT.ajax('/edit/block/form/field_edit', form, (data)=>{
			DAN.modal.add(data.content, 550)

			DAN.$('e_modal_submit').onclick = function(){
				EDIT.block.form.field_update(id, field_num)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	fields_ordering(r){
		let target = DAN.$(r.target_id)
		let arr = target.getElementsByClassName('e_block_item')

		let icon_arr = []

		for(i = 0; i < arr.length; i++){
			icon_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('id', r.object_id)
		form.append('p', EDIT.p)
		form.append('fields', icon_arr)

		EDIT.ajax('/edit/block/form/fields_ordering', form, function(data){
			EDIT.status(true)
			let block_id = 'block_' + data.id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},


	field_update(id, field_num = false){
		let type = DAN.$('e_block_modal_field_type').value
		let text = DAN.$('e_block_modal_field_text').value
		let required = DAN.$('e_block_modal_field_required').checked ? 1 : 0;

		DAN.modal.spinner()

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		if (field_num) 
			form.append('field_num', field_num)
		form.append('type', type)
		form.append('text', text)
		form.append('required', required)

		EDIT.ajax('/edit/block/form/field_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	// Выводит настройки в модальном окне
	settings(id, style=false){
		EDIT.block.form.container_style_old = EDIT.obj.getAttribute('style')

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		if (style)
			form.append('style', style)

		EDIT.ajax('/edit/block/form/settings', form, function(data){
			DAN.modal.add(data.content, 550)

			let container = DAN.$('block_form_' + id + '_container')
			let style = DAN.$('e_block_modal_form_style')
			let button_text = DAN.$('e_block_modal_button_text')
			let button_color = DAN.$('e_block_modal_button_color')
			let button_bg_color = DAN.$('e_block_modal_button_bg_color')
			let fields = container.getElementsByClassName('input')
			let button = DAN.$('block_form_submit')

			// --- ИНИЦИАЛИЗАЦИЯ НАСТРОЕК ---
			EDIT.block.settings.init()
			style.onchange = ()=>{
				alert('Тип формы изменится после сохранения')
			}

			button_text.oninput = ()=>{
				button.value = button_text.value
			}

			button_color.oninput = ()=>{
				button.style.color = button_color.value
			}

			button_bg_color.oninput = ()=>{
				button.style.backgroundColor = button_bg_color.value
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.form.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.form.style_reset
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()
		let style = DAN.$('e_block_modal_form_style').value
		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file') ? DAN.$('e_block_modal_bg_image_file').files[0] : false
		let bg_image_size_1 = DAN.$('e_block_modal_bg_image_size_1') ? DAN.$('e_block_modal_bg_image_size_1') : false // cover
		let wrap_bg_check = DAN.$('e_block_modal_wrap_bg_color_check').checked ? 1 : 0
		let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color').value
		let wrap_bg_opacity = DAN.$('e_block_modal_wrap_opacity').value
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let margin = DAN.$('e_block_modal_margin') ? DAN.$('e_block_modal_margin').value : false
		let padding = DAN.$('e_block_modal_padding') ? DAN.$('e_block_modal_padding').value : false
		let font_select = DAN.$('e_block_modal_font_select').value
		let font_size = DAN.$('e_block_modal_font_size') ? DAN.$('e_block_modal_font_size').value : false
		let line_height = DAN.$('e_block_modal_line_height').value
		let color = DAN.$('e_block_modal_font_color').value
		let button_text = DAN.$('e_block_modal_button_text').value
		let button_color = DAN.$('e_block_modal_button_color').value
		let button_bg_color = DAN.$('e_block_modal_button_bg_color').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		}

		if (bg_image_size_1.checked)
			bg_image_size = 'cover'
		else
			bg_image_size = 'repeat'

		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('style', style)
		if(bg_type) form.append('bg_type', bg_type)
		if(bg_type == 'i') form.append('bg_image', bg_image)
		if(bg_color) form.append('bg_color', bg_color)
		if(bg_image_size) form.append('bg_image_size', bg_image_size)
		form.append('wrap_bg_check', wrap_bg_check)
		form.append('wrap_bg_color', wrap_bg_color)
		form.append('wrap_bg_opacity', wrap_bg_opacity)
		if(max_width) form.append('max_width', max_width)
		if(margin) form.append('margin', margin)
		if(padding) form.append('padding', padding)
		form.append('font_select', font_select)
		if(font_size) form.append('font_size', font_size)
		form.append('line_height', line_height)
		form.append('color', color)
		form.append('button_text', button_text)
		form.append('button_color', button_color)
		form.append('button_bg_color', button_bg_color)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/form/settings_update', form, function(data){
			if (data.message) {
				DAN.modal.add(data.message)
			} else {
				DAN.modal.del()
				EDIT.status(true)
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
				document.location.href = '/' + EDIT.url
			}
		})

	},


	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.form.container_style_old)
		EDIT.obj = '';
		DAN.modal.del()
	},


	// Редактирование текста
	text(id){
		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		let container = DAN.$('block_form_' + id + '_container')
		EDIT.obj = container.getElementsByClassName('block_form_text')[0]
		EDIT.content_old = EDIT.obj.innerHTML
		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", ()=>{
			let content_new = CKEDITOR.instances.e_editor.getData()

			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let form = new FormData()
				form.append('id', id)
				form.append('p', EDIT.p)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/form/text_update', form, function(data){
					DAN.modal.del()
					EDIT.status(true)
				})
			}
		})
	}
}