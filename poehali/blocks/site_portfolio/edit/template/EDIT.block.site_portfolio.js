EDIT.block.site_portfolio = {
	container_style_old: '',

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

			EDIT.ajax('/edit/block/site_portfolio/delete', form, (data) => {
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status()
			})
		}
	},


	item_add(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('act', 'add')
		EDIT.ajax('/edit/block/site_portfolio/item_edit', form, (data) => {
			DAN.modal.add(data.content, 600)
			let image_file = DAN.$('e_block_modal_file')
			let text = DAN.$('e_block_modal_text')
			let link = DAN.$('e_block_modal_link')
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			image_file.onchange = EDIT.block.site_portfolio.file

			DAN.$('e_modal_submit').onclick = () => {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('file', image_file.files[0])
				form.append('text', text.value)
				form.append('link', link.value)
				EDIT.ajax('/edit/block/site_portfolio/item_insert', form, (data) => {
					console.log(data)
					EDIT.status(true)
				})
			}
		})
	},


	item_edit(id) {
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		let num = EDIT.obj.dataset.itemNum
		form.append('num', num)
		form.append('act', 'edit')
		EDIT.ajax('/edit/block/site_portfolio/item_edit', form, (data) => {
			DAN.modal.add(data.content, 600)

			let image_file = DAN.$('e_block_modal_file')
			let text = DAN.$('e_block_modal_text')
			let link = DAN.$('e_block_modal_link')
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			image_file.onchange = EDIT.block.site_portfolio.file

			DAN.$('e_modal_submit').onclick = () => {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', num)
				form.append('file', image_file.files[0])
				form.append('text', text.value)
				form.append('link', link.value)
				EDIT.ajax('/edit/block/site_portfolio/item_update', form, (data) => {
					console.log(data)
					EDIT.status(true)
				})
			}
		})
	},


	item_delete(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		let num = EDIT.obj.dataset.itemNum
		form.append('num', num)
		EDIT.ajax('/edit/block/site_portfolio/item_delete', form, (data) => {})
	},


	items_ordering(r) {
		let items = DAN.$('block_site_portfolio_container_'  + r.object_id).getElementsByClassName('e_block_item')

		items_num = []
		for (i = 0; i < items.length; i++) {
			items_num.push(items[i].dataset.itemNum)
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', r.object_id)
		form.append('items_num', items_num)
		EDIT.ajax('/edit/block/site_portfolio/items_ordering', form, (data) => {})
	},


	// Проверка типа и размера файла
	file() {
		let file = this.files
		if (file[0].size > 3000000) {
			alert('Размер исходного изображения слишком большой')
			return
		}

		if (file[0].type != 'image/jpeg' && file[0].type !=  'image/gif' && file[0].type != 'image/png') {
			alert('Неверный формат изображения')
			return
		}
	},


	settings_edit(id){
		EDIT.block.site_portfolio.container_style_old = EDIT.obj.getAttribute('style')
		let items = EDIT.obj.getElementsByClassName('block_site_profile_item_wrap')

		EDIT.block.site_portfolio.flex_basis = items[0].style.flexBasis ? items[0].style.flexBasis : 300
		EDIT.block.site_portfolio.border_radius = items[0].style.borderRadius ? items[0].style.borderRadius : 30

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/site_portfolio/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 600)
			EDIT.block.settings.container()

			let wrap_width = DAN.$('e_block_modal_max_width')
			let margin = DAN.$('e_block_modal_margin')
			let items_width = DAN.$('e_block_modal_items_width')
			let items_border_radius = DAN.$('e_block_modal_items_border_radius')

			wrap_width.onchange = () => {
				w = wrap_width.value == 100 ? '100%' : wrap_width.value + 'px'
				EDIT.obj.childNodes[1].style.maxWidth = w
			}

			margin.onchange = () => {
				EDIT.obj.childNodes[1].style.margin = margin.value + 'px auto'		
			}

			let items = EDIT.obj.getElementsByClassName('block_site_profile_item_wrap')

			items_width.onchange = () => {
				for (var i = 0; i < items.length; i++) {
					items[i].style.flexBasis = items_width.value + 'px'
				}	
			}

			items_border_radius.onchange = () => {
				for (var i = 0; i < items.length; i++) {
					items[i].style.borderRadius = items_border_radius.value + 'px'
				}	
			}
			
			// Размер шрифта
			let font_select = DAN.$('e_block_modal_font_select')
			let font_size = DAN.$('e_block_modal_font_size')
			let font_color = DAN.$('e_block_modal_font_color')

			// Переключение размер цвет - из настроек / свой
			font_select.onchange = () => {
				if (font_select.value == 's') {
					DAN.$('e_block_modal_font_tr').style.display = 'none'
					EDIT.obj.style.fontSize = 'var(--font-size)'
					EDIT.obj.style.color= 'var(--font-color)'
				} else {
					DAN.$('e_block_modal_font_tr').style.display = 'table-row'
				}
			}

			// Размер шрифта
			font_size.onchange = () => {
				EDIT.obj.style.fontSize = font_size.value + 'px'
			}

			// Цвет шрифта
			font_color.onchange = () => {
				EDIT.obj.style.color = font_color.value
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.site_portfolio.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.site_portfolio.style_reset
		})
	},


	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.site_portfolio.container_style_old)
		EDIT.block.site_portfolio.container_style_old = '';
		let items = EDIT.obj.getElementsByClassName('block_site_profile_item_wrap')

		for (var i = 0; i < items.length; i++) {
			items[i].style.flexBasis = EDIT.block.site_portfolio.flex_basis + 'px'
			items[i].style.borderRadius = EDIT.block.site_portfolio.border_radius + 'px'
		}

		EDIT.obj = '';
		DAN.modal.del()
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
		let color = DAN.$('e_block_modal_font_color').value
		let font_size = DAN.$('e_block_modal_font_size').value
		let items_width = DAN.$('e_block_modal_items_width').value
		let items_border_radius = DAN.$('e_block_modal_items_border_radius').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if(bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))){
			alert ('Не выбрано изображение')
			return
		}

		if(bg_image_size_1.checked) 
			bg_image_size = 'cover';

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('bg_type', bg_type)
		if (bg_type == 'i') 
			form.append('bg_image', bg_image)
		form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('max_width', max_width)
		form.append('margin', margin)
		form.append('color', color)
		form.append('font_size', font_size)
		form.append('items_width', items_width)
		form.append('items_border_radius', items_border_radius)

		EDIT.ajax('/edit/block/site_portfolio/settings_update', form, (data) => {
			if (data.message){
				DAN.modal.add(data.message)
			}
		})
	}
}