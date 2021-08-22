EDIT.block.mapsyandex = {
	container_style_old: '',
	height_old: '',
	map: [],
	mark_action: false, // Тригер маркера режима установки метки
	mark_title: false,
	mark_description: false,


	// Очистить карту
	clear(){
		let id = EDIT.obj.dataset.id
		if(typeof EDIT.block.mapsyandex.map[id].myCollection != "undefined") EDIT.block.mapsyandex.map[id].myCollection.removeAll();

		EDIT.block.mapsyandex.mark_off()
		EDIT.block.mapsyandex.map[id].events.remove('click', EDIT.block.mapsyandex.mark); // Не слушаем карту
		document.body.removeEventListener('click', EDIT.block.mapsyandex.mark_off);
		EDIT.block.mapsyandex.mark_action = false; // Тригер маркера режима установки метки
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

			EDIT.ajax('/edit/block/mapsyandex/delete', form, (data) => {
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	// Установка метки по клику.
	mark(e){
		let id = EDIT.obj.dataset.id
		EDIT.block.mapsyandex.map[id].myCollection.options.set('draggable', true);
		let coords = e.get('coords');

		point =	new ymaps.Placemark([coords[0], coords[1]], {
			balloonContentHeader: EDIT.block.mapsyandex.mark_title,
			balloonContentBody: EDIT.block.mapsyandex.mark_description,
			balloonContentLink: EDIT.block.mapsyandex.mark_link  // Собственное поле
		});

		EDIT.block.mapsyandex.map[id].myCollection.add(point);
		EDIT.block.mapsyandex.map[id].events.remove('click', EDIT.block.mapsyandex.mark); // удаляем слушателя, что бы не было возможности ставить ещё точки

		EDIT.block.mapsyandex.mark_action = false;
	},


	mark_add(e){
		EDIT.block.mapsyandex.mark_title = DAN.$('e_block_modal_mark_title').value
		EDIT.block.mapsyandex.mark_description = DAN.$('e_block_modal_mark_description').value
		EDIT.block.mapsyandex.mark_link = DAN.$('e_block_modal_mark_link').value

		DAN.modal.del();
		e.stopPropagation();

		EDIT.block.mapsyandex.mark_action = !EDIT.block.mapsyandex.mark_action; // Тригер маркера режима установки метки

		if (EDIT.block.mapsyandex.mark_action) {
			document.body.addEventListener('click', EDIT.block.mapsyandex.mark_off)
			EDIT.status_line('Режим установки метки на карте')
			let id = EDIT.obj.dataset.id
			EDIT.block.mapsyandex.map[id].events.add('click', EDIT.block.mapsyandex.mark)
		} else {
			EDIT.block.mapsyandex.mark_off()
		}
	},


	// Вызов модального окна метки
	mark_modal(e){
		// Выводим модальное окно с названием и описанием метки
		var modal_content =
		'<h2>Установить метку на карту</h2>' +
		'<div><input id="e_block_modal_mark_title" class="dan_input" style="width:100%;" value="" placeholder="Название метки"></div>' +
		'<div><textarea id="e_block_modal_mark_description" class="dan_input" style="width:100%;" placeholder="Описание метки"></textarea></div>' +
		'<div><input id="e_block_modal_mark_link" class="dan_input" style="width:100%;" value="" placeholder="Ссылка"></div>' +
		'<div style="margin-bottom:20px;">После нажатия кнопки <b>&quot;Поставить&quot;</b> кликните мышкой на карте в то место, куда хотите поставить метку</div>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Установить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
		'</div>'	

		DAN.modal.add(modal_content, 600);
		DAN.$('e_modal_submit').onclick = EDIT.block.mapsyandex.mark_add;
		DAN.$('e_modal_cancel').onclick = EDIT.block.mapsyandex.mark_off;
	},


	mark_off(e){
		DAN.modal.del()
		let id = EDIT.obj.dataset.id

		// Если существует событие клика - при клике в области карты - прерываем выключение - return;
		if (e){
			var target = e.target;
			while (target != document.body) {
				if (target == DAN.$('block_mapsyandex_' + id)) return; // Для блока Яндекс - карты
				if (target == DAN.$('block_contacts_mapyandex_' + id)) return; // Для блока Контакты
				if(target.parentNode) target = target.parentNode; // Родитель может не существовать в закрытии модального окна.
					else return;
			}
		}

		if(typeof EDIT.block.mapsyandex.map[id].myCollection != "undefined") EDIT.block.mapsyandex.map[id].myCollection.options.set('draggable', false);
		EDIT.block.mapsyandex.map[id].events.remove('click', EDIT.block.mapsyandex.mark); // Не слушаем карту
		document.body.removeEventListener('click', EDIT.block.mapsyandex.mark_off);
		EDIT.block.mapsyandex.mark_action = false; // Тригер маркера режима установки метки
		EDIT.status_line('off')
	},


	// Выводим карту
	out(div_id, coordinate, zoom, points_arr = false, mark_type='islands#redBlue'){
		EDIT.block.mapsyandex.mark_action = false; // Маркер режима установки метки
		EDIT.block.mapsyandex.mark_title = false // Название метки
		EDIT.block.mapsyandex.mark_description = false; // Описание метки
		EDIT.block.mapsyandex.mark_link = false // Ссылка

		let id = DAN.$(div_id).parentNode.dataset.id // Пример: div_id -> block_mapsyandex_576; id -> 576
		EDIT.block.mapsyandex.map[id] = new ymaps.Map(div_id, {
			center: [coordinate[0], coordinate[1]],
			zoom: zoom
		});

		// Создание коллекции объектов
		EDIT.block.mapsyandex.map[id].myCollection = new ymaps.GeoObjectCollection({}, {
			preset: mark_type, // Тип и цвет меток
			draggable: true  // и их можно перемещать
		});

		// добавляем коллекцию на карту
		EDIT.block.mapsyandex.map[id].geoObjects.add(EDIT.block.mapsyandex.map[id].myCollection);

		if (points_arr && points_arr.length > 0) {
			// Добавляем точки на карту
			for (var i = 0; i < points_arr.length; i++) {
				let header = points_arr[i].title  // Значение по умолчанию
				if (points_arr[i].link)
					header = '<a href="' + points_arr[i].link + '" target="blank">' + points_arr[i].title + '</a>'
					
				if (mark_type.indexOf('Stretchy') > 0) {  // Тип метки с текстом
					point =	new ymaps.Placemark(points_arr[i].coordinates, {
						iconContent: points_arr[i].title,
						balloonContentHeader: header,
						balloonContentBody: points_arr[i].description
					});	
				} else{  // Тип метки без текста
					point =	new ymaps.Placemark(points_arr[i].coordinates, {
						balloonContentHeader: header,
						balloonContentBody: points_arr[i].description
					});					
				}

				EDIT.block.mapsyandex.map[id].myCollection.add(point);
			}
		}
	},


	// Запускаем карту
	run(id, coordinate, zoom, points_arr, mark_type='islands#redBlue'){
		ymaps.ready(() => {
			EDIT.block.mapsyandex.out(id, coordinate, zoom, points_arr, mark_type);
		});
	},


	save(){
		let i = 0;
		let id = EDIT.obj.dataset.id
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

		EDIT.ajax('/edit/block/mapsyandex/save', form, (data) => {
			EDIT.status(true)
			DAN.modal.add(data.content, 350, 100)
			DAN.$('e_modal_submit').onclick = DAN.modal.del
		})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.mapsyandex.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.mapsyandex.height_old = DAN.$('block_mapsyandex_' + id).style.height;

		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/mapsyandex/settings_edit', form, (data) => {
			DAN.modal.add(data.content, 550)

			// --- ИНИЦИАЛИЗАЦИЯ НАСТРОЕК ---
			if(DAN.$('e_block_modal_container')) EDIT.block.settings.container()

			let height = DAN.$('e_block_modal_mapsyandex_height')
			let height_out = DAN.$('e_block_modal_mapsyandex_height_out')

			height.onmousemove = () => {
				height_out.innerHTML = height.value
				let b_id = 'block_mapsyandex_' + id
				DAN.$(b_id).style.height = height.value + 'px';
				DAN.$(b_id).childNodes[0].style.height = height.value + 'px';
				DAN.$(b_id).childNodes[0].childNodes[0].style.height = height.value + 'px';
			}

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

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.mapsyandex.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = () => {
				DAN.modal.del()
				EDIT.block.mapsyandex.style_reset(id)
			}
		})
	},


	settings_update(id){
		let form = new FormData()
		let max_width = DAN.$('e_block_modal_max_width').value
		let height = DAN.$('e_block_modal_mapsyandex_height').value
		let margin = DAN.$('e_block_modal_margin').value
		let bg_type = DAN.$('e_block_modal_bg_type') ? DAN.$('e_block_modal_bg_type').value : false
		let bg_color = DAN.$('e_block_modal_container_bg_color_input') ? DAN.$('e_block_modal_container_bg_color_input').value : false
		let bg_image = DAN.$('e_block_modal_bg_image_file') ? DAN.$('e_block_modal_bg_image_file').files[0] : false
		let bg_image_size = DAN.$('e_block_modal_bg_image_size_1').checked ? 'cover' : 'repeat';
		// Тип метки
		let mark_type = 'islands#redBlue'  // Значение по умолчанию
		var inp = document.getElementsByName('e_block_modal_mapsyandex_points');
	    for (var i = 0; i < inp.length; i++) {
	        if (inp[i].type == "radio" && inp[i].checked) {
	            mark_type = inp[i].value
	        }
	    }

		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('max_width', max_width)
		form.append('height', height)
		form.append('margin', margin)
		form.append('mark_type', mark_type)
		if (bg_type) 
			form.append('bg_type', bg_type)
		if (bg_type == 'i') 
			form.append('bg_image', bg_image)
		if (bg_color) 
			form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/mapsyandex/settings_update', form, function(data){})
	},


	// Возвращает стили объекта
	style_reset(id){
		EDIT.obj.style = EDIT.block.mapsyandex.container_style_old
		let b_id = 'block_mapsyandex_' + id
		DAN.$(b_id).style.height = EDIT.block.mapsyandex.height_old
		DAN.$(b_id).childNodes[0].style.height = EDIT.block.mapsyandex.height_old
		DAN.$(b_id).childNodes[0].childNodes[0].style.height = EDIT.block.mapsyandex.height_old
	},
}