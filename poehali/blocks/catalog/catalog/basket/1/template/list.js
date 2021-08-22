if (!BLOCK) {
	BLOCK = {}
}

if (!BLOCK.catalog) {
	BLOCK.catalog = {}
}

window.addEventListener('DOMContentLoaded', function(){
	BLOCK.catalog.basket.init()
});

BLOCK.catalog.basket = {
	init() {
		let basket_1_button =  DAN.$('block_catalog_basket_1_button')
		if (!basket_1_button)
			return

		let catalog_url = basket_1_button.dataset.cu

		// Удалить товар
		let del_arr = document.getElementsByClassName('block_catalog_basket_1_delete');
		for (var i = 0; i < del_arr.length; i++) {
			del_arr[i].onclick = (e) => {
				let id = e.target.dataset.id
				let hash = e.target.dataset.hash
				DAN.$('block_catalog_basket_1_item_' + id).remove()

				if (DAN.$('block_menu_basket_item_' + id))
					DAN.$('block_menu_basket_item_' + id).remove()

				let form = new FormData()
				form.append('hash', hash)
				form.append('id', id)

				DAN.ajax('/' + catalog_url + '/basket/delete', form, function(data) {
					console.log(data)
					BLOCK.catalog.basket.calculate()
				})
			}
		}

		// Инпуты количество
		let quantity_arr = document.getElementsByClassName('block_catalog_basket_1_item_quantity') 
		for (var i = 0; i < quantity_arr.length; i++) {
			quantity_arr[i].oninput = BLOCK.catalog.basket.calculate
		}

		// Минус количество
		let minus = document.getElementsByClassName('block_catalog_basket_1_item_quantity_minus')
		let plus = document.getElementsByClassName('block_catalog_basket_1_item_quantity_plus')

		for (var i = 0; i < minus.length; i++) {
			minus[i].onclick = (e) => {
				e.target.nextElementSibling.stepDown()
				BLOCK.catalog.basket.calculate()
			}

			plus[i].onclick = (e) => {
				e.target.previousElementSibling.stepUp()
				BLOCK.catalog.basket.calculate()
			}
		}

		let coupons_cod_button = DAN.$('block_catalog_basket_1_coupons_buttton')
		if (coupons_cod_button)
			coupons_cod_button.onclick = BLOCK.catalog.basket.coupons
	},

	coupons(e) {
		let cod = DAN.$('block_catalog_basket_1_coupons_cod').value
		if (cod.length < 4) {
			alert('Слишком короткий код')
			return
		}

		let form = new FormData()
		form.append('cod', cod)		

		let catalog_url = DAN.$('block_catalog_basket_1_button').dataset.cu
		DAN.ajax('/' + catalog_url + '/basket/get_coupon_ajax', form, function(data){
			console.log(data)
			if (data.message != '') {
				DAN.$('block_catalog_basket_1_coupons_discount_wrap').innerHTML = ''
				DAN.$('block_catalog_basket_1_coupons_sum_wrap').innerHTML = ''
				alert(data.message)
				return
			} else {
				DAN.$('block_catalog_basket_1_coupons_discount_wrap').innerHTML = 'Скидка <span id="block_catalog_basket_1_coupons_discount">' + data.discount + '</span> %'
				let sum = DAN.$('block_catalog_basket_1_sum').innerHTML.replace(' ', '')
				let sum_itogo = parseFloat(sum) * (100 - data.discount)/100
				let currency = DAN.$('block_catalog_basket_1_sum_currency').innerHTML
				DAN.$('block_catalog_basket_1_coupons_sum_wrap').innerHTML = 
					'Итого, со скидкой: <span id="block_catalog_basket_1_coupons_sum">' + sum_itogo + '</span>' + 
					'<span class="block_catalog_basket_1_coupons_sum_currency">' + currency + '</span>'
			}
		})
	},

	calculate() {
		let sum = 0
		let container = document.getElementsByClassName('block_catalog_basket_1_item_container') 
		for (var i = 0; i < container.length; i++) {
			let input_node = container[i].getElementsByClassName('block_catalog_basket_1_item_quantity')[0]
			let quantity = parseFloat(input_node.value)
			let price = parseFloat(input_node.dataset.price)
			let sum_node = container[i].getElementsByClassName('block_catalog_basket_1_item_sum')[0]
			let sum_item = quantity * price;
			sum_node.innerHTML = sum_item;
			sum += sum_item
		}

		document.getElementById('block_catalog_basket_1_sum').innerHTML = sum

		let discount = DAN.$('block_catalog_basket_1_coupons_discount')
		if (discount) {
			let discount_value = parseFloat(discount.innerHTML)

			let sum_itogo = sum * (100 - discount_value) / 100
			DAN.$('block_catalog_basket_1_coupons_sum').innerHTML = sum_itogo
		}
	}
}