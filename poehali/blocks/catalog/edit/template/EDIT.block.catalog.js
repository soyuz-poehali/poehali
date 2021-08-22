EDIT.block.catalog = {
	del(id){
		let content =
			'<h2>Удалить блок</h2>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' +
					'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Удалить">' +
				'</div>' +
				'<div>' +
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
				'</div>' +
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)


			EDIT.ajax('/edit/block/catalog/delete', form, function(_data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},

	// Выводит настройки в модальном окне
	settings(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		EDIT.ajax('/edit/block/catalog/settings', form, function(data){
			DAN.modal.add(data.content, 600)

			// Отправить данные методом POST
			DAN.$('e_modal_submit').onclick = function(){
				EDIT.block.catalog.settings_update(id)
			}

			// Возвращаем старые стили
			DAN.$('e_modal_cancel').onclick = DAN.modal.del
		})
	},

	// Обновляет настройки на ajax
	settings_update: function(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('catalog_id', DAN.$('e_block_modal_catalog_id').value)
		form.append('max_width', DAN.$('e_block_modal_max_width').value)
		form.append('margin', DAN.$('e_block_modal_margin').value)
		
		EDIT.ajax('/edit/block/catalog/settings_update', form, function(data){
			if (data.answer == 'success') {
				DAN.modal.del()
				EDIT.status(true)
			} else {
				EDIT.errLog('Ошибка')
				alert('Ошибка сохранения данных')
			}
		})
	}
}