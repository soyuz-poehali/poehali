EDIT.block.contacts = {
	container_style_old: '',
	wrap_style_old: '',
	mapyandex: [],
	mapyandex_mark_action: false, // Тригер маркера режима установки метки
	mapyandex_mark_title: false,
	mapyandex_mark_description: false,

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

			EDIT.ajax('/edit/block/contacts/delete', form, (data) => {
				if (data.answer == 'success') {
					EDIT.obj.parentNode.removeChild(EDIT.obj);
					DAN.modal.del()
					EDIT.status(true)
				}
			})
		}
	},


	fields(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/contacts/fields', form, (data) => {
			DAN.modal.add(data.content, 550)
			EDIT.block.initialize()

			// Сохраняем порядок только в том случае, если он изменён, для проверки заводим строку 'initial_str'
			let initial_arr = document.getElementsByClassName('e_block_modal_item')
			let contacts_initial_arr = []

			for (i = 0; i < initial_arr.length; i++) {
				contacts_initial_arr[i] = initial_arr[i].getAttribute('data-item-id')
			}

			let initial_str = contacts_initial_arr.join(' '); // Переводим в строку с разделителем ('2 22' != '22 2')

			let item_edit_arr = document.getElementsByClassName('e_block_modal_item_edit')
			let item_delete_arr = document.getElementsByClassName('e_block_modal_item_delete')

			for (i = 0; i < item_edit_arr.length; i++) {
				item_edit_arr[i].onclick = (e) => {
					EDIT.block.contacts.field_edit(e.target)
				}

				item_delete_arr[i].onclick = (e) => {
					EDIT.block.contacts.field_delete(e.target)
				}
			}

			// Отправить данные методом POST
			DAN.$('e_block_modal_send').onclick = () => {

				// Проверяем новый порядок и исходный, если совпадает - прерываем отправку
				let result_arr = document.getElementsByClassName('e_block_modal_item')
				let contacts_result_arr = []

				for (i = 0; i < result_arr.length; i++) {
					contacts_result_arr[i] = arr[i].getAttribute('data-item-id')
				}

				let result_str = contacts_result_arr.join(' ')

				if(result_str == initial_str){
					DAN.modal.del()
					return;
				}

				EDIT.block.contacts.contacts_ordering(id, contacts_result_arr)
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Добавить адрес
	field_add(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/contacts/field_add', form, (data) => {
			DAN.modal.add(data.content, 550)

			let type = DAN.$('e_modal_type')

			type.onchange = () => {
				let str_1 = ''
				let str_2 = ''

				if (type.value == 'address') str_1 = 'Адрес'
				if (type.value == 'phone') str_1 = 'Телефон'
				if (type.value == 'viber') str_1 = 'Viber'
				if (type.value == 'whatsapp') str_1 = 'WhatsApp'
				if (type.value == 'skype') str_1 = 'Skype'
				if (type.value == 'email') str_1 = 'Еmail'
				if (type.value == 'youtube') str_1 = 'Ссылка на канал YouTube'
				if (type.value == 'instagram') str_1 = 'Ссылка на Instagram'
				if (type.value == 'vk') str_1 = 'Ссылка на Vkontakte'
				if (type.value == 'fb') str_1 = 'Ссылка на Facebook'
				if (type.value == 'ok') str_1 = 'Ссылка на Одноклассники'
				if (type.value == 'html') str_1 = 'Html'
				if (type.value == 'code') str_1 = 'Код'
				if (type.value == 'mapyandex') str_1 = ''
				if (type.value == 'form') str_1 = 'Текст над формой'

				DAN.$('e_modal_str_1').innerHTML = str_1
				if (type.value == 'code') {
					DAN.$('e_modal_str_2').innerHTML = '<textarea id="e_modal_value" class="dan_input e_w_100" style="height:100px;"></textarea>'
				} else if(type.value == 'form') {
					DAN.$('e_modal_str_2').innerHTML = '<input id="e_modal_value" class="dan_input e_w_100" required value="Задать вопрос">'
				} else if(type.value == 'mapyandex') {
					if (DAN.$('block_contacts_mapyandex_' + id)) {
						DAN.$('e_modal_str_2').innerHTML = 'Карта уже добавлена в блок "Контакты"'
					} else {
						DAN.$('e_modal_str_2').innerHTML = 'После добавления, карта доступна для редактирования'
					}
				} else {
					DAN.$('e_modal_str_2').innerHTML = '<input id="e_modal_value" class="dan_input e_w_100" required>'
				}
			}

			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.contacts.field_update(id, '')
			}
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Удаляем поле
	field_delete(id){

		let num = EDIT.obj.getAttribute('data-item-num')

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('num', num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/contacts/field_delete', form, (data) => {})
	},


	// Редактировать поле
	field_edit(id){
		let field_num = EDIT.obj.getAttribute('data-item-num')
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('field_num', field_num)

		if (EDIT.obj.dataset.type != 'html') {
			// Для всех типов полей - выводим в модальном окне.
			EDIT.ajax('/edit/block/contacts/field_edit', form, (data) => {
				DAN.modal.add(data.content, 550)

				DAN.$('e_modal_submit').onclick = () => {
					EDIT.block.contacts.field_update(id, field_num)
				}
				DAN.$('e_modal_cancel').onclick = DAN.modal.del
			})
		} else {
			if (EDIT.obj.id == 'e_editor') {
				EDIT.editorDestroy()
				return
			}

			// Скрываем контрольную панель
			let cpanel = EDIT.obj.childNodes[0]
			cpanel.style.display = 'none'

			// Визуальный редактор
			EDIT.obj = EDIT.obj.childNodes[1]
			EDIT.content_old = EDIT.obj.innerHTML
			EDIT.editor()

			// При потере фокуса
			EDIT.ckeditor.on("blur", () => {
				let content_new = CKEDITOR.instances.e_editor.getData()

				EDIT.obj.parentNode.id = ''
				EDIT.editorDestroy()

				cpanel.style.display = 'flex'

				if(content_new != EDIT.content_old){				
					EDIT.block.contacts.field_update(id, field_num, content_new)
				}
			})
		}
	},


	// Очистить яндекскарту
	field_mapyandex_clear(id){
		EDIT.block.mapsyandex.clear()
	},


	// Яндекскарта - добавить точки
	field_mapyandex_mark_modal(){
		EDIT.block.mapsyandex.mark_modal()
	},


	// Сохраняем данные Яндекс карты
	field_mapyandex_save(id){
		let i = 0;
		let points_arr = [];

		EDIT.block.mapsyandex.map[id].myCollection.each((el) => {
			let point = {
				coordinates: el.geometry._coordinates,
				title: el.properties._data.balloonContentHeader,
				description: el.properties._data.balloonContentBody,
				link: el.properties._data.balloonContentLink
			}

			points_arr[i] = point;
			i++;
		});

		if (points_arr.length == 0) {
			alert('Не установлено ни одной точки на карте.\nКарта не сохранена!');
			return;
		}

		EDIT.block.mapsyandex.mark_off()

		let map_bounds_json = JSON.stringify(EDIT.block.mapsyandex.map[id]._bounds);
		let points_arr_json = JSON.stringify(points_arr);

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('map', map_bounds_json);
		form.append('zoom', EDIT.block.mapsyandex.map[id]._zoom);
		form.append('points', points_arr_json);

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/contacts/field_mapyandex_save', form, (data) => {
			EDIT.status(true)
			DAN.modal.add(data.content, 350, 100)
			DAN.$('e_modal_submit').onclick = DAN.modal.del
		})
	},


	// Порядок следования
	fields_ordering(r){
		let id = r.object_id
		let block_id = 'block_' + id
		let target = DAN.$(block_id)
		let arr = target.getElementsByClassName('e_block_item')

		let fields_arr = []

		for (i = 0; i < arr.length; i++) {
			fields_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('id', r.object_id)
		form.append('p', EDIT.p)
		form.append('fields', fields_arr)

		EDIT.ajax('/edit/block/contacts/fields_ordering', form, (data) => {
			EDIT.status(true)
		})
	},


	field_update(id, field_num=false, content_html=false){
		let type = DAN.$('e_modal_type') ? DAN.$('e_modal_type').value : false

		if (type == 'mapyandex' && DAN.$('block_contacts_mapyandex_' + id)) {
			alert('Карта уже добавлена ранее в блок "Контакты"')
			return
		}

		let value = DAN.$('e_modal_value') ? DAN.$('e_modal_value').value : ''
		content = content_html ? content_html : value			

		DAN.modal.spinner()

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		if (field_num) form.append('field_num', field_num)
		if (form) form.append('type', type)
		form.append('content', content)

		EDIT.ajax('/edit/block/contacts/field_update', form, (data) => {
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	// Выводит настройки в модальном окне
	settings(id, style=false){
		EDIT.block.contacts.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.contacts.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		if (style)
			form.append('style', style)

		EDIT.ajax('/edit/block/contacts/settings', form, (data) => {
			DAN.modal.add(data.content, 550)
			let style = data.style

			// --- ИНИЦИАЛИЗАЦИЯ НАСТРОЕК ---
			// Тип 1
			if (style == 1)
				EDIT.block.settings.init()

			// Тип 2
			if(style == 2){
				if (DAN.$('e_block_modal_container')) 
					EDIT.block.settings.container()

				let fog_opacity = DAN.$('e_block_modal_contacts_fog_opacity')

				fog_opacity.onmousemove = () => {
					DAN.$('e_block_modal_contacts_fog_opacity_out').innerHTML = fog_opacity.value
				}
			}
			// ___ инициализация ___

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.contacts.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()

		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file') ? DAN.$('e_block_modal_bg_image_file').files[0] : false
		let bg_image_size_1 = DAN.$('e_block_modal_bg_image_size_1') ? DAN.$('e_block_modal_bg_image_size_1') : false // cover
		let bg_image_size = '';
		let wrap_bg_check = DAN.$('e_block_modal_wrap_bg_color_check') && DAN.$('e_block_modal_wrap_bg_color_check').checked ? 1 : 0
		let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color') ? DAN.$('e_block_modal_wrap_bg_color').value : false
		let wrap_bg_opacity = DAN.$('e_block_modal_wrap_opacity') ? DAN.$('e_block_modal_wrap_opacity').value : false
		let max_width = DAN.$('e_block_modal_max_width') ? DAN.$('e_block_modal_max_width').value : false
		let margin = DAN.$('e_block_modal_margin') ? DAN.$('e_block_modal_margin').value : false
		let padding = DAN.$('e_block_modal_padding') ? DAN.$('e_block_modal_padding').value : false
		let font_select = DAN.$('e_block_modal_font_select') ? DAN.$('e_block_modal_font_select').value : false
		let font_size = DAN.$('e_block_modal_font_size') ? DAN.$('e_block_modal_font_size').value : false
		let line_height = DAN.$('e_block_modal_line_height') ? DAN.$('e_block_modal_line_height').value :false
		let color = DAN.$('e_block_modal_font_color').value
		let fog_color = DAN.$('e_block_modal_contacts_fog_color') ? DAN.$('e_block_modal_contacts_fog_color').value : false
		let fog_opacity = DAN.$('e_block_modal_contacts_fog_opacity') ? DAN.$('e_block_modal_contacts_fog_opacity').value : false
		let text_1_size = DAN.$('e_block_modal_contacts_text_1_size') ? DAN.$('e_block_modal_contacts_text_1_size').value : false
		let text_2_size = DAN.$('e_block_modal_contacts_text_2_size') ? DAN.$('e_block_modal_contacts_text_2_size').value : false

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
		if (bg_type) form.append('bg_type', bg_type)
		if (bg_type == 'i') form.append('bg_image', bg_image)
		if (bg_color) form.append('bg_color', bg_color)
		if (bg_image_size) form.append('bg_image_size', bg_image_size)
		if (wrap_bg_check) form.append('wrap_bg_check', wrap_bg_check)
		if (wrap_bg_color) form.append('wrap_bg_color', wrap_bg_color)
		if (wrap_bg_opacity) form.append('wrap_bg_opacity', wrap_bg_opacity)
		if (max_width) form.append('max_width', max_width)
		if (margin) form.append('margin', margin)
		if (padding) form.append('padding', padding)
		if (font_select) form.append('font_select', font_select)
		if (font_size) form.append('font_size', font_size)
		if (line_height) form.append('line_height', line_height)
		form.append('color', color)
		if (fog_color) form.append('fog_color', fog_color)
		if (fog_opacity) form.append('fog_opacity', fog_opacity)
		if (text_1_size) form.append('text_1_size', text_1_size)
		if (text_2_size) form.append('text_2_size', text_2_size)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/contacts/settings_update', form, (data) => {
			if (data.message){
				DAN.modal.add(data.message)
			}
		})
	}
}