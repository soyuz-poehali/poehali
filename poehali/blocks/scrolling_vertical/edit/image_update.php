<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ImageResize/ImageResize.php');
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

if (isset($_FILES['file'])) {
	$file = $_FILES['file'];
} else {
	echo json_encode(array('answer' => 'success', 'message' => 'Файл не выбран'));
	exit;
}

$check_file = new CheckImageFile($file);
if (!$check_file) {
	echo json_encode(array('answer' => 'success', 'message' => 'Некорректный файл (тип, размер)'));
	exit;	
}

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/scrolling_vertical';

if (!is_dir($dir)) 
	mkdir($dir, 0755, true);

// Удаляем старое фото
$file_old = $dir.'/'.$content['image'];
if (is_file($file_old))
	unlink($file_old);

$u = uniqid();
$file_new = $u.'.webp';
$path_new = $dir.'/'.$file_new;

include_once $_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResizeMain.php";
$img = new ImageResizeMain($file['tmp_name'], $path_new, 600, 6000, 'webp');
$img->run();

$content['image'] = $file_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));

?>