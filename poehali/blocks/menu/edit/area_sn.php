<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$sn_pub = $content['sn']['pub'] == 1 ? 'checked' : '';

$html =
	'<h2>Соцсети, ссылки</h2>'.
	'<table class="e_table_admin"><tbody>'.
		'<tr>'.
			'<td class="e_td_r">Опубликовать</td>'.
			'<td><input id="e_block_modal_menu_sn_pub" class="dan_input" type="checkbox" '.$sn_pub.'><label for="e_block_modal_menu_sn_pub"></label></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">VKontakte</td>'.
			'<td><input id="e_block_modal_menu_sn_vk" class="dan_input" type="text" value="'.$content['sn']['vk'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Facebook</td>'.
			'<td><input id="e_block_modal_menu_sn_fb" class="dan_input" type="text" value="'.$content['sn']['fb'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Youtube</td>'.
			'<td><input id="e_block_modal_menu_sn_youtube" class="dan_input" type="text" value="'.$content['sn']['youtube'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Instagramm</td>'.
			'<td><input id="e_block_modal_menu_sn_instagramm" class="dan_input" type="text" value="'.$content['sn']['instagramm'].'"></td>'.
		'</tr>'.
	'</tbody></table>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>'.
	'<input id="e_block_modal_menu_sn_id" type="hidden" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>