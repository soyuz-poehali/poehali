<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$type = intval($_POST['type']);
$content = $BLOCK_E->getBlock($id)['content'];

$phone = $type == 1 ? $content['phone_1'] : $content['phone_2'];

$phone_pub = $phone['pub'] == 1 ? 'checked' : '';
$whatsapp_pub = $phone['whatsapp'] == 1 ? 'checked' : '';
$viber_pub = $phone['viber'] == 1 ? 'checked' : '';

$html =
'<h2>Телефон '.$type.'</h2>'.
'<table class="e_table_admin"><tbody>'.
	'<tr>'.
		'<td class="e_td_r">Опубликовать</td>'.
		'<td><input id="e_block_modal_menu_phone_pub" class="dan_input" type="checkbox" '.$phone_pub.'><label for="e_block_modal_menu_phone_pub"></label></td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Номер</td>'.
		'<td><input id="e_block_modal_menu_phone_phone" name="phone" class="dan_input" type="text" value="'.$phone['phone'].'"></td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Цвет</td>'.
		'<td><input id="e_block_modal_menu_phone_color" class="dan_input" type="color" value="'.$phone['color'].'"></td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">whatsapp</td>'.
		'<td><input id="e_block_modal_menu_phone_whatsapp" class="dan_input" type="checkbox" '.$whatsapp_pub.'><label for="e_block_modal_menu_phone_whatsapp"></label></td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Viber</td>'.
		'<td><input id="e_block_modal_menu_phone_viber" class="dan_input" type="checkbox" '.$viber_pub.'><label for="e_block_modal_menu_phone_viber"></label></td>'.
	'</tr>'.
'</tbody></table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>'.
'<input id="e_block_modal_menu_phone_id" type="hidden" value="'.$id.'">'.
'<input id="e_block_modal_menu_phone_type" type="hidden" value="'.$type.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>