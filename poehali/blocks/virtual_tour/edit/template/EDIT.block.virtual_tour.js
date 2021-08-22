EDIT.block.virtual_tour = {
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

			EDIT.ajax('/edit/block/virtual_tour/delete', form, (data) => {
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
		EDIT.block.virtual_tour.container_style_old = EDIT.obj.getAttribute('style')
		let items = EDIT.obj.getElementsByClassName('block_virtual_tour_item_wrap')

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		EDIT.ajax('/edit/block/virtual_tour/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 600)
			EDIT.block.settings.container()

			let wrap_width = DAN.$('e_block_modal_max_width')
			let margin = DAN.$('e_block_modal_margin')

			wrap_width.onchange = () => {
				w = wrap_width.value == 100 ? '100%' : wrap_width.value + 'px'
				EDIT.obj.childNodes[1].style.maxWidth = w
			}

			margin.onchange = () => {
				EDIT.obj.childNodes[1].style.margin = margin.value + 'px auto'		
			}

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.virtual_tour.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = EDIT.block.virtual_tour.style_reset
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

		EDIT.ajax('/edit/block/virtual_tour/settings_update', form, (data) => {
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

		EDIT.ajax('/edit/block/virtual_tour/items', form, (data) => {
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

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {

				// Проверяем новый порядок и исходный, если совпадает - прерываем отправку
				let arr = document.getElementsByClassName('e_block_modal_item')
				let slides_arr = []

				for (i = 0; i < arr.length; i++) {
					slides_arr[i] = arr[i].getAttribute('data-item_num')
				}

				let result_str = slides_arr.join(' ')

				if (result_str == initial_str) {
					DAN.modal.del()
					return;
				}
				EDIT.block.virtual_tour.items_ordering(id, slides_arr)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})		
	},

	item_edit(id){
		let num = EDIT.obj.dataset.item_num
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		let act = ''
		if (typeof(num) != 'undefined')
			form.append('num', num)

		EDIT.ajax('/edit/block/virtual_tour/item_edit', form, (data) => {
			DAN.modal.add(data.content, 550)
			let f = DAN.$('e_modal_file')

			f.onchange = () => {
				let file = f.files[0]
				EDIT.block.virtual_tour.file(file)
			}

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.virtual_tour.item_update(id, num)
			}
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},

	item_update: function(id, num = false){
		let file = DAN.$('e_modal_file').files[0]
		let text = DAN.$('e_modal_text').value

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		if (num) 
			form.append('num', num)
		if (typeof(file) != 'undefined')
			form.append('file', file)
		form.append('text', text)

		EDIT.ajax('/edit/block/virtual_tour/item_update', form, (data) => {
			DAN.modal.del()
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},

	item_delete(id){
		let num = EDIT.obj.dataset.item_num
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('num', num)

		EDIT.ajax('/edit/block/virtual_tour/item_delete', form, (data) => {
			DAN.modal.del()
			EDIT.status(true)
			let block_id = 'block_' + id
			localStorage.setItem('anchor', block_id)
			document.location.href = '/' + EDIT.url
		})
	},

	// Выводит кнопку "Сохранить" при изменении порядка следования элементов
	items_ordering(){
		DAN.$('e_modal_wrap_buttons').style.display = 'flex'
		DAN.$('e_modal_submit').onclick = () => {
			let target = DAN.$('block_modal_target')
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

			EDIT.ajax('/edit/block/virtual_tour/items_ordering', form, (data) => {
				DAN.modal.del()
				EDIT.status(true)
				let block_id = 'block_' + id
				localStorage.setItem('anchor', block_id)
				document.location.href = '/' + EDIT.url
			})
		}		
	},

	// Возвращает стили объекта
	style_reset(){
		EDIT.obj.setAttribute('style', EDIT.block.virtual_tour.container_style_old)
		EDIT.obj = '';
		DAN.modal.del()
	},

	// Выводит кнопку "Сохранить" при изменении порядка следования элементов
	help(){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', EDIT.obj.dataset.id)

		EDIT.ajax('/edit/block/virtual_tour/help', form, (data) => {
			DAN.modal.add(data.content)
		})
	}
}