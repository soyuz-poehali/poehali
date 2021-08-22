CKEDITOR.editorConfig = function(config) {
	config.language = 'ru';
	config.extraPlugins = 'popup,filebrowser';	 
	config.filebrowserBrowseUrl = '/administrator/plugins/filemanager/index.php';
	config.filebrowserUploadUrl = '/administrator/plugins/filemanager/index.php';	
	config.extraAllowedContent = 'div;span;ul;li;table;td;style;onclick;details;summary;*[id];*(*);*{*}';
};