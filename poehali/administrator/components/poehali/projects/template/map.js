/*
window.addEventListener('DOMContentLoaded', function(){
	let id = 'poehali_project_mapsyandex'
	let coordinate = [53.271893, 50.237382]
	let zoom = 8.47
	// let points_arr = []
	ADMIN.poehali.mapsyandex.run(id, coordinate, zoom, points_arr, mark_type='islands#redBlue')
});
*/

if (typeof ADMIN == 'undefined') {
	ADMIN = {}
}

if (typeof ADMIN.poehali == 'undefined') {
	ADMIN.poehali = {}
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
			ADMIN.poehali.mapsyandex.out(id, coordinate, zoom, points_arr, mark_type);
		});
	}
}