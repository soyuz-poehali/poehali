<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ImageResize/ImageResize.php');
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;

$width = 800;   // Максимальная ширина изображения
$height = 600;   // Максимальная высота изображения

$content = $BLOCK_E->getBlock($id)['content'];

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/case';

if(!is_dir($dir)) 
	mkdir($dir, 0755, true);

if (isset($_FILES['file'])) {
	$file = $_FILES['file'];
} else {
	echo json_encode(array('answer' => 'success', 'message' => 'Файл не выбран'));
	exit;
}

$check_file = new CheckImageFile($file);
if (!$check_file) {  // Проверка расширения и мим типа файла изображения
	echo json_encode(array('answer' => 'success', 'message' => 'Файлы такого типа нельзя загружать на сервер'));
	exit;	
}

// Размер изображения больше 3 Mb
if ($file['size'] > 3000000) {
	echo json_encode(array('answer' => 'success', 'message' => 'Размер изображения больше 3 мегабайт'.$file['size']));
	exit;
}

$name_new = uniqid().'.webp';
$path_new = $dir.'/'.$name_new;
$img = new ImageResize($file['tmp_name'], $path_new, $width, $height, 'webp');
$img->run();

if ($num) {
	$i = $num - 1;
	$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/case/'.$content['images'][$i];
	unlink($file);
	$content['images'][$i] = $name_new;
} else 
	$content['images'][] = $name_new;


$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));

?>