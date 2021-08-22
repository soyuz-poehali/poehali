<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];
$logo_pub = $content['logo']['pub'] == 1 ? 'checked' : '';

$html =
'<div ata-id="'.$id.'">'.
	'<h2>Логотип</h2>'.
	'<table class="e_table_admin"><tbody>'.
		'<tr>'.
			'<td class="e_td_r">Опубликовать</td>'.
			'<td><input id="e_block_modal_menu_logo_pub" class="dan_input" type="checkbox" '.$logo_pub.'><label for="e_block_modal_menu_logo_pub"></label></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Выбрать лого</td>'.
			'<td><input id="e_block_modal_menu_logo_file" name="file" type="file"></td>'.
		'</tr>'.
	'</tbody></table>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>