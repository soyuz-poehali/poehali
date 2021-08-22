EDIT.block.menu = {
	container_style: '',

	areas(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/menu/areas', form, function(_data){
			DAN.modal.add(_data.content, 550)
			
			DAN.$('e_block_modal_menu_logo').onclick = EDIT.block.menu.area_logo
			DAN.$('e_block_modal_menu_logo_text').onclick = EDIT.block.menu.area_logo_text
			DAN.$('e_block_modal_menu_phone_1').onclick = function(){
				EDIT.block.menu.area_phone(1)
			}
			DAN.$('e_block_modal_menu_phone_2').onclick = function(){
				EDIT.block.menu.area_phone(2)
			}
			DAN.$('e_block_modal_menu_sn').onclick = EDIT.block.menu.area_sn
			DAN.$('e_block_modal_menu_right_text').onclick = EDIT.block.menu.area_right_text
			DAN.$('e_block_modal_menu_basket').onclick = EDIT.block.menu.area_basket
		})
	},


	area_logo(){
		let id = DAN.$('e_block_modal_menu_areas').getAttribute('data-id')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/menu/area_logo', form, (data) => {
			DAN.modal.add(data.content, 550)
			let f = DAN.$('e_block_modal_menu_logo_file')

			f.onchange = () => {
				let file = f.files[0]

				if (file) {					
					EDIT.block.menu.file(file)
				}
			}

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.menu.area_logo_update(id)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del		
		})	
	},


	area_logo_update(id){
		let pub = DAN.$('e_block_modal_menu_logo_pub').checked ? 1 : 0
		let f = DAN.$('e_block_modal_menu_logo_file')
		let file = f.files[0]
		if(file){
			if(!EDIT.block.menu.file(file)) return false
		
		}
		
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('pub', pub)
		form.append('file', file)
		
		DAN.modal.spinner()

		EDIT.ajax('/edit/block/menu/area_logo_update', form, function(_data){
			if (_data.answer == 'success'){
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
				document.location.href = '/' + EDIT.url
				EDIT.status(true)
			}
		})
	},


	area_logo_text(){
		DAN.modal.del()

		if (EDIT.obj.id == 'e_editor') {
			EDIT.obj.style.minWidth = ''
			EDIT.editorDestroy()
			return
		}

		EDIT.obj = document.getElementsByClassName('block_menu_top_logo_text')[0]
		EDIT.obj.style.minWidth = '100px'
		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", () => {
			EDIT.obj.style.minWidth = ''

			let content_new = CKEDITOR.instances.e_editor.getData()		
			let id = EDIT.obj.parentNode.parentNode.getAttribute('data-id')

			EDIT.obj.id = ''
			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/menu/area_logo_text_update', form, (data) => {
					EDIT.status(true)
				})
			}
		});
	},


	area_phone(type){
		let id = DAN.$('e_block_modal_menu_areas').getAttribute('data-id')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('type', type)

		EDIT.ajax('/edit/block/menu/area_phone', form, (data) => {
			DAN.modal.add(data.content, 550)

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.menu.area_phone_update()
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del		
		})	
	},


	area_phone_update(){
		let id = DAN.$('e_block_modal_menu_phone_id').value
		let type = DAN.$('e_block_modal_menu_phone_type').value
		let pub = DAN.$('e_block_modal_menu_phone_pub').checked ? 1 : 0
		let phone = DAN.$('e_block_modal_menu_phone_phone').value
		let color = DAN.$('e_block_modal_menu_phone_color').value
		let whatsapp = DAN.$('e_block_modal_menu_phone_whatsapp').checked ? 1 : 0
		let viber = DAN.$('e_block_modal_menu_phone_viber').checked ? 1 : 0
		
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('type', type)
		form.append('pub', pub)
		form.append('phone', phone)
		form.append('color', color)
		form.append('whatsapp', whatsapp)
		form.append('viber', viber)
		
		DAN.modal.spinner()

		EDIT.ajax('/edit/block/menu/area_phone_update', form, (data) => {
			if (data.answer == 'success'){
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
				document.location.href = '/' + EDIT.url
				EDIT.status(true)
			}
		})
	},


	area_right_text(){
		DAN.modal.del()

		if (EDIT.obj.id == 'e_editor') {
			EDIT.obj.style.minWidth = ''
			EDIT.editorDestroy()
			return
		}

		EDIT.obj = document.getElementsByClassName('e_block_modal_menu_area_right_text')[0]
		EDIT.obj.style.minWidth = '100px'
		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", () => {
			EDIT.obj.style.minWidth = ''

			let content_new = CKEDITOR.instances.e_editor.getData()		
			let id = EDIT.obj.parentNode.parentNode.parentNode.getAttribute('data-id')

			EDIT.obj.id = ''
			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/menu/area_right_text_update', form, (data) => {
					EDIT.status(true)
				})
			}
		});	
	},
	
	
	area_sn(){
		let id = DAN.$('e_block_modal_menu_areas').getAttribute('data-id')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/menu/area_sn', form, (data) => {
			DAN.modal.add(data.content, 550)

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.menu.area_sn_update()
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del		
		})	
	},


	area_sn_update(){
		let id = DAN.$('e_block_modal_menu_sn_id').value
		let pub = DAN.$('e_block_modal_menu_sn_pub').checked ? 1 : 0
		let vk = DAN.$('e_block_modal_menu_sn_vk').value
		let fb = DAN.$('e_block_modal_menu_sn_fb').value
		let youtube = DAN.$('e_block_modal_menu_sn_youtube').value
		let instagramm = DAN.$('e_block_modal_menu_sn_instagramm').value
		
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('pub', pub)
		form.append('vk', vk)
		form.append('fb', fb)
		form.append('youtube', youtube)
		form.append('instagramm', instagramm)
		
		DAN.modal.spinner()

		EDIT.ajax('/edit/block/menu/area_sn_update', form, (data) => {
			if (data.answer == 'success'){
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
				document.location.href = '/' + EDIT.url
				EDIT.status(true)
			}
		})
	},


	area_basket(){
		let id = DAN.$('e_block_modal_menu_areas').getAttribute('data-id')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/menu/area_basket', form, (data) => {
			DAN.modal.add(data.content, 550)
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.menu.area_basket_update()
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del		
		})	
	},


	area_basket_update(){
		let id = DAN.$('e_block_modal_block_id').value
		let pub = DAN.$('e_block_modal_basket_pub').checked ? 1 : 0
		let catalog_id = DAN.$('e_block_modal_catalog_id').value
		
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('pub', pub)
		form.append('catalog_id', catalog_id)

		EDIT.ajax('/edit/block/menu/area_basket_update', form, (data) => {})
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
		DAN.$('e_modal_submit').onclick = function(){
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)

			EDIT.ajax('/edit/block/menu/delete', form, function(_data){
				if (_data.answer == 'success'){
					EDIT.obj.parentNode.removeChild(EDIT.obj);
					DAN.modal.del()
					EDIT.status(true)
				}
			})
		}
	},


	// Проверка размеров изображения
	file(_file){
		if(_file.size > 3000000){
			alert('Размер исходного изображения слишком большой')
			return false
		}

		if (!_file.type.match(/image.*/)){
			alert('Неверный формат изображения')
			return false
		}
		
		return true
	},


	// Ставим ссылку на блок #block_id
	link_block(e){
		e.stopPropagation
		e.preventDefault
		let block = EDIT.getElement(e, 'block')
		window.removeEventListener('click', EDIT.block.menu.link_block)
		
		// Перебираем все блоки, находим на каком месте стоит наш блок, получаем цвет его фона
		let block_arr = document.getElementsByClassName('block')
		let out = DAN.$('e_block_modal_menu_out')

		for (i = 0; i < block_arr.length; i++) {
			if (block_arr[i].id == block.id) {
				out.innerHTML = '<span>Блок № ' + (i + 1) + '</span>'
				out.style.backgroundColor = block.style.backgroundColor
				DAN.$('dan_2_modal_black').style.display = 'flex'
				DAN.$('e_block_modal_menu_url').value = 'p/' + EDIT.p + '#' + block.id
				DAN.$('e_block_modal_menu_type').selectedIndex = 0
				return
			}
		}
	},


	menu_add(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('block_id', id)
		form.append('url', EDIT.url)

		EDIT.ajax('/edit/block/menu/menu_add', form, (data) => {
			DAN.modal.add(_data.content, 550)
			EDIT.p = data.p
	
			EDIT.block.menu.menu_type()			

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.menu.menu_update(id)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	menu_delete(_this){
		let id = DAN.$('e_block_menu_container').getAttribute('data-id')
		let menu_id = _this.parentNode.parentNode.getAttribute('data-item-id')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('menu_id', menu_id)

		EDIT.ajax('/edit/block/menu/menu_delete', form, (data) => {
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},


	menu_edit(_this){
		let id = DAN.$('e_block_menu_container').getAttribute('data-id')
		let menu_id = _this.parentNode.getAttribute('data-item-id')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('block_id', id)
		form.append('menu_id', menu_id)

		EDIT.ajax('/edit/block/menu/menu_edit', form, (data) => {
			DAN.modal.add(data.content, 550)
			EDIT.p = data.p
			EDIT.block.menu.menu_type()

			DAN.$('e_block_menu_modal_send').onclick = () => {
				EDIT.block.menu.menu_update(id, menu_id)
			}

			DAN.$('e_block_menu_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Выводит список меню
	menu_list(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/menu/menu_list', (data) => {
			DAN.modal.add(data.content, 550)
			EDIT.block.initialize()

			// Сохраняем порядок только в том случае, если он изменён, для проверки заводим строку 'initial_str'
			let arr_initial = document.getElementsByClassName('e_block_modal_item')
			let slider_arr_initial = []

			for (i = 0; i < arr_initial.length; i++) {
				slider_arr_initial[i] = arr_initial[i].getAttribute('data-item-id')
			}

			let initial_str = slider_arr_initial.join(' '); // Переводим в строку с разделителем ('2 22' != '22 2')

			let modal_name = document.getElementsByClassName('e_block_modal_item_name')
			let modal_ico = document.getElementsByClassName('e_block_modal_item_del')
			for (i = 0; i < modal_ico.length; i++) {

				modal_name[i].onclick = function(){
					EDIT.block.menu.menu_edit(this)
				}

				modal_ico[i].onclick = function(){
					EDIT.block.menu.menu_delete(this)
				}
			}

			// Отправить данные методом POST
			DAN.$('e_block_modal_send').onclick = () => {

				// Проверяем новый порядок и исходный, если совпадает - прерываем отправку
				let arr = document.getElementsByClassName('e_block_modal_item')
				let menu_arr = []

				for (i = 0; i < arr.length; i++) {
					menu_arr[i] = arr[i].getAttribute('data-item-id')
				}

				let result_str = menu_arr.join(' ')

				if (result_str == initial_str) {
					DAN.modal.del()
					return;
				}

				EDIT.block.menu.menu_ordering(id, menu_arr)
			}

			DAN.$('e_block_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Сохраняет порядок следования пунктов меню
	menu_ordering(id, menu_ar){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('menu', menu_ar)

		EDIT.ajax('/edit/block/menu/menu_ordering', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},

	
	// Переключает тип меню
	menu_type(){
		let out = DAN.$('e_block_modal_menu_out')
		let url_input = DAN.$('e_block_modal_menu_url')
		let description = DAN.$('e_block_modal_menu_description')

		// Тип ссылки
		let type = DAN.$('e_block_modal_menu_type')
		type.onchange = () => {
			if (type.value == 'page') {
				let pages_out = DAN.$('e_block_modal_pages_out')
				pages_out.style.display = 'block'
				
				let pages_arr = pages_out.getElementsByClassName('e_block_modal_pages_item')
				let type = DAN.$('e_block_modal_menu_type')

				for (i = 0; i < pages_arr.length; i++) {
					pages_arr[i].onclick = function(){
						let page_id = this.getAttribute('data-id')
						EDIT.page_id = page_id
						let title = this.getAttribute('data-title')
						
						pages_out.style.display = 'none'
						url_input.value = 'p/' + page_id

						description.innerHTML = 'Страница'
						out.innerHTML = '<span>' + title + '</span>'
						out.style.backgroundColor = '';
						type.selectedIndex = 0
					}
				}
			}

			if (type.value == 'block') {
				description.innerHTML = 'Блок'
				DAN.$('dan_2_modal_black').style.display = 'none'
				window.addEventListener('click', EDIT.block.menu.link_block);
			}

			if (type.value == 'url') {
				description.innerHTML = 'Ссылка'
				out.style.backgroundColor = ''
				out.innerHTML = '<input id="e_block_modal_menu_link" class="input" type="url">'
				
				let link_input = DAN.$('e_block_modal_menu_link')
				link_input.onchange = () => {
					url_input.value = link_input.value
				}
			}
		}		
	},


	menu_update(id, menu_id=false){

		let name = DAN.$('e_block_modal_menu_name').value
		let menu_url = DAN.$('e_block_modal_menu_url').value

		DAN.modal.spinner()

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('block_id', id)
		if(_menu_id) form.append('menu_id', menu_id)
		form.append('name', name)
		form.append('menu_url', menu_url)

		if (!name) {
			DAN.modal.add('<h1>Не заполнен пункт меню</h1>')
			return
		}

		if (!menu_url) {
			DAN.modal.add('<h1>Не указана ссылка</h1>')
			return
		}

		EDIT.ajax('/edit/block/menu/menu_update', form, (data) => {})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.menu.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.menu.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/menu/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 550)

			if (DAN.$('e_block_modal_container')) 
				EDIT.block.settings.container()

			let max_width_input = DAN.$('e_block_modal_max_width')
			let padding_input = DAN.$('e_block_modal_padding')
			let font_size_input = DAN.$('e_block_modal_font_size')
			let color_input = DAN.$('e_block_modal_font_color')
			let a_arr = document.getElementsByClassName('block_menu_top_1_a')

			// Старые стили
			let old_block_style = EDIT.obj.style
			let old_wrap_style = EDIT.obj.childNodes[1].getAttribute('style')
			let old_font_size = font_size_input.value
			let old_color = color_input.value

			// Размер блока
			max_width_input.onchange = () => {
				let w = max_width_input.value == 100 ? '100%' : max_width_input.value + 'px'
				EDIT.obj.childNodes[1].style.maxWidth = w
			}

			// Отступ
			padding_input.onchange = () => {
				EDIT.obj.childNodes[1].style.margin = padding_input.value + 'px auto'
			}

			// Размер шрифта
			font_size_input.onchange = () => {
				for (i = 0; i < a_arr.length; i++) {
					a_arr[i].style.fontSize = font_size_input.value + 'px'
				}
			}

			// Цвет шрифта
			color_input.onchange = () => {
				for (i = 0; i < a_arr.length; i++) {
					a_arr[i].style.color = color_input.value
				}
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.menu.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = () => {
				EDIT.obj.style = old_block_style
				EDIT.obj.childNodes[1].setAttribute('style', old_wrap_style)

				for (i = 0; i < a_arr.length; i++) {
					a_arr[i].style.fontSize = old_font_size + 'px'
				}

				for (i = 0; i < a_arr.length; i++) {
					a_arr[i].style.color = old_color
				}

				DAN.modal.del()
			}
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()

		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file').files[0]		
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let padding = DAN.$('e_block_modal_padding') ? DAN.$('e_block_modal_padding').value : false
		let sticky = DAN.$('e_block_modal_sticky').checked ? 1 : false
		let font_size = DAN.$('e_block_modal_font_size') ? DAN.$('e_block_modal_font_size').value : false
		let color = DAN.$('e_block_modal_font_color').value
		let color_active = DAN.$('e_block_modal_font_color_active').value
		let template = DAN.$('e_block_modal_template').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		}

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('bg_type', bg_type)
		if (bg_type == 'i') form.append('bg_image', bg_image)
		if (bg_color) form.append('bg_color', bg_color)
		if (max_width) form.append('max_width', max_width)
		if (padding) form.append('padding', padding)
		if (sticky) form.append('sticky', sticky)
		if (font_size) form.append('font_size', font_size)
		form.append('color', color)
		form.append('color_active', color_active)
		form.append('template', template)

		EDIT.ajax('/edit/block/menu/settings_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
		})
	},
}