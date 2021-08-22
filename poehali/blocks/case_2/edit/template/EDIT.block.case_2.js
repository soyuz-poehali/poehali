EDIT.block.case_2 = {
	container_style_old: '',
	text_style_old: '',
	reload_but: false,

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

			EDIT.ajax('/edit/block/case_2/delete', form, function(data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status()
			})
		}
	},


	// Проверка типа и размера файла
	file(e){
		let file = e.target.files
		if (file[0].size > 3000000) {
			alert('Размер исходного изображения слишком большой')
			return
		}

		if (file[0].type != 'image/jpeg' && file[0].type !=  'image/gif' && file[0].type != 'image/png') {
			alert('Неверный формат изображения')
			return
		}
	},


	// Выводит настройки в модальном окне
	settings_edit(id){
		EDIT.block.case_2.container_style_old = EDIT.obj.getAttribute('style')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/case_2/settings_edit', form, (data) => {
			if (data.message) {
				DAN.modal.add(data.message)
			} else {
				DAN.modal.add(data.content, 600)
				EDIT.block.settings.container()	
				EDIT.block.case_2.size()
				EDIT.block.case_2.font()

				// Отправить данные методом POST
				DAN.$('e_modal_submit').onclick = () => {
					EDIT.block.case_2.settings_update(id)
				}

				// Возвращаем старые стили
				DAN.$('e_modal_cancel').onclick = EDIT.block.case_2.style_reset
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
			let items = EDIT.obj.getElementsByClassName('block_case_2_1_item_wrap')
			for (var i = 0; i < items.length; i++) {
				items[i].style.margin = wrap_padding.value + 'px'	
			}
		}
	},


	// Установка размера
	font(){
		let font_size = DAN.$('e_block_modal_font_size')
		let font_color = DAN.$('e_block_modal_font_color')
		let line_height = DAN.$('e_block_modal_line_height')

		font_size.onchange = () => {
			let items_text = EDIT.obj.getElementsByClassName('block_case_2_1_text')
			let items_icon = EDIT.obj.getElementsByClassName('block_case_2_1_icon_container')
			for (var i = 0; i < items_text.length; i++) {
				items_text[i].style.fontSize = Number(font_size.value) + 2 + 'px'
				items_icon[i].style.fontSize = font_size.value + 'px'
			}
		}

		font_color.onchange = () => {
			let items = EDIT.obj.getElementsByClassName('block_case_2_1_item_wrap')
			let svgs = EDIT.obj.getElementsByClassName('block_case_2_1_item_svg')
			for (var i = 0; i < items.length; i++) {
				items[i].style.color = font_color.value
			}
			for (var i = 0; i < svgs.length; i++) {
				svgs[i].style.fill = font_color.value
			}
		}

		line_height.onmousemove = () => {
			DAN.$('e_block_modal_line_height_out').innerHTML = line_height.value 
			let items = EDIT.obj.style.lineHeight = line_height.value / 100
		}
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
		let font_select = DAN.$('e_block_modal_font_select').value
		let font_size = DAN.$('e_block_modal_font_size').value
		let line_height = DAN.$('e_block_modal_line_height').value
		let color = DAN.$('e_block_modal_font_color').value
		
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
		if (bg_type == 'i') 
			form.append('bg_image', bg_image)
		form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('max_width', max_width)
		form.append('margin', margin)
		form.append('padding', padding)
		form.append('font_select', font_select)
		form.append('font_size', font_size)
		form.append('line_height', line_height)
		form.append('color', color)

		EDIT.ajax('/edit/block/case_2/settings_update', form, (data) => {})
	},


	// Возвращает стили объекта - доделать items
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.case_2.container_style_old)
		EDIT.block.case_2.container_style_old = '';
		EDIT.obj.getElementsByClassName('block_case_2_1_text_wrap')[0].setAttribute('style', EDIT.block.case_2.text_style_old)
		EDIT.block.case_2.case = '';
		EDIT.obj = '';
		DAN.modal.del()
	},


	item_add(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		EDIT.ajax('/edit/block/case_2/item_add', form, (data) => {
			EDIT.status()
		})		
	},


	item_edit: function(id) {
		let num = EDIT.obj.dataset.itemNum
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)
		EDIT.ajax('/edit/block/case_2/item_edit', form, (data) => {
			DAN.modal.add(data.content, 600)
			EDIT.block.initialize()

			let images = DAN.$('e_block_case_2_modal_images_container').getElementsByClassName('e_block_case_2_modal_images')
			let icons = DAN.$('e_block_case_2_modal_icons_container').getElementsByClassName('e_block_case_2_modal_icons')

			if (images.length >= 5)
				DAN.$('e_block_case_2_modal_image_add').style.display = 'none'

			if (icons.length >= 4)
				DAN.$('e_block_case_2_modal_icon_add').style.display = 'none'

			DAN.$('e_modal_submit').onclick = () => {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', num)
				form.append('text', DAN.$('e_block_case_2_modal_item_text').value)
				form.append('link', DAN.$('e_block_case_2_modal_item_link').value)
				EDIT.ajax('/edit/block/case_2/item_text_update', form, function(data){})	
			}

			DAN.$('e_block_case_2_modal_image_add').onclick = () => {

				if (images.length >= 5) {
					alert('Количество изображений не может превышать 5 шт.')
					return
				}

				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', num)
				EDIT.ajax('/edit/block/case_2/item_image_add', form, (data) => {})	
			}

			DAN.$('e_block_case_2_modal_icon_add').onclick = () => {

				if (icons.length >= 4) {
					alert('Количество иконок не может превышать 4 шт.')
					return
				}

				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', num)
				EDIT.ajax('/edit/block/case_2/item_icon_add', form, (data) => {})	
			}


			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	items_ordering(r){
		let items = DAN.$('block_case_2_container_'  + r.object_id).getElementsByClassName('e_block_item')

		items_num = []
		for (i = 0; i < items.length; i++) {
			items_num.push(items[i].dataset.itemNum)
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', r.object_id)
		form.append('items_num', items_num)
		EDIT.ajax('/edit/block/case_2/items_ordering', form, (data) => {})
	},


	item_delete(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', EDIT.obj.dataset.itemNum)
		EDIT.ajax('/edit/block/case_2/item_delete', form, function(data){})
	},


	item_image_delete(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', EDIT.obj.dataset.itemNum)
		form.append('image_num', EDIT.obj.dataset.imageNum)
		EDIT.ajax('/edit/block/case_2/item_image_delete', form, function(data){})		
	},


	item_image_edit(id){
		let content = 
			'<h2>Выбрать новое изображение</h2>' + 
			'<div style="margin-bottom:20px" class="dan_flex_center"><input id="block_case_2_image_input" type="file"></div>' + 
			'<div class="e_modal_wrap_buttons">' +
				'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>' + 
				'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
			'</div>'

		DAN.modal.add(content, 600)

		let file_input = DAN.$('block_case_2_image_input')
		file_input.onchange = EDIT.block.case_2.file
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = () => {
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)
			form.append('num', EDIT.obj.dataset.itemNum)
			form.append('image_num', EDIT.obj.dataset.imageNum)
			form.append('file', file_input.files[0])
			EDIT.ajax('/edit/block/case_2/item_image_update', form, function(data){})
		}
	},


	item_images_ordering(r){
		let elements = document.getElementsByClassName('e_block_case_2_modal_images')

		images_num = []
		for (i = 0; i < elements.length; i++) {
			images_num.push(elements[i].dataset.imageNum)
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', r.object_id)
		form.append('num', EDIT.obj.dataset.itemNum)
		form.append('images_num', images_num)
		EDIT.ajax('/edit/block/case_2/item_images_ordering', form, (data) => {})
	},


	item_icon_svg_edit(){
		id = EDIT.obj.dataset.id
		item_num = EDIT.obj.dataset.itemNum
		icon_num = EDIT.obj.dataset.iconNum

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', item_num)
		form.append('icon_num', icon_num)
		EDIT.ajax('/edit/block/case_2/item_icon_svg_edit', form, function(data){
			DAN.modal.add(data.content, 600, 400)

			let ico = document.getElementsByClassName('e_block_modal_icon_svg')
			for (i = 0; i < ico.length; i++) {
				ico[i].onclick = (e) => {
					let icon = e.target.dataset.icon
					DAN.$('e_block_modal_icon_select_out').innerHTML = '<img id="e_block_modal_icon_select" data-icon="' + icon + '" src="/lib/svg/' + icon + '.svg">';
					DAN.$('e_block_modal_container').open = false
				}
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				let svg_name = DAN.$('e_block_modal_icon_select').dataset.icon
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', item_num)
				form.append('icon_num', icon_num)
				form.append('svg_name', svg_name)
				EDIT.ajax('/edit/block/case_2/item_icon_svg_update', form, function(data){})
			}
		})		
	},


	item_icon_text(){
		id = EDIT.obj.dataset.id
		item_num = EDIT.obj.dataset.itemNum
		icon_num = EDIT.obj.dataset.iconNum

		let text = EDIT.obj.childNodes[1].innerHTML
		let html = 
		'<h2>Редактировать текст</h2>' +
		 '<div class="flex_row p_5_20">' +
		 	'<div class="e_str_left e_flex_basis_100">Текст:</div>' +
			'<div class="e_str_right">' + 
		 		'<div class="e_flex_center_h">' +
		 			'<input id="e_block_modal_text" data-id="' + id + '"  data-item-num="' + item_num + '" data-icon-num="' + icon_num + '" class="dan_input" name="text" style="width:100%" value="' + text + '">' +
				'</div>' +
			'</div>' +
		'</div>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
		'</div>'

		DAN.modal.add(html, 320)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del

		DAN.$('e_modal_submit').onclick = () => {
			let text = DAN.$('e_block_modal_text').value
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)
			form.append('num', item_num)
			form.append('icon_num', icon_num)
			form.append('text', text)
			EDIT.ajax('/edit/block/case_2/item_icon_text_update', form, (data) => {})
		}
	},


	item_icon_delete(){
		id = EDIT.obj.dataset.id
		item_num = EDIT.obj.dataset.itemNum
		icon_num = EDIT.obj.dataset.iconNum

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', item_num)
		form.append('icon_num', icon_num)
		EDIT.ajax('/edit/block/case_2/item_icon_delete', form, (data) => {})
	},


	item_icons_ordering(r){
		let elements = document.getElementsByClassName('e_block_case_2_modal_icons')

		icons_num = []
		for (i = 0; i < elements.length; i++) {
			icons_num.push(elements[i].dataset.iconNum)
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', r.object_id)
		form.append('num', EDIT.obj.dataset.itemNum)
		form.append('icons_num', icons_num)
		EDIT.ajax('/edit/block/case_2/item_icons_ordering', form, (data) => {})
	},
}