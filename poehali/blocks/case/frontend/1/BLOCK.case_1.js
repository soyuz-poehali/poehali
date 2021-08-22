BLOCK.case_1 = {
	form: function(block_id, button_text){
		console.log('FORM')
		let content =
			'<div id="block_case_form_modal" class="dan_2_modal_content_center_mobile">' +
				'<h2>' + button_text + '</h2>' +
				'<div>Ваш вопрос: <span style="color:#FF0000;">*</span></div>' +
				'<div class="block_case_form_modal_wrap"><textarea id="block_case_form_modal_textarea" class="input" name="question"></textarea></div>' + 
				'<div class="block_case_form_modal_text">Телефон <span style="color:#FF0000;">*</span></div>' +
				'<div class="block_case_form_modal_wrap">' +
					'<input id="block_case_form_modal_phone_input" class="input" type="text" value="" name="phone" required="" pattern="[0-9+-()]{7,15}">' +
				'</div>' + 
				'<div class="block_case_form_modal_wrap personal_information"><input id="block_case_form_modal_check" required="" checked="" title="Вы должны дать согласие перед отправкой" type="checkbox">Я согласен на <a href="/personal-information" target="_blank">обработку персональных данных</a></div>' +
				'<div><input id="block_case_form_modal_button" class="button_green" name="submit" type="submit" value="Отправить"></div>' +
			'</div>'

		DAN.modal.add(content, 450)

		DAN.$('block_case_form_modal_button').onclick = function(){
			BLOCK.case_1.form_send(block_id)
		}
	},

	form_send: function(block_id){
		let form_modal = DAN.$('block_case_form_modal')
		let form_check = DAN.$('block_case_form_modal_check')
		let question = DAN.$('block_case_form_modal_textarea')
		let phone = DAN.$('block_case_form_modal_phone_input')

		if(!form_check.checked){
			alert('Вы должны дать согласие перед отправкой')
			return
		}
		if(!phone.checkValidity() || phone.value.length < 7 || phone.value.length > 20){
			alert('Заполните поле "Телефон"')
			return
		}

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('id', block_id)
		form.append('question', question.value)
		form.append('phone', phone.value)

		DAN.ajax('/block/case/form_send', form, function(data){
			DAN.modal.add('Ваше сообщение отправлено!')
		})		
	}
}