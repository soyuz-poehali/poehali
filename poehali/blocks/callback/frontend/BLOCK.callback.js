BLOCK.callback = {
	form(id){
		let block_calltoorder_form = 
			'<div id="block_calltoorder_title">Заказать обратный звонок</div><br><br>' + 
			'<div>' + 
				'<div class="block_calltoorder_text">Ваше имя <span style="color:#FF0000;">*</span></div>' + 
				'<input id="block_calltoorder_form_name" class="dan_input" type="text" value="" name="name" required=""><br><br>' + 
				'<div class="block_calltoorder_text">Телефон <span style="color:#FF0000;">*</span></div>' + 
				'<input id="block_calltoorder_form_phone" class="dan_input" type="text" value="" name="phone" required="" pattern="[0-9\+\-\(\)\s]{7,15}" ><br><br>' +
			'</div>' + 
			'<div class="mod_calltoorder_p_i">' + 
				'<input id="block_calltoorder_form_check" required="" checked="" title="Вы должны дать согласие перед отправкой" type="checkbox">' + 
				'Я согласен на <a href="/personal_information" target="_blank">обработку персональных данных</a>' + 
			'</div><br><br>' + 
			'<div class="calltoorder_submit"><input id="mod_calltoorder_form_submit" class="dan_button_green" type="button" value="Заказать" name="button"></div>';		
			
		DAN.modal.add(block_calltoorder_form, 450)
		
		DAN.$('mod_calltoorder_form_submit').onclick = () => {
			let name = DAN.$('block_calltoorder_form_name').value
			let phone = DAN.$('block_calltoorder_form_phone').value
			let check = DAN.$('block_calltoorder_form_check').checked

			if (name == '') {
				alert('Не заполнено поле "Ваше имя"')
				return
			}
			
			if (phone == '') {
				alert('Не заполнено поле "Телефон"')
				return
			}

			if (!check) {
				alert('Вы должны дать согласие на обработку персональных данных')
				return
			}

			let req = new XMLHttpRequest()
			let form = new FormData()
			form.append('id', id)
			form.append('name', name)
			form.append('phone', phone)
			form.append('submit', 'Заказать')
			req.open('post', '/block/callback', true);
			req.send(form)

			req.onreadystatechange = () => {
				if(req.readyState == 4 && req.status == 200){
					console.log(req.responseText);
					var data = JSON.parse(req.responseText)
					if (data.answer == 'success'){
						DAN.modal.add('Ваше сообщение отправлено!')
					}
				}
			}
		}
	}
}

