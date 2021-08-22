<?php
defined('AUTH') or die('Restricted access');
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ImageResize/ImageResizeSelectArea.php');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$width_optimal = intval($_POST['w']); // Оптимальная ширина
$x1 = intval($_POST['x1']);
$x2 = intval($_POST['x2']);
$y1 = intval($_POST['y1']);
$y2 = intval($_POST['y2']);
$scale = $_POST['scale'];
$alt = $_POST['alt'];

$content = $BLOCK_E->getBlock($id)['content'];
$content['alt'] = $alt;

if (isset($_FILES['file'])) {
	$file = $_FILES['file'];
	$file_name = mb_strtolower($_FILES['file']['name']);
} else {
	// Обновляем только альты
	$BLOCK_E->updateBlockContent($id, $content);
	echo json_encode(array('answer' => 'success', 'id' => $id));
	exit;
}

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/image';
if(!is_dir($dir)) mkdir($dir, 0755);


// ПРОВЕРЯЕМ ТИП ФАЙЛА
$file_name_arr = explode('.', $file_name);
$count = count($file_name_arr);

// Без расширения
if(($count) < 2) 
	error_upload('Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.');

$ext = mb_strtolower($file_name_arr[$count - 1]);
$ban = array('exe', 'php', 'phtml', 'html', 'sh', 'pl', 'cgi', 'htaccess');
$allowed = array('jpg', 'jpeg', 'gif', 'png', 'webp');

// С запрещённым расширением
if (in_array($ext, $ban)) 
	error_upload('Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.');

// Двойное расширение
if ($count > 2) {
	foreach ($file_name_arr as $ex) {
		if (in_array($ex, $ban)) 
			error_upload('Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.');
	}	
}

// Проверка на разрешённые расширения
if (!in_array($ext, $allowed)) 
	error_upload('Файлы такого типа <b>'.$file_name.'</b> запрещено загружать на сервер.');

$size = getimagesize($file['tmp_name']); // Получим размер изображения и его тип
$type = $size[2];

// Размер изображения больше 3 Mb
if($file['size'] > 3000000) 
	error_upload('Размер изображения больше 3 мегабайт'.$file['size']);

$width = ($x2 - $x1)/$scale;
$height = ($y2 - $y1)/$scale;

$w = $x2 - $x1;
$h = $y2 - $y1;

// Если изображение меньше оптимального по ширине и у этого изображения выделена вся область - просто копируем файл
if ($ext == 'webp' || $size[0] <= $width_optimal && $w == $size[0] && $h == $size[1]) { // $size[0] / $size[1] - ширина / высота изображения
	$file_new = uniqid().'.'.$ext;
	$path_new = $dir.'/'.$file_new;
	if(move_uploaded_file($file['tmp_name'], $path_new)) 
		@chmod($path_new, 0644);
	else 
		error_upload('Что-то пошло не так');
} else { // Иначе - обрабатываем файл
	$file_new = uniqid().'.webp';
	$path_new = $dir.'/'.$file_new;
	$img = new ImageResizeSelectArea($file['tmp_name'], $path_new, $width, $height, 'webp');
	$img->setArea($x1, $y1, $w, $h);
	$img->run();		
}

// Удаляем старый файл
$file_old = $dir.'/'.$content['image'];
if(is_file($file_old)) unlink($file_old);

$content['image'] = $file_new;
$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;


function error_upload($err_text)
{
	global $SITE;
	$SITE->errLog($err_text);	
	echo json_encode(array('answer' => 'success', 'id' => $id, 'message' => $err_text));	
	exit;
}

?>