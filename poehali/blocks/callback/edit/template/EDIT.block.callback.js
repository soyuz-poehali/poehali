EDIT.block.callback = {
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

			EDIT.ajax('/edit/block/callback/delete', form, (data) => {
				if (data.answer == 'success') {
					EDIT.obj.parentNode.removeChild(EDIT.obj);
					DAN.modal.del()
					EDIT.status(true)
				}
			})
		}
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.callback.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.callback.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let form = new FormData()
		form.append('id', id)

		EDIT.ajax('/edit/block/callback/settings', form, (data) => {
			DAN.modal.add(data.content, 550)

			let b = DAN.$('block_' + id)
	
			let size = DAN.$('e_block_modal_callback_size')
			let size_out = DAN.$('e_block_modal_callback_size_out')
			let bottom = DAN.$('e_block_modal_callback_bottom')
			let bottom_out = DAN.$('e_block_modal_callback_bottom_out')
			let right = DAN.$('e_block_modal_callback_right')
			let right_out = DAN.$('e_block_modal_callback_right_out')
			let color = DAN.$('e_block_modal_callback_color')

			size.onmousemove = () => {
				size_out.innerHTML = size.value
				b.style.width = size.value * 2 + 'px';
				b.style.height = size.value * 2 + 'px';
			}

			bottom.onmousemove = () => {			
				bottom_out.innerHTML = bottom.value
				b.style.bottom = bottom.value + 'px';
			}

			right.onmousemove = () => {
				right_out.innerHTML = right.value
				b.style.right = right.value + 'px';
			}

			color.oninput = () => {
				b.childNodes[1].style.backgroundColor = color.value;
				b.childNodes[2].style.backgroundColor = color.value;
				b.childNodes[3].style.borderColor = color.value;
			}				
			
			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = () => {
				EDIT.block.callback.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){
		let form = new FormData()
		
		let size = DAN.$('e_block_modal_callback_size').value
		let bottom = DAN.$('e_block_modal_callback_bottom').value
		let right = DAN.$('e_block_modal_callback_right').value
		let color = DAN.$('e_block_modal_callback_color').value

		form.append('id', id)
		form.append('size', size)
		form.append('bottom', bottom)
		form.append('right', right)
		form.append('color', color)

		EDIT.ajax('/edit/block/callback/settings_update', form, function(data){
			DAN.modal.del()
			EDIT.status(true)
			document.location.href = '/' + EDIT.url
		})
	},
}