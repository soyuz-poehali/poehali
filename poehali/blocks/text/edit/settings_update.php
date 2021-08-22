<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/bg_image.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$page_id = intval($_POST['p']);
$content['max_width'] = intval($_POST['max_width']);
$content['margin'] = intval($_POST['margin']);
$content['padding'] = intval($_POST['padding']);
$content['wrap_bg_color'] = $_POST['wrap_bg_color'];
$content['wrap_bg_opacity'] = intval($_POST['wrap_bg_opacity'])/100;
$content['bg_type'] = $_POST['bg_type'];
$content['bg_color'] = $_POST['bg_color'];
$content['bg_image_size'] = $_POST['bg_image_size'];
$wrap_bg_check = intval($_POST['wrap_bg_check']);
$font_select = $_POST['font_select'];
$content['font_size'] = intval($_POST['font_size']);
$content['color'] = $_POST['color'];
$content['line_height'] = $_POST['line_height'];

if ($wrap_bg_check == 0) 
	$content['wrap_bg_color'] = '';

if ($font_select == 's') {
	$content['font_size'] = 'var(--font-size)';
	$content['color'] = 'var(--font-color)';
}

$bg_type_arr = array('', '1', '2', '3', 'c', 'i');

if (!in_array($content['bg_type'], $bg_type_arr)) {
	$SITE->errLog('Некорректный тип фона: '.$bg_type.', block_id => '.$id);
	exit;
}

// Фон - изображение
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/text';
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

echo json_encode(array('answer' => 'success'));
exit;

?>