if (typeof ADMIN == 'undefined') {
	ADMIN = {}
}

if (typeof ADMIN.poehali == 'undefined') {
	ADMIN.poehali = {}
}

window.addEventListener('DOMContentLoaded', function(){
	let e_editor_1 = CKEDITOR.replace("editor1", {
		height: "400px",
		filebrowserBrowseUrl : "/administrator/plugins/filemanager/index.php",
	});

	ADMIN.poehali.projects.init()

	let id = 'poehali_project_mapsyandex'
	let coordinate = [53.271893, 50.237382]
	let zoom = 8.47
	let points_arr = []
	ADMIN.poehali.mapsyandex.run(id, coordinate, zoom, points_arr, mark_type='islands#redBlue')
});


ADMIN.poehali.projects = {
	image_files: false,

	// Начальная инициализация
	init(){
		let contextmenu_blogers = [["#ADMIN.poehali.projects.blogers_delete", "dan_contextmenu_delete", "Удалить"]];
		DAN.contextmenu.add("poehali_blogers_list_wrap", contextmenu_blogers, "left");
		// DRAG_DROP()
		DAN.$('poehali_project_mapsyandex_button').onclick = ADMIN.poehali.mapsyandex.mark_add
		DAN.$('poehali_project_mapsyandex_set').onclick = ADMIN.poehali.mapsyandex.set
		DAN.$('poehali_project_mapsyandex_bloger_add').onclick = ADMIN.poehali.projects.get_blogers_list
	},

	// Получаем объект, поднимаясь по родительским элементам до тех пор, пока не совпадёт класс объекта
	get_obj(obj, target_class){
		while (obj) {
			if (obj.classList.contains(target_class)) 
				return obj;
			obj = obj.parentElement;
		}
		return false;
	},

	// Получить список блогеров на ajax
	get_blogers_list(){	
		let form = new FormData()
		// form.append('act', 'ajax')
		DAN.ajax('/admin/com/poehali/projects/blogers_list_ajax', form, function(data){
			let content = '<h1>Выбрать блогера</h1>'
			content += data.content
			DAN.modal.add(content)

			let blogers = document.getElementsByClassName('poehali_blogers_list_wrap')
			for (let i = 0; i < blogers.length; i++) {
				blogers[i].onclick = ADMIN.poehali.projects.set_bloger
			}
		})
	},

	// Помещает блогера в список и добавляет в input
	set_bloger(e){
		let project_id = DAN.$('poehali_project_form').dataset.project_id
		let bloger_id = this.dataset.id
		DAN.modal.del()

		let form = new FormData()
		form.append('project_id', project_id)
		form.append('bloger_id', bloger_id)

		DAN.ajax('/admin/com/poehali/projects/bloger_insert_ajax', form, function(data) {
			DAN.$('poehali_project_mapsyandex_blogers_list').insertAdjacentHTML('beforeend', data.content)
		})
	},

	blogers_delete(obj){
		let id = obj.dataset.id
		let form = new FormData()
		form.append('id', id)
		DAN.ajax('/admin/com/poehali/projects/bloger_delete_ajax', form, function(data) {
			obj.remove()
		})		
	},

	// Порядок следования
	ordering(e){
		console.log('ORDERING')
	}
}

