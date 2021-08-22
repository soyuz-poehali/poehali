<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/menu/classes/BlockMenuBasket.php';
$BLOCK_E = new BlockEdit;
$BASKET = new BlockMenuBasket;

$shop_id_arr = $BASKET->getCatalogs();

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$basket_pub = isset($content['basket']) && $content['basket']['pub'] == 1 ? 'checked' : '';

if (!$shop_id_arr) {
	$html =
	'<h2>Корзина</h2>'.
	'<div>Каталог интернет-магазина не найден.</div>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>';

	echo json_encode(array('answer' => 'success', 'content' => $html));
	exit;
}

if (!isset($content['basket']['type']))
	$content['basket']['type'] = [];

$catalog_options = '';
$i = 0;
foreach ($shop_id_arr as $shop) {
	$shop_select = $shop['id'] == $content['basket']['type'] || (count($shop_id_arr) == 1 && $i == 0) ? 'select' : '';
	$catalog_options .= '<option value="'.$shop['id'].'" '.$shop_select.'>'.$shop['name'].'</option>';
	$i++;
}

$html =
'<h2>Корзина</h2>'.
'<table class="e_table_admin"><tbody>'.
	'<tr>'.
		'<td class="e_td_r">Опубликовать</td>'.
		'<td><input id="e_block_modal_basket_pub" class="dan_input" type="checkbox" '.$basket_pub.'><label for="e_block_modal_basket_pub"></label></td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Каталог</td>'.
		'<td>'.
			'<select id="e_block_modal_catalog_id" class="dan_input" name="catalog_id">'.
				$catalog_options.
			'</select>'.
		'</td>'.
	'</tr>'.
'</tbody></table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>'.
'<input id="e_block_modal_block_id" type="hidden" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>