<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/bg_image.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = intval($_POST['style']);

$content = $BLOCK_E->getBlock($id)['content'];
$content['style'] = intval($_POST['style']);
$content['bg_type'] = isset($_POST['bg_type']) ? $_POST['bg_type'] : false;
$content['bg_color'] = isset($_POST['bg_color']) ? $_POST['bg_color'] : false;
$content['bg_image_size'] = isset($_POST['bg_image_size']) ? $_POST['bg_image_size'] : false;
$wrap_bg_check = isset($_POST['wrap_bg_check']) ? intval($_POST['wrap_bg_check']) : false;
$content['wrap_bg_color'] = isset($_POST['wrap_bg_color']) ? $_POST['wrap_bg_color'] : false;
$content['wrap_bg_opacity'] = isset($_POST['wrap_bg_opacity']) ? intval($_POST['wrap_bg_opacity'])/100 : false;
$content['max_width'] = isset($_POST['max_width']) ? intval($_POST['max_width']) : false;
$content['margin'] = isset($_POST['margin']) ? intval($_POST['margin']) : false;
$content['padding'] = isset($_POST['padding']) ? intval($_POST['padding']) : false;
$font_select = trim(htmlspecialchars(strip_tags($_POST['font_select'])));
$content['font_size'] = isset($_POST['font_size']) ? intval($_POST['font_size']) : false;
$content['line_height'] = $_POST['line_height'];
$content['color'] = strip_tags($_POST['color']);
$content['button_text'] = trim(htmlspecialchars(strip_tags($_POST['button_text'])));
$content['button_color'] = trim(strip_tags($_POST['button_color']));
$content['button_bg_color'] = trim(strip_tags($_POST['button_bg_color']));

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
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/form';
if (!is_dir($dir)) 
	mkdir($dir, 0755, true);

if ($content['bg_type'] == 'i') {
	$new_bg = e_bg_image($dir, $content['bg_image']);  # $content['bg_image'] - слева новый контент, справа - старый
	if ($new_bg)
		$content['bg_image'] = $new_bg;
} else {
	$content['bg_image'] = '';
	// Удаляем старый файл
	$file_old = $dir.'/background/'.$content['bg_image'];
	if (is_file($file_old)) {
		unlink($file_old);
	}
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success'));
exit;

?>