ADMIN.poehali.mapsyandex = {
	map: [],
	id: false,  
	mark_action: false,  // Режим установки маркера

	// Выводим карту
	out(div_id, coordinate, zoom, points_arr = false, mark_type='islands#redBlue'){
		let id = DAN.$(div_id).dataset.id
		ADMIN.poehali.mapsyandex.id = id

		ADMIN.poehali.mapsyandex.map[id] = new ymaps.Map(div_id, {
			center: [coordinate[0], coordinate[1]],
			zoom: zoom
		});

		ADMIN.poehali.mapsyandex.map[id].behaviors.disable('scrollZoom')

		// Создание коллекции объектов
		ADMIN.poehali.mapsyandex.map[id].myCollection = new ymaps.GeoObjectCollection({}, {
			preset: mark_type, // Тип и цвет меток
			draggable: false // и их нельзя перемещать
		});

		// добавляем коллекцию на карту
		ADMIN.poehali.mapsyandex.map[id].geoObjects.add(ADMIN.poehali.mapsyandex.map[id].myCollection);

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
				} else {  // Тип метки без текста
					point =	new ymaps.Placemark(points_arr[i].coordinates, {
						balloonContentHeader: header,
						balloonContentBody: points_arr[i].description
					});					
				}

				ADMIN.poehali.mapsyandex.map[id].myCollection.add(point);
			}
		}
	},


	// Запускаем карту
	run(id, coordinate, zoom, points_arr, mark_type='islands#redBlue'){
		ymaps.ready(() => {
			let coordinates = DAN.$('poehali_project_mapsyandex_coordinates').value
			let title = DAN.$('poehali_project_name').value

			if (coordinates != '') {
				coordinates_arr = coordinates.split(',')
				if (coordinates_arr.length == 2) {
					let point = {
						coordinates: [parseFloat(coordinates_arr[0]), parseFloat(coordinates_arr[1])],
						title: title
					}

					points_arr.push(point)
				}				
			}
	
			ADMIN.poehali.mapsyandex.out(id, coordinate, zoom, points_arr, mark_type);
		});
	},


	mark_add(e){
		let id = ADMIN.poehali.mapsyandex.id
		ADMIN.poehali.mapsyandex.mark_title = DAN.$('poehali_project_name').value
		ADMIN.poehali.mapsyandex.mark_description = ''
		ADMIN.poehali.mapsyandex.mark_link = ''

		// DAN.modal.del();
		// e.stopPropagation();

		ADMIN.poehali.mapsyandex.mark_action = !ADMIN.poehali.mapsyandex.mark_action; // Тригер маркера режима установки метки
		let status = DAN.$('poehali_project_mapsyandex_status')
		let mark_add = DAN.$('poehali_project_mapsyandex_mark_add')

		status.style.display = 'block'
		mark_add.style.display = 'none'

		ADMIN.poehali.mapsyandex.map[id].myCollection.removeAll()
		ADMIN.poehali.mapsyandex.map[id].events.add('click', ADMIN.poehali.mapsyandex.mark)
	},


	// Установка метки по клику.
	mark(e){
		let id = ADMIN.poehali.mapsyandex.id
		ADMIN.poehali.mapsyandex.map[id].myCollection.options.set('draggable', true);
		let coords = e.get('coords');

		point =	new ymaps.Placemark([coords[0], coords[1]], {
			balloonContentHeader: ADMIN.poehali.mapsyandex.mark_title,
			balloonContentBody: ADMIN.poehali.mapsyandex.mark_description,
			balloonContentLink: ADMIN.poehali.mapsyandex.mark_link  // Собственное поле
		});

		ADMIN.poehali.mapsyandex.map[id].myCollection.add(point);
		ADMIN.poehali.mapsyandex.map[id].events.remove('click', ADMIN.poehali.mapsyandex.mark); // удаляем слушателя, что бы не было возможности ставить ещё точки
		ADMIN.poehali.mapsyandex.mark_action = false;
	},

	// Внесение данных в input поля
	set(){
		let id = ADMIN.poehali.mapsyandex.id
		ADMIN.poehali.mapsyandex.map[id].myCollection.options.set('draggable', false);

		let status = DAN.$('poehali_project_mapsyandex_status')
		let mark_add = DAN.$('poehali_project_mapsyandex_mark_add')

		status.style.display = 'none'
		mark_add.style.display = 'flex'

		let i = 0;
		let points_arr = [];
		ADMIN.poehali.mapsyandex.map[id].myCollection.each((el) => {
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

		let points_arr_json = JSON.stringify(points_arr);
		let coordinates = points_arr[0].coordinates

		DAN.$('poehali_project_mapsyandex_coordinates').value = coordinates
	}
}