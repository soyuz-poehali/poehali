EDIT.block.image_360 = {
	container_style_old: '',
	item_files: false,  // Отправляемые данные модели
	n: 0,  // Порядковый номер отправляемого файла на ajax

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

			EDIT.ajax('/edit/block/image_360/delete', form, (data) => {
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status()
			})
		}
	},


	// Проверка размеров изображения
	file(file){
		if (file.size > 10000000) {
			alert('Размер исходного изображения слишком большой')
			return
		}

		if (!file.type.match(/image.*/)) {
			alert('Неверный формат изображения')
			return
		}
	},


	settings_edit(id){
		EDIT.block.image_360.container_style_old = EDIT.obj.getAttribute('style')
		let items = EDIT.obj.getElementsByClassName('block_image_360_item_wrap')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/image_360/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 600)

			let wrap_width = DAN.$('e_block_modal_max_width')
			let margin = DAN.$('e_block_modal_margin')
			let img_max_width = DAN.$('e_block_modal_max_width_360')
			let bg_color_input = DAN.$('e_block_modal_container_bg_color_input')

			bg_color_input.oninput = () => {
				EDIT.obj.style.backgroundColor = bg_color_input.value
			}

			wrap_width.onchange = () => {
				w = wrap_width.value == 100 ? '100%' : wrap_width.value + 'px'
				EDIT.obj.childNodes[1].style.maxWidth = w
			}

			margin.onchange = () => {
				EDIT.obj.childNodes[1].style.margin = margin.value + 'px auto'		
			}

			img_max_width.onchange = () => {
				DAN.$('block_image_360_wrap').style.maxWidth = img_max_width.value + 'px';
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.image_360.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = () => {
				DAN.modal.del()
				EDIT.block.image_360.style_reset()
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
		let max_width_360 = DAN.$('e_block_modal_max_width_360').value

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
		form.append('max_width_360', max_width_360)

		EDIT.ajax('/edit/block/image_360/settings_update', form, (data) => {
			if (data.message) {
				DAN.modal.add(data.message)
			} else {
				DAN.modal.del()
				EDIT.status(true)
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
			}
		})
	},


	// Выводит все сцены - изображения в модальном окне
	items(id){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/image_360/items', form, (data) => {
			DAN.modal.add(data.content, 550)

			// Сохраняем порядок только в том случае, если он изменён, для проверки заводим строку 'initial_str'
			let arr_initial = document.getElementsByClassName('e_block_modal_item')
			let vt_arr_initial = []

			for (i = 0; i < arr_initial.length; i++) {
				vt_arr_initial[i] = arr_initial[i].getAttribute('data-item_num')
			}

			let initial_str = vt_arr_initial.join(' '); // Переводим в строку с разделителем ('2 22' != '22 2')

			EDIT.block.initialize()
			DRAG_DROP()

			panel_icons = document.getElementsByClassName('e_block_panel_items_ico')
			for (var i = 0; i < panel_icons.length; i++) {
				panel_icons[i].onclick = (e) => {
					let icon = e.target
					let svg = EDIT.block.image_360.get_svg_items_panel(icon)
					let action = svg.dataset.action

					EDIT.obj = EDIT.getElement(e, 'e_block_modal_item')

					EDIT.block.image_360[action](id)
					console.log(action)
				}
			}
		})		
	},


	item_edit(id){
		let num = EDIT.obj.dataset.item_num
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		
		// Если есть num - редактируем только текст, строку с выбором файлов - скрываем
		if (typeof(num) != 'undefined')
			form.append('num', num)

		EDIT.ajax('/edit/block/image_360/item_edit', form, (data) => {
			DAN.modal.add(data.content, 550)

			if (typeof(num) != 'undefined')
				DAN.$('e_modal_tr_file').style.display = 'none'


			DAN.$('e_modal_file').onchange = (e) => {
				input_file = DAN.$('e_modal_file')
				let files = e.target.files
				let id = e.target.dataset.id
	
				if (!files || files.length == 0) {
					alert('Не выбрано ни одного изображения')
					return
				}

				for (var i = 0; i < files.length; i++) {
					if (!files[i].type.match(/image.*/)) {
						alert('Данный формат файла не поддерживается: ' + files[i].name)
						return
					}
					if (files[i].size > 200000) {
						alert('Размер изображения слишком большой - загрузка множества изображений подобного раздела будет очень долгой');
						return
					}
				}

				let n = input_file.dataset.n
				let m = input_file.dataset.m
				if (files.length != n*m) {
					alert('выбранное число файлов - ' + files.length + ' не соответствует требуемому - ' + (n*m ) + '(' + n + ' х ' + m + ')')
					return
				}

				DAN.$('e_modal_files_select').innerHTML = 'Выбрано ' +  files.length + ' файлов.'
			}

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.image_360.item_update(id, num)
			}
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Пошаговое обновление модели
	item_update(id, num=false){
		input_file = DAN.$('e_modal_file')
		EDIT.block.image_360.item_files = input_file.files
		let text = DAN.$('e_modal_text').value

		// Проверка количества файлов
		if (EDIT.block.image_360.item_files.length != 0) {
			let n = input_file.dataset.n
			let m = input_file.dataset.m
			if (EDIT.block.image_360.item_files.length != n*m) {
				alert('выбранное число файлов - ' + EDIT.block.image_360.item_files.length + ' не соответствует требуемому - ' + (n*m ) + '(' + n + ' х ' + m + ')')
				return
			}
		}

		// При загрузке нового изображения должны быть выбраны файлы
		if (num == 0 && EDIT.block.image_360.item_files.length == 0) {
			alert('Не выбраны файлы')
			return
		}

		// Шаг 1 - отправка файлов, num не передаём, т.к. пишем файлы во временную папку
		if (EDIT.block.image_360.item_files.length != 0) {
			let p = EDIT.p
			EDIT.block.image_360.item_send_file(id, num, text)
		} 

		// Если есть num - отдаём команду обновления текста
		if (num != 0) {
			EDIT.block.image_360.item_send_text(id, num, text)			
		}
	},


	// Отправка файлов по одному.
	item_send_file(id, num, text){
		let file = EDIT.block.image_360.item_files[EDIT.block.image_360.n]
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if(num) 
			form.append('num', num)
		form.append('file', file)		
		DAN.ajax('/edit/block/image_360/item_update', form, (data) => {
			if (EDIT.block.image_360.n < EDIT.block.image_360.item_files.length) {
				let content = 'Загрузка изображения: <b>' + EDIT.block.image_360.n + '</b> из <b>' + EDIT.block.image_360.item_files.length + '</b>'

				if (DAN.$('dan_2_modal_content')) {
					DAN.$('dan_2_modal_content').innerHTML = content
				} else
					DAN.modal.add(content, 300)

				EDIT.block.image_360.n++
				EDIT.block.image_360.item_send_file(id, num, text)
			} 

			if (EDIT.block.image_360.n == EDIT.block.image_360.item_files.length - 1) {
				EDIT.block.image_360.item_files = false
				EDIT.block.image_360.n = 0	
				// Загружаем текст только в случае, если были переданы изображения 
				// EDIT.block.image_360.n == EDIT.block.image_360.item_files.length - 1
				// Или num != 0
				EDIT.block.image_360.item_send_text(id, num, text)
			}
		})
	},


	// Отправка текста
	item_send_text(id, num, text) {
		EDIT.block.image_360.item_files = false
		EDIT.block.image_360.n = 0

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		if(num) 
			form.append('num', num)
		form.append('text', text)
		EDIT.ajax('/edit/block/image_360/item_update', form, (data) => {
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	item_delete(id){
		let num = EDIT.obj.dataset.item_num
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		EDIT.ajax('/edit/block/image_360/item_delete', form, (data) => {
			if (data.message) {
				DAN.modal.add(data.message)
			} else {
				DAN.modal.del()
				EDIT.status(true)
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
			}
		})
	},


	// Выводит кнопку "Сохранить" при изменении порядка следования элементов
	items_ordering(){
		console.log('ORDERING')

		DAN.$('e_modal_buttons').style.display = 'flex'
		let send = DAN.$('e_modal_submit')
		send.onclick = () => {
			let target = DAN.$('dan_2_modal_content')
			let items = target.getElementsByClassName('e_block_modal_item')
			let arr = []
			for (var i = 0; i < items.length; i++) {
				arr.push(items[i].dataset.item_num)
			}
			let list = arr.join(';')

			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', EDIT.obj.dataset.id)
			form.append('list', list)

			EDIT.ajax('/edit/block/image_360/items_ordering', form, (data) => {
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.image_360.container_style_old)
		EDIT.obj = '';
	},


	// Редактировать текст
	text_edit(){
		let id = EDIT.obj.dataset.id

		EDIT.obj = EDIT.obj.getElementsByClassName('block_image_360_text')[0]
		EDIT.content_old = EDIT.obj.innerHTML
		EDIT.editor()

		let num = EDIT.obj.dataset.num

		// При потере фокуса
		EDIT.ckeditor.on("blur", () => {
			let content_new = CKEDITOR.instances.e_editor.getData()
			EDIT.editorDestroy()
			if (content_new != EDIT.content_old) {
				EDIT.block.image_360.item_send_text(id, num, content_new)		
			}
		})
	},


	// Получаем svg элемент items панели
	get_svg_items_panel(obj){
		while (obj) {
			if (obj.tagName = 'svg' && obj.getAttribute('data-action')) 
				return obj;
			obj = obj.parentElement;
		}
		return false;		
	},


	help(){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', EDIT.obj.dataset.id)

		EDIT.ajax('/edit/block/image_360/help', form, (data) => {
			DAN.modal.add(data.content)
		})
	}
}