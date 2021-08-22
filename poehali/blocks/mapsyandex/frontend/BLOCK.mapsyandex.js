BLOCK.mapsyandex = {
	map: [],

	// Выводим карту
	out(div_id, coordinate, zoom, points_arr = false, mark_type='islands#redBlue'){
		let id = DAN.$(div_id).dataset.id

		BLOCK.mapsyandex.map[id] = new ymaps.Map(div_id, {
			center: [coordinate[0], coordinate[1]],
			zoom: zoom
		});

		BLOCK.mapsyandex.map[id].behaviors.disable('scrollZoom')

		// Создание коллекции объектов
		BLOCK.mapsyandex.map[id].myCollection = new ymaps.GeoObjectCollection({}, {
			preset: mark_type, // Тип и цвет меток
			draggable: true // и их можно перемещать
		});

		// добавляем коллекцию на карту
		BLOCK.mapsyandex.map[id].geoObjects.add(BLOCK.mapsyandex.map[id].myCollection);

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

				BLOCK.mapsyandex.map[id].myCollection.add(point);
			}
		}
	},


	// Запускаем карту
	run(id, coordinate, zoom, points_arr, mark_type='islands#redBlue'){
		ymaps.ready(() => {
			BLOCK.mapsyandex.out(id, coordinate, zoom, points_arr, mark_type);
		});
	},
}