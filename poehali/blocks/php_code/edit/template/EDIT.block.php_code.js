EDIT.block.php_code = {
	code_old: '',

	edit(id){
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)

		EDIT.ajax('/edit/block/php_code/edit', form, (data) => {
			EDIT.block.php_code.form(id, data.file_name, data.code)
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

			EDIT.ajax('/edit/block/php_code/delete', form, (data) => {
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	form(id=0, file_name='', code='') {
		EDIT.block.php_code.code_old = code

		let file = ''
		if (id == 0) {
			// Добавить блок
			file = '<div><input id="e_file_name" class="dan_input" type="text" name="file_name" pattern="[a-z]{1}[a-z0-9_\-]{1,30}.php" required> ' + 
			'(наименование php файла), требуется функция = имя файла, без расширения</div>'
		} else {
			// Редактировать блок
			let func = file_name.substr(0, file_name.length - 4)
			file = 	'<div style="margin-bottom:10px;">Исполняемый файл: <b>' + file_name + '</b>, требуется функция <b>function ' + func + '(){}</b></div>' +
					'<input id="e_file_name" type="hidden" name="file_name" value="' + file_name + '">'
		}

		if (code == '')
			code = 	"<?php \n" + 
					"defined('AUTH') or die('Restricted access'); \n" +
					"function you_file_name() {  \n" +
					"    return 'Hello World!'; \n" +
					"}"

		let data = {}

		let content =	
		'<h2>Php код</h2>' +
		file +
		'<textarea id="e_php_code" name="code" placeholder="php код">' + code + '</textarea>' +
		'<div class="e_modal_wrap_buttons">' +
			'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>' + 
			'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>' + 
		'</div>'	

		DAN.modal.add(content, 800, '100%')
		let form_code = DAN.$("e_php_code")

	    let CM = CodeMirror.fromTextArea(form_code, {
			mode: "application/x-httpd-php",
			startOpen: true,   // подключается без <?php ?>
			lineNumbers: true,
			styleActiveLine: true,
			indentWithTabs: true,
			indentUnit: 4,
			matchBrackets: true
	    });

	    CM.setOption("theme", "dan")

		if (id)
			localStorage.setItem('anchor', 'block_' + id)


		// При изменении имени файла - создаётся новая функция
		if (id == 0 ) {
			let e_file_name = DAN.$('e_file_name')
			e_file_name.onchange = (e)=> {
				let fn = e.target.value
				let func = fn.substr(0, fn.length - 4)
				let code_f = 	"<?php \n" + 
								"defined('AUTH') or die('Restricted access'); \n" +
								"function " + func + "() {  \n" +
									"    return 'Hello World!'; \n" +
								"}"
				CM.setValue(code_f)
			}
		} 

		DAN.$('e_modal_submit').onclick = () => {
			code = CM.getValue()

			if (code == EDIT.block.php_code.code_old) {
				DAN.modal.del()
				return
			}

			EDIT.block.php_code.form_send(id, code)
		}
		DAN.$('e_modal_cancel').onclick = DAN.modal.del		       
	},


	form_send(id, code) {
		let file_name = DAN.$('e_file_name')
		if (id == 0 && !file_name.validity.valid) {
			alert('Некорректное название файла')
			return
		}

		// Проверяем наличие функции, названной по имени файла
		let func = file_name.value.substr(0, file_name.value.length - 4)
		// Регулярное выражение для проверки функции
		let re = new RegExp('function ' + func + '\\s?\\(.*\\)\\s?\\n?\\{(\\s*\\n? *.*)*\\}')
		if (!re.test(code)) {
			alert('Не найдена функция ' + func)
			return
		}

		action = id ? 'update' : 'insert';

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('action', action)
		form.append('id', id)
		if (id == 0)
			form.append('file_name', file_name.value)
		form.append('code', code)

		EDIT.ajax('/edit/block/php_code/' + action, form, (return_data) => {
			if (return_data.message == 'success') {
				DAN.modal.del()
			} else {
				DAN.modal.add(return_data.message)
			}
		})
	},


	help(){
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', EDIT.obj.dataset.id)

		EDIT.ajax('/edit/block/php_code/help', form, (data) => {
			DAN.modal.add(data.content)
		})
	}
}