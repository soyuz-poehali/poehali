<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ImageResize/ImageResize.php');
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$num = intval($_POST['num']);
$image_num = intval($_POST['image_num']);

$content = $BLOCK_E->getBlock($id)['content'];

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/case_2';

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

// Удаляем файл
$image = $content['items'][($num-1)]['images'][($image_num-1)];
$file_old = $dir.'/'.$image;

if (is_file($file_old))
	unlink($file_old);

$u = uniqid();
$file_new = $u.'.webp';
$path_new = $dir.'/'.$file_new;

$content['items'][($num-1)]['images'][($image_num-1)] = $file_new;

include_once $_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResize.php";
$img = new ImageResizeMain($file['tmp_name'], $path_new, 500, 500, 'webp');
$img->run();


$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
?>