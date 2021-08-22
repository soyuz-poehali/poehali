<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = intval($_POST['style']);
$format = intval($_POST['format']);
$bg_type = isset($_POST['bg_type']) ? $_POST['bg_type'] : false;
$bg_color = isset($_POST['bg_color']) ? $_POST['bg_color'] : false;
$max_width = isset($_POST['max_width']) ? intval($_POST['max_width']) : false;
$margin = isset($_POST['margin']) ? intval($_POST['margin']) : false;
$padding = isset($_POST['padding']) ? intval($_POST['padding']) : false;
$title_size = isset($_POST['title_size']) ? intval($_POST['title_size']) : false;
$font_size = isset($_POST['font_size']) ? intval($_POST['font_size']) : false;
$color = strip_tags($_POST['color']);
$fog_color = isset($_POST['fog_color']) ? strip_tags($_POST['fog_color']) : false;
$fog_opacity = isset($_POST['fog_opacity']) ? intval($_POST['fog_opacity']) / 100 : false;

$content = $BLOCK_E->getBlock($id)['content'];

$bg_type_arr = array('', '1', '2', '3', 'c');

if (!in_array($bg_type, $bg_type_arr)) {
	$SITE->errLog('Некорректный тип фона: '.$bg_type.' block_id => '.$block_id);
	exit;
}


$content['style'] = $style;
$content['format'] = $format;
$content['bg_type'] = $bg_type ? $bg_type : false;
if($bg_color) 
	$content['bg_color'] = $bg_color;
$content['max_width'] = $max_width;
$content['margin'] = $margin ? $margin : 0;
$content['padding'] = $padding ? $padding : 0;
if($title_size) 
	$content['title_size'] = $title_size;
if($font_size) 
	$content['font_size'] = $font_size;
$content['color'] = $color;
if($fog_color) 
	$content['fog_color'] = $fog_color;
if($fog_opacity) 
	$content['fog_opacity'] = $fog_opacity;


$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'message' => ''));
exit;

?>