<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = intval($_POST['style']);
$dots = intval($_POST['dots']);
$effect = isset($_POST['effect']) ? intval($_POST['effect']) : false;
$ratio = intval($_POST['ratio'])/100;
$interval = intval($_POST['interval']);
$bg_type = isset($_POST['bg_type']) ? $_POST['bg_type'] : false;
$bg_color = isset($_POST['bg_color']) ? $_POST['bg_color'] : false;
$bg_image_size = $_POST['bg_image_size'];
$wrap_bg_check = isset($_POST['wrap_bg_check']) ? intval($_POST['wrap_bg_check']) : false;
$wrap_bg_color = isset($_POST['wrap_bg_color']) ? $_POST['wrap_bg_color'] : false;
$wrap_bg_opacity = isset($_POST['wrap_bg_opacity']) ? intval($_POST['wrap_bg_opacity'])/100 : false;
$max_width = isset($_POST['max_width']) ? intval($_POST['max_width']) : false;
$margin = isset($_POST['margin']) ? intval($_POST['margin']) : false;
$padding = isset($_POST['padding']) ? intval($_POST['padding']) : false;
$font_select = isset($_POST['font_select']) ? $_POST['font_select'] : false;
$font_size = isset($_POST['font_size']) ? intval($_POST['font_size']) : false;
$line_height = isset($_POST['line_height']) ? intval($_POST['line_height'])/100 : false;
$color = strip_tags($_POST['color']);
$fog_color = isset($_POST['fog_color']) ? strip_tags($_POST['fog_color']) : false;
$fog_opacity = isset($_POST['fog_opacity']) ? intval($_POST['fog_opacity']) / 100 : false;
$text_1_size = isset($_POST['text_1_size']) ? intval($_POST['text_1_size']) : false;
$text_2_size = isset($_POST['text_2_size']) ? intval($_POST['text_2_size']) : false;

if($text_1_size < 1 || $text_1_size > 6) $text_1_size = 4;
if($text_2_size < 1 || $text_2_size > 6) $text_2_size = 2;

if($wrap_bg_check == 0) $wrap_bg_color = '';
if($font_select == 's')
{
	$font_size = 'var(--font-size)';
	$color = 'var(--font-color)';
}

$bg_type_arr = array('', '1', '2', '3', 'c', 'i');

if(!in_array($bg_type, $bg_type_arr))
{
	$SITE->errLog('Некорректный тип фона: '.$bg_type.' site_id => '.$site_id.' id => '.$id);
	exit;
}

$bg_image_size_arr = array('', 'cover', 'repeat');

if(!in_array($bg_image_size, $bg_image_size_arr))
{
	$SITE->errLog('Некорректный тип размещения фона изображения: '.$bg_image_size.' site_id => '.$site_id.' id => '.$id);
	exit;
}

if($wrap_bg_opacity < 0 || $wrap_bg_opacity > 1)
{
	$SITE->errLog('Некорректное значение прозрачности подложки: '.$wrap_bg_opacity.' site_id => '.$site_id.' id => '.$id);
	exit;
}

$content = $BLOCK_E->getBlock($id)['content'];

$content['style'] = $style;
$content['dots'] = $dots;
if($effect) $content['effect'] = $effect;
$content['ratio'] = $ratio;
$content['interval'] = $interval;
if($bg_type) $content['bg_type'] = $bg_type;
if($bg_color) $content['bg_color'] = $bg_color;
$content['bg_image_size'] = $bg_image_size;
if($wrap_bg_color) $content['wrap_bg_color'] = $wrap_bg_color;
if($wrap_bg_opacity) $content['wrap_bg_opacity'] = $wrap_bg_opacity;
$content['max_width'] = $max_width;
$content['margin'] = $margin;
$content['padding'] = $padding;
if($font_size) $content['font_size'] = $font_size;
$content['color'] = $color;
$content['line_height'] = $line_height;
if($fog_color) $content['fog_color'] = $fog_color;
if($fog_opacity) $content['fog_opacity'] = $fog_opacity;
if($text_1_size) $content['text_1_size'] = $text_1_size;
if($text_2_size) $content['text_2_size'] = $text_2_size;

// Фон - изображение
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/slider';
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

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;

?>