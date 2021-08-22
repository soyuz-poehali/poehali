<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];


$logo_class = $content['logo']['pub'] == 1 ? 'active' : 'passive';
$logo_text_class = $content['logo_text'] != '' ? 'active' : 'passive';
$phone_1_class = $content['phone_1']['pub'] == 1 ? 'active' : 'passive';
$phone_2_class = $content['phone_2']['pub'] == 1 ? 'active' : 'passive';
$sn_class = $content['sn']['pub'] == 1 ? 'active' : 'passive';
$right_text_class = $content['right_text'] != '' ? 'active' : 'passive';
$basket_class = isset($content['basket']) && $content['basket']['pub'] == 1 ? 'active' : 'passive';

$html =
'<div id="e_block_modal_menu_areas" data-id="'.$id.'">'.
	'<h2>Редактируемые области</h2>'.
	'<div id="e_block_modal_menu_logo" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Логотип - слева</div><div class="e_block_modal_item_'.$logo_class.'"></div>'.
	'</div>'.
	'<div id="e_block_modal_menu_logo_text" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Редактируемый блок - слева</div><div class="e_block_modal_item_'.$logo_text_class.'"></div>'.
	'</div>'.
	'<div id="e_block_modal_menu_phone_1" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Телефон 1 - справа</div><div class="e_block_modal_item_'.$phone_1_class.'"></div>'.
	'</div>'.
	'<div id="e_block_modal_menu_phone_2" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Телефон 2 - справа</div><div class="e_block_modal_item_'.$phone_2_class.'"></div>'.
	'</div>'.
	'<div id="e_block_modal_menu_sn" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Соцсети - справа</div>'.
		'<div class="e_block_modal_item_'.$sn_class.'"></div>'.
	'</div>'.
	'<div id="e_block_modal_menu_right_text" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Редактируемый блок - справа</div>'.
		'<div class="e_block_modal_item_'.$right_text_class.'"></div>'.
	'</div>'.
	'<div id="e_block_modal_menu_basket" class="e_block_modal_item dan_flex_row">'.
		'<div class="e_block_modal_item_name">Корзина</div>'.
		'<div class="e_block_modal_item_'.$basket_class.'"></div>'.
	'</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>