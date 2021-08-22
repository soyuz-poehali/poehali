window.addEventListener('DOMContentLoaded', function(){
	if (DAN.$('block_menu_top_ico')) {
		menu_top()
		BLOCK.menu.init()
	}
})


BLOCK.menu = {
	shop_buy_fly_container: false,
	shop_buy_fly_timer_id: false,
	shop_buy_fly_opacity: 0,

	init() {
		let buy_button = DAN.$('block_catalog_item_button')

		// Корзина в блоке "Меню"
		let basket_button = DAN.$('block_menu_basket')
		if (basket_button) {
			basket_button.onclick = BLOCK.menu.basketList
		}

		// Кнопка "Купить" у товара
		if (buy_button)
			buy_button.onclick = BLOCK.menu.basketBuyFly
	},


	// Получаем данные методом ajax и обновляем корзину без вывода заказа
	basketUpdate() {
		let catalog_url = DAN.$('block_menu_basket').dataset.cu

		let form = new FormData()
		DAN.ajax('/' + catalog_url + '/basket/get_list_ajax', form, function(data) {
			let round = DAN.$('block_menu_basket_round')
			round.innerHTML = data.quantity
			round.style.display = 'block'
			let sum_container = DAN.$('block_menu_basket_sum_container')
			sum_container.style.display = 'block'
			let sum = DAN.$('block_menu_basket_sum')
			sum.innerHTML = data.sum_html
		})
	},


	// Выводит / скрывает выпадающий список корзины, делает перерасчёт
	basketList() {
		let catalog_url = DAN.$('block_menu_basket').dataset.cu

		let form = new FormData()
		DAN.ajax('/' + catalog_url + '/basket/get_list_ajax', form, function(data) {
			DAN.popup.out(DAN.$('block_menu_basket'), data.html)
			let basket_delete = document.getElementsByClassName('block_menu_basket_delete')

			for (var i = 0; i < basket_delete.length; i++) {
				basket_delete[i].onclick = (e) => {
					BLOCK.menu.basketDelete(e)
				}
			}
		})
	},


	// Удаляет товар из списка
	basketDelete(e) {
		let catalog_url = DAN.$('block_menu_basket').dataset.cu
		let hash = DAN.$('block_menu_basket').dataset.hash
		let item = e.target
		let id = item.dataset.id
		let parent = item.parentNode.parentNode

		let form = new FormData()
		form.append('hash', hash)
		form.append('id', id)
		DAN.ajax('/' + catalog_url + '/basket/delete', form, function(data) {
			document.location.href = document.location.href
			parent.remove()
			if (DAN.$('block_catalog_basket_1_item_' + id))
				DAN.$('block_catalog_basket_1_item_' + id).remove()
		})
	},


	// Кнопка "Купить" у товара
	basketBuyFly(e) {
		let item_id = e.target.dataset.item_id
		let image_id = e.target.dataset.image_id

		// Если объект ещё не создан - создаём
		if (clone_img == null)
			var clone_img = new Object();

		// Допускаем множество одновременно летящих товаров
		let rnd = Math.floor(Math.random()*1000000);
		clone_img[rnd] = {
			node: new Object()
		}

		// Находим позицию изображения 
		let image_pos = BLOCK.menu.getElementPosition(DAN.$(image_id))
		let image_p = DAN.$(image_id).getBoundingClientRect()
		image_pos.width = image_p.width
		image_pos.height = image_p.height

		clone_img[rnd].node = DAN.$(image_id).cloneNode(true)

		clone_img[rnd].node.id = '';
		clone_img[rnd].node.style.position = 'absolute';
		clone_img[rnd].node.style.zIndex = '1100';
		clone_img[rnd].node.style.width = image_pos.width + 'px';
		clone_img[rnd].node.style.height = image_pos.height + 'px';
		clone_img[rnd].node.style.top = image_pos.top + 'px';
		clone_img[rnd].node.style.left = image_pos.left + 'px';

	    document.body.insertAdjacentElement('afterbegin', clone_img[rnd].node)

		// Корзина
		let basket = DAN.$('block_menu_basket')
		if (basket === null)
			return;

		basket_pos = BLOCK.menu.getElementPosition(basket)

		// Расстояние между изображением товара и корзиной
		let delta_top = image_pos.top - basket_pos.top
		let delta_left = image_pos.left - basket_pos.left
		let delta_width = image_pos.width - 50  // Итоговая картинка шириной 50 пикселей.
		let delta_height = image_pos.height - (50*image_pos.height/image_pos.width)

		let i = 0;
		function moveItem(fraction) {
			requestAnimationFrame(function move_item(fraction) {
				clone_img[rnd].node.style.top = Math.floor(image_pos.top - i*(delta_top)/50) + 'px';
				clone_img[rnd].node.style.left = Math.floor(image_pos.left - i*(delta_left)/50) + 'px';
				clone_img[rnd].node.style.width = Math.floor(image_pos.width - i*(delta_width)/50) + 'px';
				clone_img[rnd].node.style.height = Math.floor(image_pos.height - i*(delta_height)/50) + 'px';
				clone_img[rnd].node.style.opacity = (50 - i*0.5)/50;
				i++;

				if (i <= 50)
					requestAnimationFrame(move_item);
				else {
					document.body.removeChild(clone_img[rnd].node);
					delete clone_img[rnd];
					BLOCK.menu.basketAddItem(item_id)
				}
			});
		}

		moveItem()
	},


	// Добавить товар в корзину
	basketAddItem(item_id) {
		let catalog_url = DAN.$('block_menu_basket').dataset.cu
		let container = DAN.$('block_catalog_item_container')

		let form = new FormData()
		form.append('item_id', item_id)	

		let selects = container.getElementsByTagName('select')
		for (var i = 0; i < selects.length; i++) {
			let name = selects[i].name
			let value = selects[i].value
			form.append(name, value)				
		}

		DAN.ajax('/' + catalog_url + '/basket/add_item_ajax', form, function(data){
			BLOCK.menu.basketUpdate()
		})
	},


	// Находит позицию объекта, поднимаясь по дереву DOM
	getElementPosition(elem) {
		if(elem === null)
			return null;

		var w = elem.offsetWidth;
		var h = elem.offsetHeight;

		var l = 0;
		var t = 0;

		while (elem) {
			l += elem.offsetLeft;
			t += elem.offsetTop;
			elem = elem.offsetParent;
		}

		return {"left":l, "top":t, "width": w, "height":h};
	}
}


