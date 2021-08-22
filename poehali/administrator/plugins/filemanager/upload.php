<?php
defined("AUTH") or die("Restricted access");

$path = $dir != '' ? '/'.$dir : '';

// Если папка не существует
if (!is_dir($root.$path)) {
	$err_text = 'Переименование папки.<br>Папка <b>'.$name.'</b> не найдена';
	$err_log = '/administrator/plugins/filemanager/rename.php <br>'.$err_text;
	err($err_text, $err_log);
}

// Данные загрузки файла
$file_tmp = $_FILES['file']['tmp_name'];
$file_name = mb_strtolower($_FILES['file']['name']); // Оригинальное имя файла на компьютере клиента. 
$file_type = $_FILES['file']['type']; // Mime-тип файла, в случае, если браузер предоставил такую информацию. Пример: "image/gif". 
$file_size = $_FILES['file']['size']; // Размер в байтах принятого файла. 

$file_name_arr = explode('.', $file_name); 

$count = count($file_name_arr);

// Без расширения
if (($count) < 2) {
	$err_text = 'Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.';
	$err_log = '/administrator/plugins/filemanager/upload.php <br>'.$root.$path.'/'.$file_name;
	err($err_text, $err_log);
	exit;
}

$ext = strtolower($file_name_arr[$count - 1]);

$ban = array('exe', 'php', 'phtml', 'html', 'sh', 'pl', 'cgi', 'htaccess');
$allowed = array('jpg', 'jpeg', 'gif', 'png', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'zip', 'rar', '7z', 'avi', 'mpeg', 'mp4', 'mp3', 'webm', 'wav', 'ogg', 'ogm');

// С запрещённым расширением
if (in_array($ext, $ban)) {
	$err_text = 'Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.';
	$err_log = '/administrator/plugins/filemanager/upload.php <br>'.$root.$path.'/'.$file_name;
	err($err_text, $err_log);
	exit;
}

// Двойное расширение
if (($count) > 2) {
	foreach ($file_name_arr as $ex) {
		if (in_array($ex, $ban)) {
			$err_text = 'Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.';
			$err_log = '/administrator/plugins/filemanager/upload.php <br>'.$root.$path.'/'.$file_name;
			err($err_text, $err_log);
			exit;			
		}		
	}

	$_ext = array_pop($file_name_arr); // Извлекает последний элемент массива, уменьшая его на 1
	$name = implode('', $file_name_arr);	
} else {
	$name = $file_name_arr[0];
}

// Проверка на разрешённые расширения

if (!in_array($ext, $allowed)) {
	$err_text = 'Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.';
	$err_log = '/administrator/plugins/filemanager/upload.php <br>'.$root.$path.'/'.$file_name;
	err($err_text, $err_log);
	exit;
}

$name = translit($name);
$name = preg_replace('/[^a-z0-9_\-]/i','',$name);

if (file_exists($root.$path.'/'.$name.'.'.$ext)) 
	$name = $name.'_';

if (strlen($name) > 50) 
	$name = substr($name, 0, 50);

if (move_uploaded_file($file_tmp, $root.$path.'/'.$name.'.'.$ext)) {
	@chmod($file_tmp, $root.$path.'/'.$name.'.'.$ext, 0644);
} else {
	$err_text = 'Что-то пошло не так';
	$err_log = '/administrator/plugins/filemanager/upload.php <br>'.$file_tmp.' -> '.$root.$path.'/'.$name.'.'.$ext;
	err($err_text, $err_log);
	exit;	
}

header('Location: /administrator/plugins/filemanager/index.php?v='.$vl_r.'&d='.encode($dir).$sort.$cke_rq);
?>