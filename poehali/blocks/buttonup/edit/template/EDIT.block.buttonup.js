EDIT.block.buttonup = {
	container_style: '',

	del(id){
		let content =
		'<div class="e_modal_title">Удалить кнопку</div>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
		'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = () => {
			let form = new FormData()
			form.append('id', id)

			EDIT.ajax('/edit/block/buttonup/delete', form, (data) => {
				if (data.answer == 'success') {
					EDIT.obj.parentNode.removeChild(EDIT.obj)
					DAN.modal.del()
					EDIT.status(true)
				}
			})
		}
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.obj = DAN.$('block_buttonup')
		EDIT.block.buttonup.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.buttonup.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')
		// EDIT.block.buttonup.h2_old = EDIT.obj.getElementsByTagName('h2')[0].getAttribute('style')

		let form = new FormData()
		form.append('id', id)

		EDIT.ajax('/edit/block/buttonup/settings', form, (data) => {
			DAN.modal.add(data.content, 550)

			let b = DAN.$('block_buttonup')
			let b_svg = DAN.$('block_buttonup_container_' + id).childNodes[0]
			
			let size = DAN.$('e_block_modal_buttonup_size')
			let size_out = DAN.$('e_block_modal_buttonup_size_out')
			let bottom = DAN.$('e_block_modal_buttonup_bottom')
			let bottom_out = DAN.$('e_block_modal_buttonup_bottom_out')
			let left = DAN.$('e_block_modal_buttonup_left')
			let left_out = DAN.$('e_block_modal_buttonup_left_out')
			let color = DAN.$('e_block_modal_buttonup_color')

			size.onmousemove = () => {
				size_out.innerHTML = size.value
				b.style.width = size.value + 'px';
				b.style.height = size.value + 'px';
				b_svg.style.width = size.value / 2 + 'px';
				b_svg.style.height = size.value / 2 + 'px';
				b_svg.style.marginTop = '-' + size.value / 20 + 'px';
			}

			bottom.onmousemove = () => {			
				bottom_out.innerHTML = bottom.value
				b.style.bottom = bottom.value + 'px';
			}

			left.onmousemove = () => {
				left_out.innerHTML = left.value
				b.style.left = left.value + 'px';
			}

			color.oninput = () => {
				b.style.backgroundColor = color.value;
			}				
			
			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.buttonup.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()
		
		let size = DAN.$('e_block_modal_buttonup_size').value
		let bottom = DAN.$('e_block_modal_buttonup_bottom').value
		let left = DAN.$('e_block_modal_buttonup_left').value
		let color = DAN.$('e_block_modal_buttonup_color').value

		form.append('id', id)
		form.append('size', size)
		form.append('bottom', bottom)
		form.append('left', left)
		form.append('color', color)

		EDIT.ajax('/edit/block/buttonup/settings_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			document.location.href = '/' + EDIT.url
		})
	},
}