function menu_top() {
	let ico = DAN.$('block_menu_top_ico')
	let wrap_1 = document.getElementsByClassName('block_menu_top_1_wrap')[0]
	let level_1 = document.getElementsByClassName('block_menu_top_1_a')
	let level_2 = document.getElementsByClassName('block_menu_top_2_a')

	ico.onclick = menu_toggle

	// Переключает состояние меню
	function menu_toggle(event) {
		event.stopPropagation()

		// Первый уровень меню - пункты
		for (var i = 0; i < level_1.length; i++) {
			level_1[i].onclick = submenu_2
		}

		// Второй уровень меню - пункты
		for (var i = 0; i < level_2.length; i++) {
			level_2[i].onclick = submenu_3
		}		
	
		// Разворачиваем меню
		if (!ico.classList.contains('open')) {
			ico.classList.add('open')
	    	wrap_1.classList.add('open')
		} else {  // Сворачиваем меню
			menu_close()  		
		}
	}


	// Раскрывает подменю 2 уровня
	function submenu_2(event){
		// В мобильной версии onclick на меню не действует, т.к. перехватывается этой функцией
		if (this.hasAttribute('onclick')) {
			let on_click = this.getAttribute('onclick')

			let r = on_click.replace("DAN.jumpTo('", '')
			let block_id = r.replace("')", '')

			DAN.jumpTo(block_id)
			menu_close()			
		}

		let wrap_next = this.nextSibling
		if(!wrap_next) return // Если не существует вложенного меню - прерываем функцию

		event.preventDefault()
		event.stopPropagation()

		wrap_next.classList.toggle('open')
		wrap_next.onclick = back_submenu_2 // При нажатие на обёртку - сворачиваем этот уровень меню
	}


	// Возврат из подменю 2 уровня
	function back_submenu_2(){
		let wrap_current = this;

		wrap_current.classList.remove('open')
		wrap_1.classList.add('open')	
	}


	// Раскрывает подменю 3 уровня
	function submenu_3(event){
		let wrap_next = this.nextSibling
		if(!wrap_next) return // Если не существует вложенного меню - прерываем функцию

		if(this.hasAttribute('onclick')){
			let on_click = this.getAttribute('onclick')

			let r = on_click.replace("DAN.jumpTo('", '')
			let block_id = r.replace("')", '')

			DAN.jumpTo(block_id)
			menu_close()			
		}

		event.preventDefault()
		event.stopPropagation()

		wrap_next.classList.toggle('open')
		wrap_next.onclick = back_submenu_3 // При нажатие на обёртку - сворачиваем этот уровень меню
	}


	// Возврат из подменю 3 уровня
	function back_submenu_3(event){
		event.stopPropagation()

		let wrap_current = this;
		wrap_current.classList.remove('open')
	}


	// Закрывает меню
	function menu_close() {
		ico.classList.remove('open')
    	wrap_1.classList.remove('open')

    	let wrap_2 = document.getElementsByClassName('block_menu_top_2_wrap open')
    	let wrap_3 = document.getElementsByClassName('block_menu_top_3_wrap open')

		for (let i = 0; i < wrap_2.length; i++) {
			wrap_2[i].classList.remove('open')
		}

		for (let i = 0; i < wrap_3.length; i++) {
			wrap_3[i].classList.remove('open')
		}
	}
}
