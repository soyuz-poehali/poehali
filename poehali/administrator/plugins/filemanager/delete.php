<?php
defined("AUTH") or die("Restricted access");

$name_1 = $_POST['name'];
$name = preg_replace('/[^a-z0-9_\-\.]/i','',$name_1);

// Находим расширение
$name_arr = explode('.', $name);

if (count($name_arr) > 2) {
	$err_text = 'Что-то пошло не так';
	$err_log = '/administrator/plugins/filemanager/delete.php <br> Проблемы с удалением'.$name;
	err($err_text, $err_log);		
}


// Папка
if (count($name_arr) == 1) {
	$path = $dir != '' ? '/'.$dir.'/'.$name : '/'.$name;

	// Папка не существует
	if (!is_dir($root.$path)) {
		$err_text = 'Удаление папки.<br>Папка <b>'.$name.'</b> не найдена';
		$err_log = '/administrator/plugins/filemanager/delete.php <br>'.$err_text;
		err($err_text, $err_log);
	}

	remove_directory($root.$path); // Рекурсивное удаление
	echo 'success';
}


// Файл
if (count($name_arr) == 2) {
	
	$path = $dir != '' ? '/'.$dir.'/'.$name : '/'.$name;

	// Папка не существует
	if (!file_exists($root.$path) || is_dir($root.$path)) {
		$err_text = 'Удаление файла.<br>Файл <b>'.$name.'</b> не найден';
		$err_log = '/administrator/plugins/filemanager/delete.php <br>'.$err_text;
		err($err_text, $err_log);
	}

	unlink($root.$path);
	echo 'success';	
}


// Рекурсивное удаление директории
function remove_directory($_dir) 
{
	if ($objs = glob($_dir."/*")) {
		foreach ($objs as $obj) {
     		is_dir($obj) ? remove_directory($obj) : unlink($obj);
   		}
	}
	rmdir($_dir);
}

?>