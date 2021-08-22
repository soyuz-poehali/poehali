<?php
defined("AUTH") or die("Restricted access");
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ImageResize/ImageResizeSelectArea.php');

$scale = $_POST['scale'];
$x1 = intval($_POST['x1']);
$x2 = intval($_POST['x2']);
$y1 = intval($_POST['y1']);
$y2 = intval($_POST['y2']);

$path = $dir != '' ? '/'.$dir : '';

// Если папка не существует
if (!is_dir($root.$path)) {
	$err_text = 'Ресайз изображения.<br>Папка <b>'.$path.'</b> не найдена';
	$err_log = '/administrator/plugins/filemanager/image_resize.php <br>Ресайз изображения.<br>Папка <b>'.$root.$path.'</b> не найдена';
	err($err_text, $err_log);
}

// Данные загрузки файла
$file_tmp = $_FILES['file']['tmp_name'];
$file_name = mb_strtolower($_FILES['file']['name']); // Оригинальное имя файла на компьютере клиента. 
$file_type = $_FILES['file']['type']; // Mime-тип файла, в случае, если браузер предоставил такую информацию. Пример: "image/gif". 
$file_size = $_FILES['file']['size']; // Размер в байтах принятого файла. 


// --- Проверяем расширение ---
$file_name_arr = explode('.', $file_name);
$ext = array_pop($file_name_arr); // Извлекает последний элемент массива, уменьшая его на 1
$name = implode('', $file_name_arr);
$name = translit($name);
$name = preg_replace('/[^a-z0-9_\-]/i','',$name);

if (file_exists($root.$path.'/'.$name.'.'.$ext)) 
	$name = $name.'_'.date("H_i_s");

if (strlen($name) > 50) 
	$name = substr($name, 0, 50);

if (!($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png' || $ext == 'webp')) {
	$err_text = 'Тип файла - не изображение формата jpg, gif, png, webp';
	$err_log = '/administrator/plugins/filemanager/image_resize.php <br>Ресайз изображения.<br>Тип файла - не изображение. Мим тип <b>'.$file_name.'</b>';
	err($err_text, $err_log);	
}


// --- Проверяем тип файла ---
$size = getimagesize($file_tmp); // Получим размер изображения и его тип
$src_width = $size[0];
$src_height = $size[1];
$type = $size[2];

if (!($type == 1 || $type == 2 || $type == 3 || $ext == 'webp')) {
	$err_text = 'Тип файла - не изображение формата jpg, gif, png, webp';
	$err_log = '/administrator/plugins/filemanager/image_resize.php <br>Ресайз изображения.<br>Тип файла - не изображение. Мим тип <b>'.$type.'</b>';
	err($err_text, $err_log);	
}

$width = ($x2 - $x1)/$scale;
$height = ($y2 - $y1)/$scale;

$w = $x2 - $x1;
$h = $y2 - $y1;

$img = new ImageResizeSelectArea($file_tmp, $root.$path.'/'.$name.'.webp', $width, $height, 'webp');
$img->setArea($x1, $y1, $w, $h);
$img->run();

echo 'success';
?>