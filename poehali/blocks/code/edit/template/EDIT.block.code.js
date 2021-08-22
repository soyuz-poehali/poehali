EDIT.block.code = {
	edit(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/code/edit', form, (data) => {
			EDIT.block.code.form(id, data.code)
		})
	},


	del(id){
		let content =
		'<div class="e_modal_title">Удалить блок</div>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
		'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = () => {
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)

			EDIT.ajax('/edit/block/code/delete', form, (data) => {
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	form(id=false, code=''){
		let action = id ? 'update' : 'insert'
		let content = 	
		'<h2>Код в теле страницы</h2>' +
		'<textarea id="e_htmlmixed_code" name="code">' + code + '</textarea>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="button" name="cancel" value="Отменить"></div>' + 
		'</div>' +
		'<input name="id" type="hidden" value="' + id + '">' +
		'<input name="p" type="hidden" value="' + EDIT.p + '">'		

		DAN.modal.add(content, 800, '100%')
		let code_node = document.getElementById("e_htmlmixed_code")

	    let CM = CodeMirror.fromTextArea(code_node, {
			mode: "htmlmixed",
			lineNumbers: true,
			styleActiveLine: true,
			indentWithTabs: true,
			indentUnit: 4,
			matchBrackets: true
	    });

	    CM.setOption("theme", "dan")

		if (id)
			localStorage.setItem('anchor', 'block_' + id)

		DAN.$('e_modal_cancel').onclick = DAN.modal.del

		DAN.$('e_modal_submit').onclick = () => {
			let form = new FormData()
			form.append('id', id)
			form.append('p', EDIT.p)
			form.append('code', CM.getValue())

			EDIT.ajax('/edit/block/code/' + action, form, (data) => {})
		}
	}
}