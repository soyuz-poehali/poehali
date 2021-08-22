EDIT.block.icon = {
	container_style_old: '',
	wrap_style_old: '',

	add(id){
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/icon/icon_add', form, (data) => {
			DAN.modal.add(data.content, 600)
			EDIT.status(true)

			let ico = document.getElementsByClassName('e_block_modal_icon_svg')
			for (i = 0; i < ico.length; i++) {
				ico[i].onclick = (e) => {
					let icon = e.target.dataset.icon
					DAN.$('e_block_modal_container').removeAttribute('open')
					DAN.$('e_block_modal_icon_select_out').innerHTML = '<img id="e_block_modal_icon_select" data-icon="' + icon + '" src="/lib/svg/' + icon + '.svg">';
				}
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.icon.icon_update(id)
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

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = () => {
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)

			DAN.modal.spinner()

			EDIT.ajax('/edit/block/icon/delete', form, (data) => {
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	icon_delete(id){
		let icon_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('num', icon_num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/icon/icon_delete', form, (data) => {
			EDIT.obj.parentNode.removeChild(EDIT.obj);
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	icon_edit(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/icon/icon_edit', form, (data) => {
			DAN.modal.add(data.content, 600)
			EDIT.status(true)

			let ico = document.getElementsByClassName('e_block_modal_icon_svg')
			for (i = 0; i < ico.length; i++) {
				ico[i].onclick = (e) => {
					let icon = e.target.dataset.icon
					DAN.$('e_block_modal_container').removeAttribute('open')
					DAN.$('e_block_modal_icon_select_out').innerHTML = '<img id="e_block_modal_icon_select" data-icon="' + icon + '" src="/lib/svg/' + icon + '.svg">';
				}
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.icon.icon_update(id, num)
			}
		})
	},


	icon_update(id, icon_num = false){
		let icon = DAN.$('e_block_modal_icon_select').dataset.icon
		let text_1 = DAN.$('e_block_modal_icon_text_1').value
		let text_2 = DAN.$('e_block_modal_icon_text_2').value

		DAN.modal.spinner()

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('num', icon_num)
		form.append('icon', icon)
		form.append('text_1', text_1)
		form.append('text_2', text_2)

		EDIT.ajax('/edit/block/icon/icon_update', form, (data) => {})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.icon.container_style_old = EDIT.obj.getAttribute('style')
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/icon/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 550)

			let style = DAN.$('e_block_modal_icon_style').value

			let container = DAN.$('block_icon_container_' + id)
			let icon_size = DAN.$('e_block_modal_icon_size')
			let icon_size_out = DAN.$('e_block_modal_icon_size_out')
			let icon_color = DAN.$('e_block_modal_icon_color')
			let font_color = DAN.$('e_block_modal_font_color')
			let title_size = DAN.$('e_block_modal_title_size')
			let font_size = DAN.$('e_block_modal_font_size')
			let wrap_opacity = DAN.$('e_block_modal_wrap_opacity')
			let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color')
			let items_wrap = container.getElementsByClassName('e_block_item')
			let items_svg_wrap = container.getElementsByClassName('block_icon_item_svg_wrap')
			let items_svg_hover = container.getElementsByClassName('block_icon_item_svg_hover')
			let items_svg = container.getElementsByClassName('block_icon_item_svg')
			let items_title = container.getElementsByClassName('block_icon_item_title')

			// --- ИНИЦИАЛИЗАЦИЯ НАСТРОЕК ---
			if(DAN.$('e_block_modal_container')) EDIT.block.settings.container()
			if(DAN.$('e_block_modal_size')) EDIT.block.settings.size()

			// padding - отступы между блоками
			let padding = DAN.$('e_block_modal_padding')
			padding.onchange = () => {
				if (items_wrap.length > 0) {
					for (let i = 0; i < items_wrap.length; i++) {
						items_wrap[i].style.margin = padding.value + 'px'
					}
				}
			}


			icon_size.onmousemove = () => {
				icon_size_out.innerHTML = icon_size.value
				if (items_svg.length > 0) {
					for (let i = 0; i < items_svg.length; i++) {
						if (style == 1 || style == 2) {
							items_svg[i].style.width = (icon_size.value / 2) + 'px'
							items_svg[i].style.height = (icon_size.value / 2) + 'px'
							items_svg[i].style.top = (icon_size.value / 4) + 'px'
							items_svg[i].style.left = (icon_size.value / 4) + 'px'
						}

						if (style == 3) {
							items_svg[i].style.width = icon_size.value + 'px'
							items_svg[i].style.height = icon_size.value + 'px'
						}

						items_svg_wrap[i].style.width = icon_size.value + 'px'
						items_svg_wrap[i].style.height = icon_size.value + 'px'
					}
				}
			}

			// --- OPTIONS ---
			title_size.oninput = () => {
				if (items_title.length > 0) {
					for (let i = 0; i < items_title.length; i++){
						items_title[i].style.fontSize = title_size.value + 'px'
					}
				}
			}

			font_color.oninput = () => {
				EDIT.obj.style.color = font_color.value
			}

			font_size.oninput = () => {
				EDIT.obj.style.fontSize = font_size.value + 'px'
			}

			icon_color.oninput = () => {
				if (items_svg_wrap.length > 0) {
					for (let i = 0; i < items_svg_wrap.length; i++) {
						items_svg_wrap[i].style.borderColor = icon_color.value
					}
				}
				
				if (items_svg_hover.length > 0) {
					for (let i = 0; i < items_svg_hover.length; i++) {
						items_svg_hover[i].style.backgroundColor = icon_color.value
					}
				}

				for (let i = 0; i < items_svg.length; i++) {
					items_svg[i].style.fill = icon_color.value
				}

			}

			// --- WRAP ---
			set_color()

			// Вкл / выкл цвет подложки
			DAN.$('e_block_modal_wrap_bg_color_check').onclick = set_color

			// Устанавливает цвет подложки
			wrap_bg_color.onchange = set_color

			// Ползунок прозрачности
			wrap_opacity.onmousemove = () => {
				set_color()
				DAN.$('e_block_modal_wrap_opacity_out').innerHTML = wrap_opacity.value
			}

			function set_color(){
				if (DAN.$('e_block_modal_wrap_bg_color_check').checked) {
					//DAN.$('e_block_modal_wrap_opacity_tr').style.display = 'table-row'
					wrap_bg_color.style.display = 'inline-block'

					let opacity = wrap_opacity.value/100
					let hex = wrap_bg_color.value

					if (items_wrap.length > 0) {
						for (let i = 0; i < items_wrap.length; i++) {
							items_wrap[i].style.backgroundColor = DAN.hexToRGB(hex, opacity)
						}
					}
				} else {
					wrap_bg_color.style.display = 'none'
					DAN.$('e_block_modal_wrap_opacity_tr').style.display = 'none'
					if (items_wrap.length > 0) {
						for (let i = 0; i < items_wrap.length; i++) {
							items_wrap[i].style.backgroundColor = ''
						}
					}
				}
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.icon.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = () => {
				EDIT.block.icon.style_reset(id)
			}
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()
		let style = DAN.$('e_block_modal_icon_style').value
		let icon_size = DAN.$('e_block_modal_icon_size').value
		let icon_color = DAN.$('e_block_modal_icon_color').value
		let color = DAN.$('e_block_modal_font_color').value
		let title_size = DAN.$('e_block_modal_title_size') ? DAN.$('e_block_modal_title_size').value : false
		let font_size = DAN.$('e_block_modal_font_size') ? DAN.$('e_block_modal_font_size').value : false
		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file') ? DAN.$('e_block_modal_bg_image_file').files[0] : false
		let bg_image_size = DAN.$('e_block_modal_bg_image_size_1').checked ? 'cover' : '';
		let wrap_bg_check = DAN.$('e_block_modal_wrap_bg_color_check').checked ? 1 : 0
		let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color').value
		let wrap_bg_opacity = DAN.$('e_block_modal_wrap_opacity').value
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let margin = DAN.$('e_block_modal_margin') ? DAN.$('e_block_modal_margin').value : false
		let padding = DAN.$('e_block_modal_padding') ? DAN.$('e_block_modal_padding').value : false

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if(bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))){
			alert ('Не выбрано изображение')
			return
		}

		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('style', style)
		form.append('icon_size', icon_size)
		form.append('icon_color', icon_color)
		form.append('color', color)
		if(title_size) form.append('title_size', title_size)
		if(font_size) form.append('font_size', font_size)
		if(bg_type) form.append('bg_type', bg_type)
		if(bg_type == 'i') form.append('bg_image', bg_image)
		if(bg_color) form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('wrap_bg_check', wrap_bg_check)
		form.append('wrap_bg_color', wrap_bg_color)
		form.append('wrap_bg_opacity', wrap_bg_opacity)
		if(max_width) form.append('max_width', max_width)
		if(margin) form.append('margin', margin)
		if(padding) form.append('padding', padding)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/icon/settings_update', form, (data) => {})
	},


	// Возвращает стили объекта
	style_reset(id){
		localStorage.setItem('anchor', 'block_' + id)
		document.location.href = '/' + EDIT.url
		/*
		EDIT.obj.setAttribute('style', EDIT.block.icon.container_style_old)
		EDIT.obj = '';
		DAN.modal.del()
		*/
	},


	update_ordering(r){
		let target = DAN.$(r.target_id)
		let arr = target.getElementsByClassName('e_block_item')

		let icon_arr = []

		for (i = 0; i < arr.length; i++) {
			icon_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('id', r.object_id)
		form.append('p', EDIT.p)
		form.append('icons', icon_arr)

		EDIT.ajax('/edit/block/icon/icon_ordering', form, (data) => {
			EDIT.status(true)
		})
	}
}