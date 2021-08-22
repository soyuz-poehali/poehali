<?php
defined("AUTH") or die("Restricted access");

$type = $_GET['t'];
$name_old = $_POST['name_old'];

// === ПАПКИ ===
if ($type == 'd') {
	$name_1 = translit($_POST['name']);
	$name_2 = mb_strimwidth($name_1, 0, 20, '');
	$name_new = preg_replace('/[^a-z0-9_\-\/]/i','',$name_2);
	
	if ($name_new == '') {
		$err_text = 'Переименование папки.<br>Имя новой папки не может быть пустым';
		$err_log = '/administrator/plugins/filemanager/rename.php <br>'.$err_text;
		err($err_text, $err_log);
	}

	if ($dir != '') {
		$path_old = '/'.$dir.'/'.$name_old;
		$path_new = '/'.$dir.'/'.$name_new; 
	} else {
		$path_old = '/'.$name_old;
		$path_new = '/'.$name_new;
	}

	if ($path_old == $path_new) {
		echo 'success';
		exit;		
	}

	// Старая папка не существует
	if (!is_dir($root.$path_old)) {
		$err_text = 'Переименование папки.<br>Папка <b>'.$name.'</b> не найдена';
		$err_log = '/administrator/plugins/filemanager/rename.php <br>'.$err_text;
		err($err_text, $err_log);
	}

	rename ($root.$path_old, $root.$path_new);

	echo 'success';
	exit;
}


// === ФАЙЛЫ ===
if ($type == 'f') {
	$name_1 = translit($_POST['name']);
	$name_2 = mb_strimwidth($name_1, 0, 100, '');
	$name_new = preg_replace('/[^a-z0-9_\-]/i','',$name_2);

	if ($name_new == '') {
		$err_text = 'Переименование файла.<br>Имя нового файла не может быть пустым';
		$err_log = '/administrator/plugins/filemanager/rename.php <br>'.$err_text;
		err($err_text, $err_log);
	}

	if ($dir != '') {
		$path_old = '/'.$dir.'/'.$name_old;
		$path_new = '/'.$dir.'/'.$name_new; 
	} else {
		$path_old = '/'.$name_old;
		$path_new = '/'.$name_new;
	}

	// Проверка существования старого файла
	if (!file_exists($root.$path_old) || is_dir($root.$path_old)) {
		$err_text = 'Переименование файла.<br>Проблемы с именем старого файла <b>'.$name_old.'</b> ';
		$err_log = '/administrator/plugins/filemanager/rename.php <br>'.$err_text.$root.$path_old;
		err($err_text, $err_log);		
	}

	// Находим расширение старого файла
	$name_old_arr = explode('.', $name_old);

	if (count($name_old_arr) != 2) {
		$err_text = 'Переименование файла.<br>Проблемы с именем старого файла <b>'.$name_old.'</b> ';
		$err_log = '/administrator/plugins/filemanager/rename.php <br>'.$err_text.$root.$path_old;
		err($err_text, $err_log);		
	}

	$ext = '.'.$name_old_arr[1]; // Расширение файла

	if ($path_old == $path_new.$ext) {  // Имена нового и старого файла совпадают
		echo 'success';
		exit;		
	}

	// Проверка существования файла с аналогичным именем
	if (file_exists($root.$path_new.$ext)) {
		echo '<!DOCTYPE html><html><head><title>Ошибка</title></head><body><h1>Ошибка</h1><div>Файл <b>'.$name_new.$ext.'</b> уже существует</div></body></html>';
		exit;		
	}


	rename ($root.$path_old, $root.$path_new.$ext);
	echo 'success';
	// header('Location: /administrator/plugins/filemanager/index.php?v='.$vl_r.'&d='.encode($dir));
	exit;
}

?>