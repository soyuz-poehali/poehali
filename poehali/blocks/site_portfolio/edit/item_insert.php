<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/CheckImageFile/CheckImageFile.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/ImageResize/ImageResize.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$text = trim(htmlspecialchars(strip_tags($_POST['text'])));
$link = trim(strip_tags($_POST['link']));
$file = $_FILES['file'];

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$check_file = new CheckImageFile($file);

if (!$check_file) {   // Проверка расширения и мим типа файла изображения
	echo json_encode(array('answer' => 'success', 'message' => 'Файлы такого типа или размера нельзя закачивать на сервер'));
	exit;	
}

$u = uniqid();
$file_new = $u.'.webp';
$path_new = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/site_portfolio/'.$file_new;

include_once $_SERVER['DOCUMENT_ROOT']."/classes/ImageResize/ImageResizeMain.php";
$img = new ImageResizeMain($file['tmp_name'], $path_new, 600, 6000, 'webp');
$img->run();

$i = count($content['items']);  // Новый индекс

$arr_items['image'] = $file_new;
$arr_items['text'] = $text;
$arr_items['link'] = $link;

$content['items'][] = $arr_items;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>