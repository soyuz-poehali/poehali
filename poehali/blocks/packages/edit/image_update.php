<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;

// Настройки изображения
$s_533 = 533;
$s_400 = 400;
$s_300 = 300;
$s_225 = 225;

$content = $BLOCK_E->getBlock($id)['content'];

// 1x1
if ($content['image_format'] == 1) {
	$photo_settings['x_small'] = $s_400;
	$photo_settings['y_small'] = $s_400;
}

// 4x3
if ($content['image_format'] == 2) {
	$photo_settings['x_small'] = $s_400;
	$photo_settings['y_small'] = $s_300;
}

// 16x9
if ($content['image_format'] == 3) {
	$photo_settings['x_small'] = $s_400;
	$photo_settings['y_small'] = $s_225;
}

// 3x4
if ($content['image_format'] == 4) {
	$photo_settings['x_small'] = $s_300;
	$photo_settings['y_small'] = $s_400;
}

// 9x16
if ($content['image_format'] == 5) {
	$photo_settings['x_small'] = $s_300;
	$photo_settings['y_small'] = $s_533;
}

if (!$num && !isset($_FILES['file'])) {
	echo json_encode(array('answer' => 'error', $content = 'Не прикреплён файл изображения'));
	exit;
}

// ДИРЕКТОРИЯ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/packages';

if(!is_dir($dir)) 
	mkdir($dir, 0755, true);

if (isset($_FILES['file'])) {
	$file = $_FILES['file'];

	// Проверка
	// --- Проверяем тип файла ---
	$size = getimagesize($file['tmp_name']); // Получим размер изображения и его тип
	$type = $size[2];

	$type_arr = array(1, 2, 3, 18);
	if (!in_array($type, $type_arr)) {
		$act = 'error';
		$SITE->errLog('Неправильный тип файла - '.$type);
		echo json_encode(array('answer' => 'error', 'content' => 'Файлы такого типа <b>'.$file['name'].'</b> запрещено загружать на сервер.'));
		exit;
	}

	$file_name_arr = explode('.', $file['name']);
	$count = count($file_name_arr);
	$ext = mb_strtolower($file_name_arr[$count - 1]);
	$allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');

	if (($count) < 2 || !in_array($ext, $allowed)) {
		$SITE->errLog('Файлы такого типа '.$file['name'].' запрещено загружать на сервер.');
		echo json_encode(array('answer' => 'error', 'content' => 'Файлы такого типа <b>'.$file['name'].'</b> запрещено загружать на сервер.'));
		exit;
	}

	if (!is_dir($dir)) 
		mkdir($dir, 0755, true);

	$u = uniqid();

	// Малое изображение
	$file_new = $u.'.webp';
	$path_new = $dir.'/'.$file_new;

	include_once $_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResizeCutting.php";

	$img_small = new ImageResizeCutting($file['tmp_name'], $path_new, $photo_settings['x_small'], $photo_settings['y_small'], 'webp');
	$img_small->run();
}

if (isset($file_new)) {
	if (isset($content['packages'][$num - 1]['image'])) {
		$file = $dir.'/'.$content['packages'][$num - 1]['image'];
		if(is_file($file)) 
			unlink($file);
	}

	$content['packages'][$num - 1]['image'] = $file_new;		
}	

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;


?>