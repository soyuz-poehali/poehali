<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/bg_image.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$content['bg_type'] = isset($_POST['bg_type']) ? $_POST['bg_type'] : false;
$content['bg_color'] = isset($_POST['bg_color']) ? $_POST['bg_color'] : false;
$content['bg_image_size'] = $_POST['bg_image_size'];
$content['max_width'] = isset($_POST['max_width']) ? intval($_POST['max_width']) : false;
$content['height'] = isset($_POST['height']) ? intval($_POST['height']) : false;
$content['margin'] = isset($_POST['margin']) ? intval($_POST['margin']) : false;
$content['mark_type'] = trim(strip_tags($_POST['mark_type']));

$bg_type_arr = array('', '1', '2', '3', 'c', 'i');

if (!in_array($content['bg_type'], $bg_type_arr)) {
	$SITE->errLog('Некорректный тип фона: '.$bg_type.', block_id => '.$id);
	exit;
}

// Фон - изображение
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/mapsyandex';
if ($content['bg_type'] == 'i') {
	$bg_image = e_bg_image($dir, $content['bg_image']);  # $content['bg_image'] - слева новый контент, справа - старый
	if ($bg_image)
		$content['bg_image'] = $bg_image;
} else {
	$content['bg_image'] = '';
	// Удаляем старый файл
	$file_old = $dir.'/background/'.$content['bg_image'];
	if (is_file($file_old))
		unlink($file_old);
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>