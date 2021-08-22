document.addEventListener("DOMContentLoaded", function(){
	document.getElementById('create_folder').onclick = function(){
		var content = '<form id="modal_form" method="post" action="/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d + '&a=c&s=' + s + '" enctype="multipart/form-data"><h1>Создать папку</h1><input class="dan_input" type="text" name="name" value="" required pattern="[a-zA-Zа-яА-Я0-9_\\- ]{1,20}" title="Только буквы, цифры и знаки _ - До 20 символов."><div><input class="dan_button_green" type="submit" value="Создать"><div></form>';
		DAN.modal.add(content, 400, 220);
	}

	document.getElementById('upload_file').onclick = function(){
		var content = '<form id="modal_form" method="post" action="/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d + '&a=u&s=' + s + '" enctype="multipart/form-data"><h1>Загрузить файл</h1><input id="input_file" type="file" name="file" required="required" title="Выберите файл"><div style="margin-top:20px;"><input onclick="check_file();" class="dan_button_green" type="button" value="Загрузить"></div></form>';
		DAN.modal.add(content, 400, 190);
	}

	document.getElementById('upload_image').onclick = function(){
		var content = '<form id="modal_form" method="post" action="" enctype="multipart/form-data"><h1>Загрузить изображение</h1><input onchange="img_files(this.files);" id="input_file" type="file" name="file" required="required" title="Выберите файл"></form>';
		DAN.modal.add(content, 400, 130);
	}

	document.getElementById('sort_az').onclick = function(){
		window.location.href = '/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d;
	}

	document.getElementById('sort_date').onclick = function(){
		window.location.href = '/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d + '&s=d';
	}

	let cm = [
		["#DAN.contextmenu.menu.rename", "dan_contextmenu_edit", "Переименовать"],
		["#DAN.contextmenu.menu.del", "dan_contextmenu_delete", "Удалить"]
	];
	DAN.contextmenu.add("ico_container", cm, "right");

	DAN.contextmenu.menu = {
		rename: function(_obj)
		{
			DAN.contextmenu.obj = _obj;
			var type = _obj.getAttribute("data-type");
			var name = _obj.getAttribute("data-name");

			if (type == 'd') {
				var type_name = 'папку';
				var name_e = name;
			}

			if (type == 'f') {
				var type_name = 'файл';
				var file_arr = name.split('.', 2);
				var name_e = file_arr[0];
			}

			if (type != 'd' && type != 'f') 
				return;

			var content = '<form id="modal_form" method="post" action="" enctype="multipart/form-data"><h1>Переименовать ' + type_name + '</h1><input id="name_new" class="dan_input" type="text" name="name" value="' + name_e + '" required pattern="[a-zA-Zа-яА-Я0-9_\\- ]{1,20}" title="Только буквы, цифры и знаки _ - До 20 символов."><input id="name_old" name="name_old" type="hidden" value="' + name + '"><div><input onclick="rename(\'' + type + '\'); return false;" class="dan_button_green" type="button" value="Переименовать"></div></form>';
			DAN.modal.add(content, 400, 220);
		},

		del: function(_obj)
		{
			DAN.contextmenu.obj = _obj;
			var type = _obj.getAttribute("data-type");
			var name = _obj.getAttribute("data-name");

			if (type == 'd') {
				var type_name = 'папку';
				var name_e = name;
			}

			if (type == 'f') {
				var type_name = 'файл';
				var file_arr = name.split('.', 2);
				var name_e = file_arr[0];
			}

			if(type != 'd' && type != 'f') 
				return;
			var content = '<h1>Удалить ' + type_name + '</h1>Вы действительно желаете удалить<br>' + type_name + ' <b>' + name + '?</b><div style="margin-top:20px;"><input onclick="del(\'' + name + '\');" class="dan_button_red" type="submit" value="Удалить"></div>';
			DAN.modal.add(content, 400, 220);
		}
	}

});


