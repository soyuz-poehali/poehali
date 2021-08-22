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
$content['bg_image_size'] = isset($_POST['bg_image_size']) ? $_POST['bg_image_size'] : false;
$content['max_width'] = isset($_POST['max_width']) ? intval($_POST['max_width']) : false;
$content['height'] = isset($_POST['height']) ? intval($_POST['height']) : false;
$content['margin'] = isset($_POST['margin']) ? intval($_POST['margin']) : false;
$wrap_bg_check = isset($_POST['wrap_bg_check']) ? intval($_POST['wrap_bg_check']) : false;
$content['wrap_bg_color'] = isset($_POST['wrap_bg_color']) ? $_POST['wrap_bg_color'] : false;
$content['wrap_bg_opacity'] = isset($_POST['wrap_bg_opacity']) ? intval($_POST['wrap_bg_opacity'])/100 : false;
$font_select = $_POST['font_select'];
$content['font_size'] = isset($_POST['font_size']) ? intval($_POST['font_size']) : false;
$content['line_height'] = $_POST['line_height'];
$content['color'] = strip_tags($_POST['color']);

if (!$wrap_bg_check) 
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
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/contacts';
if ($content['bg_type'] == 'i') {
	$bg_image = e_bg_image($dir, $content['bg_image']);
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