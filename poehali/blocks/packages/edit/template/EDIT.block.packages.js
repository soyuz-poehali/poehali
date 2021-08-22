EDIT.block.packages = {
	container_style_old: '',
	wrap_style_old: '',

	add(id){
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/packages_add', form, function(data){
			DAN.modal.add(data.content, 600)
			EDIT.status(true)
			DAN.accordion('e_block_modal_accordion_head', 'e_block_modal_accordion_body')

			let ico = document.getElementsByClassName('e_block_modal_packages_svg')
			for (i = 0; i < ico.length; i++) {
				ico[i].onclick = (e)=>{
					let packages = e.target.dataset.packages
					DAN.$('e_block_modal_packages_select_out').innerHTML = '<img id="e_block_modal_packages_select" data-packages="' + packages + '" src="/sites/files/svg/' + packages + '.svg">';
				}
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.packages.packages_update(id)
			}
		})
	},
	
	
	button_edit(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/button_edit', form, function(data){
			DAN.modal.add(data.content, 360)
			EDIT.status(true)

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.packages.button_update(id, num)
			}
		})
	},


	button_update(id, num){
		let p_button = DAN.$('e_block_modal_button_text').value

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		if(num) 
			form.append('num', num)

		form.append('button', p_button)
	
		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/button_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			localStorage.setItem('anchor', 'block_' + id)
			document.location.href = '/' + EDIT.url
		})
	},


	check_file(){
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

			img.onload = () => {
				let image_w = parseInt(img.naturalWidth)
				let image_h = parseInt(img.naturalHeight)

				if (image_w < 500 || image_h < 400)
					alert('Размер изображения слишком маленький')
			}
		};

		reader.readAsDataURL(file);
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
		DAN.$('e_modal_submit').onclick = ()=>{
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)

			DAN.modal.spinner()

			EDIT.ajax('/edit/block/packages/delete', form, function(_data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	image_select(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/image_select', form, function(data){
			DAN.modal.add(data.content, 550)
			EDIT.status(true)

			DAN.$('e_modal_packages_file').onchange = EDIT.block.packages.check_file
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = ()=>{
				EDIT.block.packages.image_update(id, num)
			}
		})
	},


	image_update(id, num){
		let file = DAN.$('e_modal_packages_file').files[0]

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if(num) form.append('num', num)
		form.append('file', file)
	
		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/image_update', form, (data)=>{
		})
	},


	// Редактировать ссылку
	link_edit(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/link_edit', form, (data) => {
			DAN.modal.add(data.content, 550)
			EDIT.status(true)
			
			EDIT.block.link_select()

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.packages.link_update(id, num)
			}
		})
	},


	link_update(id, num){
		let p_link = DAN.$('e_block_modal_link').value

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		if(num)
			form.append('num', num)

		form.append('link', p_link)
	
		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/link_update', form, function(data){})
	},


	package_add(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/packages/package_add', form, function(data){})
	},


	package_delete(id){
		let num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/package_delete', form, function(data){
			EDIT.obj.parentNode.removeChild(EDIT.obj);
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + data.id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},


	package_text_1_edit(id){
		let num = EDIT.obj.getAttribute('data-item-num')

		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		let cpanel_item = EDIT.obj.getElementsByClassName('e_item_panel')[0]
		cpanel_item.style.display = 'none'

		let text_2 = EDIT.obj.getElementsByClassName('block_packages_item_text_2_wrap')[0]

		if (text_2)
			text_2.style.display = 'none'

		EDIT.obj = EDIT.obj.getElementsByClassName('block_packages_item_text_1')[0]

		// Если есть ссылка на весь кейс - снимаем переход с неё, удаляем адрес ссылки
		let a = EDIT.obj.parentNode.parentNode
		let a_href = ''
		if (a.tagName == 'A') {
			a_href = a.href
			a.removeAttribute('href')
		}

		EDIT.content_old = EDIT.obj.innerHTML
		EDIT.editor()

		// При потере фокуса - возвращаем адрес в ссылку
		EDIT.ckeditor.on("blur", (e) => {
			if (a.tagName == 'A')
				a.setAttribute('href', a_href)

			cpanel_item.style.display = 'flex'

			if (text_2) 
				text_2.style.display = 'block'

			let content_new = CKEDITOR.instances.e_editor.getData()
			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', num)
				form.append('field', 'text_1')
				form.append('content', content_new)

				EDIT.ajax('/edit/block/packages/package_update', form, function(data){})
			}
		});
	},


	package_text_2_edit(id){
		let num = EDIT.obj.getAttribute('data-item-num')

		if (EDIT.obj.id == 'e_editor') {
			EDIT.editorDestroy()
			return
		}

		let cpanel_item = EDIT.obj.getElementsByClassName('e_item_panel')[0]
		cpanel_item.style.display = 'none'

		let text_2 = EDIT.obj.getElementsByClassName('block_packages_item_text_2_wrap')[0]
		text_2.style.top = '0px'

		EDIT.obj = EDIT.obj.getElementsByClassName('block_packages_item_text_2')[0]
		EDIT.content_old = EDIT.obj.innerHTML
		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", () => {

			cpanel_item.style.display = 'flex'
			text_2.style.top = ''

			let content_new = CKEDITOR.instances.e_editor.getData()

			EDIT.obj.parentNode.id = ''
			EDIT.editorDestroy()

			if (content_new != EDIT.content_old) {
				let form = new FormData()
				form.append('p', EDIT.p)
				form.append('id', id)
				form.append('num', num)
				form.append('field', 'text_2')
				form.append('content', content_new)

				EDIT.ajax('/edit/block/packages/package_update', form, function(data){})
			}
		});
	},


	packages_update(id, packages_num=false){
		let packages = DAN.$('e_block_modal_packages_select').dataset.packages
		let text_1 = DAN.$('e_block_modal_packages_text_1').value
		let text_2 = DAN.$('e_block_modal_packages_text_2').value

		DAN.modal.spinner()

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', _id)
		form.append('packages_num', packages_num)
		form.append('packages', packages)
		form.append('text_1', text_1)
		form.append('text_2', text_2)

		EDIT.ajax('/edit/block/packages/packages_update', form, (data) => {})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.packages.container_style_old = EDIT.obj.getAttribute('style')
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/packages/settings_edit', form, function(data){
			DAN.modal.add(data.content, 550)
			let container = DAN.$('block_packages_container_' + id)
			let wrap_width = DAN.$('e_block_modal_max_width')
			let margin = DAN.$('e_block_modal_margin')
			let padding = DAN.$('e_block_modal_padding')
			let border_radius = DAN.$('e_block_modal_border_radius')
			let style = DAN.$('e_block_modal_packages_style')
			let text_1_bg = DAN.$('e_block_modal_packages_text_1_bg')
			let text_2_bg = DAN.$('e_block_modal_packages_text_2_bg')

			let items = container.getElementsByClassName('e_block_item')
			let items_svg_wrap = container.getElementsByClassName('block_packages_item_svg_wrap')
			let items_svg_hover = container.getElementsByClassName('block_packages_item_svg_hover')
			let items_svg = container.getElementsByClassName('block_packages_item_svg')
			let items_title = container.getElementsByClassName('block_packages_item_title')

			// --- ИНИЦИАЛИЗАЦИЯ НАСТРОЕК ---
			if (DAN.$('e_block_modal_container')) 
				EDIT.block.settings.container()

			// Изменение стиля
			style.onchange = () => {
				alert("Тип плашки измениться после сохранения")
			}

			// Установка цвета кнопки из установок
			let button_color_s = DAN.$('e_block_modal_packages_button_color_wrap').getElementsByClassName('e_block_modal_color_round')

			for (var i = 0; i < button_color_s.length; i++) {
				button_color_s[i].onclick = (e) => {
					DAN.$('e_block_modal_packages_button_color').value = e.target.dataset.color
				}
			}

			// Установка цвета фона кнопки из установок
			let button_bg_color_s = DAN.$('e_block_modal_packages_button_bg_color_wrap').getElementsByClassName('e_block_modal_color_round')

			for (var i = 0; i < button_bg_color_s.length; i++) {
				button_bg_color_s[i].onclick = (e) => {
					DAN.$('e_block_modal_packages_button_bg_color').value = e.target.dataset.color
				}
			}

			// Установка размера
			wrap_width.onchange = () => {
				w = wrap_width.value == 100 ? '100%' : wrap_width.value + 'px'
				EDIT.obj.childNodes[1].style.maxWidth = w
			}

			margin.oninput = () => {
				EDIT.obj.childNodes[1].style.margin = (margin.value * 3) + 'px auto'
				if (items.length > 0) {
					for (let i = 0; i < items.length; i++) {
						items[i].style.margin = margin.value + 'px'
					}
				}
			}

			// padding - отступы между блоками
			padding.oninput = () => {
				if (items.length > 0) {
					for (let i = 0; i < items.length; i++) {
						items[i].childNodes[0].childNodes[1].childNodes[1].style.padding = padding.value + 'px'
					}
				}
			}

			// border_radius - радиус скругления углов
			border_radius.oninput = () => {
				if (items.length > 0) {
					for (let i = 0; i < items.length; i++){
						items[i].childNodes[0].childNodes[1].style.borderRadius = border_radius.value + 'px'
					}
				}
			}

			// Фон текста 1
			text_1_bg.oninput = () => {
				let color = text_1_bg.value
				if (items.length > 0) {
					for (let i = 0; i < items.length; i++) {
						items[i].getElementsByClassName('block_packages_item_text_1')[0].style.backgroundColor = color
					}
				}
			}

			// Фон текста 2
			text_2_bg.oninput = () => {
				let color = text_2_bg.value
				if (items.length > 0) {
					for (let i = 0; i < items.length; i++) {
						items[i].childNodes[0].childNodes[1].childNodes[1].style.backgroundColor = color
					}
				}
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.packages.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = () => {
				EDIT.block.packages.style_reset(id)
			}
		})
	},


	// Обновляет настройки на Ajax
	settings_update(id){
		let form = new FormData()
		let style = DAN.$('e_block_modal_packages_style').value
		let image_format = DAN.$('e_block_modal_packages_format').value
		let but = DAN.$('e_block_modal_packages_button').checked ? 1 : 0;
		let button_color = DAN.$('e_block_modal_packages_button_color').value
		let button_bg_color = DAN.$('e_block_modal_packages_button_bg_color').value
		let text_1_bg = DAN.$('e_block_modal_packages_text_1_bg').value
		let text_2_bg = DAN.$('e_block_modal_packages_text_2_bg').value
		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file') ? DAN.$('e_block_modal_bg_image_file').files[0] : false
		let bg_image_size = DAN.$('e_block_modal_bg_image_size_1').checked ? 'cover' : '';
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let margin = DAN.$('e_block_modal_margin').value
		let padding = DAN.$('e_block_modal_padding').value
		let border_radius = DAN.$('e_block_modal_border_radius').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if (bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))) {
			alert ('Не выбрано изображение')
			return
		}

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('style', style)
		form.append('image_format', image_format)
		form.append('button', but)
		form.append('button_color', button_color)
		form.append('button_bg_color', button_bg_color)
		form.append('text_1_bg', text_1_bg)
		form.append('text_2_bg', text_2_bg)
		if(bg_type) form.append('bg_type', bg_type)
		if(bg_type == 'i') form.append('bg_image', bg_image)
		if(bg_color) form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		if(max_width) form.append('max_width', max_width)
		form.append('margin', margin)
		form.append('padding', padding)
		form.append('border_radius', border_radius)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/packages/settings_update', form, function(data){
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
	style_reset(id){
		localStorage.setItem('anchor', 'block_' + id)
		document.location.href = '/' + EDIT.url
	},


	update_ordering(r){
		let target = DAN.$(r.target_id)
		let arr = target.getElementsByClassName('e_block_item')

		let packages_arr = []

		for (i = 0; i < arr.length; i++) {
			packages_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', r.object_id)
		form.append('packages', packages_arr)

		EDIT.ajax('/edit/block/packages/packages_ordering', form, function(data){
			EDIT.status(true)
			let block_id = 'block_' + data.id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	}

}