function rename(_type)
{
	var m = document.getElementById('modal_form');
	var l = document.getElementById('left');
	if (!m.checkValidity()) {
		alert('Неверное название папки!');
		return;
	}

	var name_new = document.getElementById('name_new').value;
	var name_old = document.getElementById('name_old').value;

	if (_type == 'f') {
		var name_old_arr = name_old.split('.', 2);
		var ext = '.' + name_old_arr[1];
	} else {
		var ext = '';
	}

	var req = new XMLHttpRequest();
	req.open('post', '/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d + '&a=r&t=' + _type + '&s=' + s, true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send("name=" + name_new + "&name_old=" + name_old);

	req.onreadystatechange = function()
	{
		if (req.readyState == 4) {
			if (req.status == 200) {
				if (req.responseText == 'success') {
					var nn = name_new + ext;
					DAN.contextmenu.obj.setAttribute('data-name', nn);
					DAN.contextmenu.obj.children[1].children[0].innerHTML = name_new + ext;
					DAN.contextmenu.obj = '';

					var elements = l.getElementsByTagName("*");
					for (i = 0; i < elements.length; i++) {
						if (elements[i].innerHTML == name_old) {
							elements[i].innerHTML = name_new;
							elements[i].parentNode.setAttribute('data-n', nn);
						}
					}

					DAN.modal.del();
				} else {
					m.innerHTML = req.responseText;
				}
			}
		}
	}
}


function del(_name)
{
	var m = document.getElementById('dan_2_modal_white');
	var l = document.getElementById('left');
	var req = new XMLHttpRequest();
	req.open('post', '/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d + '&a=d&s=' + s, true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send("name=" + _name);

	req.onreadystatechange = function()
	{
		if (req.readyState == 4) {
			if (req.status == 200) {
				if (req.responseText == 'success') {
					DAN.contextmenu.obj.parentNode.removeChild(DAN.contextmenu.obj);

					var elements = l.getElementsByClassName("tree_container");
					var level = '';
					for (i = 0; i < elements.length; i++) {
						if (elements[i].getAttribute("data-n") == _name) {
							level = elements[i].getAttribute("data-l");

							elements[i].parentNode.removeChild(elements[i]);
							i--;
							continue;
						}

						var level_i = elements[i].getAttribute("data-l");

						if (level_i && level != '') {
							// Удаляем уровни
							if (level_i > level) {
								elements[i].parentNode.removeChild(elements[i]);
								i--;
								continue;
							}

							// Останавливаем перебор
							if(level_i == level) break;
						}
					}

					DAN.modal.del();
					DAN.contextmenu.obj = '';
				} else {
					m.innerHTML = req.responseText;
				}
			}
		}
	}
}


function check_file()
{
	var file = document.getElementById('input_file').files[0];
	var ext_arr = ['jpg','jpeg','gif','png','txt','doc','docx','xls','xlsx','pdf','ppt','zip', 'rar','7z','avi','mpeg','mp4','mp3','webm','wav','ogg','ogm']
	var ext = "не определилось";
    var parts = file.name.toLowerCase().split('.');
	if (parts.length > 1) 
		ext = parts.pop();

	for (i = 0; i < ext_arr.length; i++) {
		if (ext == ext_arr[i]) {
			ext = 'success';
			break;
		}
	}

	if (ext != 'success') {
		alert('Такой тип файлов нельзя загружать на сервер!');
		return false;
	}

	if (file.type > 5242880) {
		alert('Файл слишком большой. Допускается загрузка не более 5MB.');
		return false;
	}

    // console.log("MIME тип: " + file.type);
	document.getElementById("modal_form").submit();
}


// отправляем данные на IMAGE_RESIZE
function img_files(_file)
{
	DAN.modal.del();

	IMAGE_RESIZE.win(_file, function(){

		var req = new XMLHttpRequest();

		req.onreadystatechange = function()
		{
			if (req.readyState == 4 && req.status == 200) {
				console.log(req.responseText);

				if (req.responseText == 'success')
					window.location.reload();
				else
					alert(req.responseText);
			}
		}

		var form = new FormData();
		form.append('scale', IMAGE_RESIZE.obj.scale);
		form.append('x1', IMAGE_RESIZE.obj.x1);
		form.append('x2', IMAGE_RESIZE.obj.x2);
		form.append('y1', IMAGE_RESIZE.obj.y1);
		form.append('y2', IMAGE_RESIZE.obj.y2);
		form.append('file', IMAGE_RESIZE.obj.file);

		req.open('post', '/administrator/plugins/filemanager/index.php?v=' + v + '&d=' + d + '&a=i&s=' + s, true);
		req.send(form);
	});
}


function cke(_dir)
{
	console.log(_dir);
	window.opener.CKEDITOR.tools.callFunction($funcNum, '/zzzz', '11111111');
	window.close();	
}
