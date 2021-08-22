EDIT.block.video = {
	container_style_old: '',
	wrap_style_old: '',

	add(id){
		let content =
		'<div class="dan_2_modal_content_center_mobile">' +
			'<h2>Добавить видео c YouTube</h2>' +
			'<table class="e_table_admin">' +
				'<tr><td class="e_td_r">Текст</td><td><input id="e_block_video_modal_text" class="dan_input" name="text" style="width:100%"></td></tr>' +
				'<tr><td class="e_td_r">URL</td><td><input id="e_block_video_modal_url" class="dan_input" name="url" style="width:100%"></td></tr>' +
				'<tr><td class="e_td_r">Формат</td><td><select id="e_block_video_modal_ratio" class="dan_input" name="ratio"><option value="1">16 x 9</option><option value="2">4 x 3</option></select></td></tr>' +
			'</table>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' +
					'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">' + 
				'</div>' +
				'<div>' +
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
				'</div>' +
			'</div>'+ 
        '</div>'
        
		DAN.modal.add(content)

		DAN.$('e_modal_cancel').onclick = DAN.modal.del

		// Отправить данные методом POST
		DAN.$('e_modal_submit').onclick = ()=>{

			let txt = DAN.$('e_block_video_modal_text')
			let video_url = DAN.$('e_block_video_modal_url')
			let ratio = DAN.$('e_block_video_modal_ratio')

			// Проверка ссылки
			regexp = /(https:\/\/)?(www\.)?(youtu\.be|youtube\.com)(\/)(watch(\?v=|.+&v=))?(v=)?([\w_-]{11})/
			if (!regexp.test(video_url.value)) {
				alert('Неправильная ссылка на YouTube')
				return
			}

			let req = new XMLHttpRequest()
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)
			form.append('text', txt.value)
			form.append('video_url', video_url.value)
			form.append('ratio', ratio.value)
			
			
			EDIT.ajax('/edit/block/video/video_add', form, function(data){
				document.location.href = '/' + EDIT.url;
			})			
		}
	},


	button_edit_1: (id)=>{
		EDIT.block.video.button_edit(id, 1)
	},


	button_edit_2: (id)=>{
		EDIT.block.video.button_edit(id, 2)
	},


	button_edit(id, button_num){
		let num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('num', num)
		form.append('button_num', button_num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/video/button_edit', form, function(data){
			EDIT.status()
			DAN.modal.add(data.content)

			EDIT.block.link_select()

			DAN.$('e_block_modal_bg_color').oninput = ()=> {
				DAN.$('e_block_modal_bg_color_hidden').value = DAN.$('e_block_modal_bg_color').value
			}

			// Установка цвета фона кнопки из установок
			let button_color_s = DAN.$('e_block_modal_bg_color_wrap').getElementsByClassName('e_block_modal_color_round')

			for (var i = 0; i < button_color_s.length; i++) {
				button_color_s[i].onclick = (e)=>{
					DAN.$('e_block_modal_bg_color').value = e.target.dataset.color
					DAN.$('e_block_modal_bg_color_hidden').value = e.target.dataset.color_var
				}
			}

			DAN.$('e_block_modal_text_color').oninput = ()=> {
				DAN.$('e_block_modal_text_color_hidden').value = DAN.$('e_block_modal_text_color').value
			}

			// Установка цвета текста кнопки из установок
			let button_bg_color_s = DAN.$('e_block_modal_text_color_wrap').getElementsByClassName('e_block_modal_color_round')

			for (var i = 0; i < button_bg_color_s.length; i++) {
				button_bg_color_s[i].onclick = (e)=>{
					DAN.$('e_block_modal_text_color').value = e.target.dataset.color
					DAN.$('e_block_modal_text_color_hidden').value = e.target.dataset.color_var
				}
			}

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = (e)=>{
				EDIT.block.video.button_update(id, num, button_num)
			}
		})
	},


	button_update(id, num, button_num){
		let on = DAN.$('e_block_modal_on').checked ? 1 : 0;
		let button_text = DAN.$('e_block_modal_text').value;
		let button_link = DAN.$('e_block_modal_link').value;
		let bg_color = DAN.$('e_block_modal_bg_color_hidden').value;
		let text_color = DAN.$('e_block_modal_text_color_hidden').value;
		let style = DAN.$('e_block_modal_style').value;
		let radius = DAN.$('e_block_modal_radius').value;

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('id', id)
		form.append('p', EDIT.p)
		form.append('num', num)
		form.append('button_num', button_num)
		form.append('on', on)
		form.append('text', button_text)
		form.append('link', button_link)
		form.append('bg_color', bg_color)
		form.append('text_color', text_color)
		form.append('style', style)
		form.append('radius', radius)
	
		EDIT.ajax('/edit/block/video/button_update', form, (data)=>{
			DAN.modal.del()
			localStorage.setItem('anchor', block_id)
			EDIT.status()
		})
	},


	copy(id){
		let content =
			'<div class="dan_2_modal_content_center_mobile">' +
				'<h2>Копировать блок</h2>' +
				'<div class="e_modal_wrap_buttons">' +
					'<div>' +
						'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">' + 
					'</div>' +
					'<div>' +
						'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' +
					'</div>' +
				'</div>'+
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let req = new XMLHttpRequest()
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)
			
			EDIT.ajax('/edit/block/video/copy', form, function(_data){
				let new_node = EDIT.obj.cloneNode(true)
				new_node.id = 'block_' + _data.id
				new_node.setAttribute('data-id', _data.id)
				EDIT.obj.insertAdjacentElement('afterEnd', new_node)

				DAN.jumpTo('block_' + _data.id, 500)

				DAN.modal.del()
				EDIT.status(true)
				EDIT.block.initialize()
			})
		}
	},


	del(id){
		let content =
			'<div class="e_modal_title">Удалить блок</div>' +
			'<div class="e_modal_wrap_buttons">' +
				'<div>' + 
					'<input id="e_modal_submit" class="e_modal_button_delete" type="submit" name="submit" value="Удалить">' + 
				'</div>' + 
				'<div>' + 
					'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">' + 
				'</div>' + 
			'</div>'

		DAN.modal.add(content, 350)
		DAN.$('e_modal_cancel').onclick = DAN.modal.del
		DAN.$('e_modal_submit').onclick = function(){
			let form = new FormData()
			form.append('p', EDIT.p)
			form.append('id', id)		

			EDIT.ajax('/edit/block/video/delete', form, function(data){
				EDIT.obj.parentNode.removeChild(EDIT.obj);
				DAN.modal.del()
				EDIT.status(true)
			})
		}
	},


	video_delete(id){
		let video_num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('video_num', video_num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/video/video_delete', form, function(data){
			EDIT.obj.parentNode.removeChild(EDIT.obj);
			DAN.modal.del()
			EDIT.status(true)
		})
	},


	video_edit(id){
		let video_num = EDIT.obj.getAttribute('data-item-num')
		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('video_num', video_num)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/video/video_edit', form, function(data){
			EDIT.status()
			DAN.modal.add(data.content)

			DAN.$('e_modal_cancel').onclick = DAN.modal.del
			DAN.$('e_modal_submit').onclick = function(){
				EDIT.block.video.video_update(id, video_num)
			}
		})
	},


	video_update(id, video_num){
		let video_url = DAN.$('e_block_video_modal_url')
		let ratio = DAN.$('e_block_video_modal_ratio')

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('video_url', video_url.value)
		form.append('video_num', video_num)
		form.append('ratio', ratio.value)
	
		EDIT.ajax('/edit/block/video/video_update', form, function(_data){
			EDIT.status(true)
			DAN.modal.del()
			document.location.href = '/' + EDIT.url;
		})
	},


	// Выводит настройки в модальном окне
	settings(id){
		EDIT.block.video.container_style_old = EDIT.obj.getAttribute('style')
		EDIT.block.video.wrap_style_old = EDIT.obj.childNodes[1].getAttribute('style')

		let req = new XMLHttpRequest()
		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', id)

		DAN.modal.spinner()

		EDIT.ajax('/edit/block/video/settings', form, (data)=>{
			if(data.message){
				DAN.modal.add(data.message)
			} else {
				DAN.modal.add(data.content, 600)
				EDIT.block.settings.init() // Инициализация общих настроек

				// Отправить данные методом POST
				DAN.$('e_modal_submit').onclick = ()=>{
					EDIT.block.video.settings_update(id)
				}

				// Возвращаем старые стили
				DAN.$('e_modal_cancel').onclick = EDIT.block.video.style_reset
			}
		})
	},


	// Обновляет настройки на ajax
	settings_update(id){

		let req = new XMLHttpRequest()
		let form = new FormData()
		let style = DAN.$('e_block_modal_style_select').value
		let bg_type = DAN.$('e_block_modal_bg_type').value
		let bg_color = DAN.$('e_block_modal_container_bg_color_input').value
		let bg_image = DAN.$('e_block_modal_bg_image_file').files[0]
		let bg_image_size = DAN.$('e_block_modal_bg_image_size_1').checked ? 'cover' : '';
		let wrap_bg_check = DAN.$('e_block_modal_wrap_bg_color_check').checked ? 1 : 0
		let wrap_bg_color = DAN.$('e_block_modal_wrap_bg_color').value
		let wrap_bg_opacity = DAN.$('e_block_modal_wrap_opacity').value
		let max_width = DAN.$('e_block_modal_max_width').value
		let margin = DAN.$('e_block_modal_margin').value
		let padding = DAN.$('e_block_modal_padding').value
		let font_select = DAN.$('e_block_modal_font_select').value
		let font_size = DAN.$('e_block_modal_font_size').value
		let line_height = DAN.$('e_block_modal_line_height').value
		let color = DAN.$('e_block_modal_font_color').value

		// Если тип фона изоюражение и (отсутствует старое фоновое изображение или новое) - выбрасываем alert
		if(bg_type == 'i' && (!(EDIT.obj.style.backgroundImage || bg_image))){
			alert ('Не выбрано изображение')
			return
		}

		form.append('p', EDIT.p)
		form.append('id', id)
		form.append('style', style)
		form.append('bg_type', bg_type)
		if(bg_type == 'i') form.append('bg_image', bg_image)
		form.append('bg_color', bg_color)
		form.append('bg_image_size', bg_image_size)
		form.append('wrap_bg_check', wrap_bg_check)
		form.append('wrap_bg_color', wrap_bg_color)
		form.append('wrap_bg_opacity', wrap_bg_opacity)
		form.append('max_width', max_width)
		form.append('margin', margin)
		form.append('padding', padding)
		form.append('font_select', font_select)
		form.append('font_size', font_size)
		form.append('line_height', line_height)		
		form.append('color', color)

		EDIT.ajax('/edit/block/video/settings_update', form, function(data){
			if (data.message) {
				DAN.modal.add(data.message)
			} else {
				DAN.modal.del()
				EDIT.status(true)
				let block_id = 'block_' + _id
				localStorage.setItem('anchor', block_id)
			}
		})
	},


	// Возвращает стили объекта
	style_reset: function(){
		EDIT.obj.setAttribute('style', EDIT.block.video.container_style_old)
		EDIT.block.video.container_style_old = '';
		EDIT.obj.childNodes[1].setAttribute('style', EDIT.block.video.wrap_style_old)
		EDIT.block.video.wrap_style_old = '';
		EDIT.obj = '';
		DAN.modal.del()
	},


	text_edit: function(_id){
		let num = EDIT.obj.getAttribute('data-item-num')
		EDIT.obj = EDIT.obj.getElementsByClassName('block_video_text')[0]

		if(EDIT.obj.id == 'e_editor'){
			EDIT.editorDestroy()
			return
		}

		EDIT.content_old = EDIT.obj.innerHTML
		EDIT.editor()

		// При потере фокуса
		EDIT.ckeditor.on("blur", function(){
			let content_new = CKEDITOR.instances.e_editor.getData()
			EDIT.editorDestroy()

			if(content_new != EDIT.content_old){
				let req = new XMLHttpRequest()
				let form = new FormData()
				form.append('id', _id)
				form.append('p', EDIT.p)
				form.append('num', num)
				form.append('text', content_new)

				EDIT.ajax('/edit/block/video/text_update', form, function(_data){
					EDIT.status(true)
				})
			}
		});
	},


	update_ordering: function(_r){
		let target = DAN.$(_r.target_id)
		let arr = target.getElementsByClassName('e_block_item')

		let video_arr = []

		for(i = 0; i < arr.length; i++){
			video_arr[i] = arr[i].getAttribute('data-item-num')
		}

		let form = new FormData()
		form.append('p', EDIT.p)
		form.append('id', _r.object_id)
		form.append('videos', video_arr)

		EDIT.ajax('/edit/block/video/video_ordering', form, function(_data){
			EDIT.status(true)
			// document.location.href = '/'
		})
	}
}