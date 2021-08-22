if (typeof ADMIN == 'undefined') {
	ADMIN = {}
}

if (typeof ADMIN.poehali == 'undefined') {
	ADMIN.poehali = {}
}

window.addEventListener('DOMContentLoaded', function(){
	let e_editor_1 = CKEDITOR.replace("editor1", {
		height: "400px",
		filebrowserBrowseUrl : "/administrator/plugins/filemanager/index.php",
	});
	DAN.show('poehali_bloger_photo', 'poehali_bloger_form')
	// ADMIN.poehali.item.init()
});

ADMIN.poehali.blogers = {
	image_files: false,

	// Начальная инициализация
	init(){
	},

	// Получаем объект, поднимаясь по родительским элементам до тех пор, пока не совпадёт класс объекта
	get_obj(obj, target_class){
		while (obj) {
			if (obj.classList.contains(target_class)) 
				return obj;
			obj = obj.parentElement;
		}
		return false;
	}
}