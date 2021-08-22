<?php
defined("AUTH") or die("Restricted access");

$name_1 = translit($_POST['name']);
$name_2 = mb_strimwidth($name_1, 0, 20, '');
$name = preg_replace('/[^a-z0-9_\-\/]/i','',$name_2);

$path = $dir != '' ? '/'.$dir.'/'.$name : '/'.$name;

$err = '';
if (mb_strlen($name) == 0) 
	$err = 'Папка должна иметь название <br>'; 

// Проверяем существование аналогичной папки
if (is_dir($root.$path) && $err == '') {
	$err_text = 'Папка с указанным именем <b>'.$name.'</b> уже существует';
	$err_log = '/administrator/plugins/filemanager/create_folder.php <br>'.$err_text;
	err($err_text, $err_log);
} else {
	mkdir($root.$path, 0755);
	header('Location: /administrator/plugins/filemanager/index.php?v='.$vl_r.'&d='.encode($dir).$sort.$cke_rq);
	exit;
}

?>