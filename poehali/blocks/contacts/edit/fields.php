<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);

$content = $BLOCK_E->getBlock($id)['content'];

$name_arr['address'] = 'Адрес';
$name_arr['phone'] = 'Телефон';
$name_arr['email'] = 'Email';

$ico_arr['address'] = 'home';
$ico_arr['phone'] = 'phone';
$ico_arr['email'] = 'email';

$out = '';
$i = 1;
foreach ($content['fields'] as $field) {
	$out .= 
		'<table class="e_table_admin e_block_modal_item" data-block="contacts" data-id="'.$block_id.'" data-item-num="'.$i.'"><tbody>'.
			'<tr>'.
				'<td class="e_td_ico"><svg class="e_block_panel_ico" data-action="field_edit"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#'.$ico_arr[$field['type']].'"></use></svg></td>'.
				'<td class="e_td_text">'.$name_arr[$field['type']].'</td>'.
				'<td class="e_td_ico"><svg class="drag_drop_ico" data-id="'.$block_id.'" data-target-id="block_modal_target" data-class="e_block_modal_item" data-direction="y"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></td>'.
				'<td class="e_td_ico"><svg class="e_block_panel_ico" data-action="field_edit"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></td>'.
				'<td class="e_td_ico"><svg class="e_block_panel_ico" data-action="field_delete"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></td>'.
			'</tr>'.
		'</tbody></table>';
	$i++;	
}

$html =
'<div id="block_modal_target" class="e_block_modal">'.
	$out.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';


echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>