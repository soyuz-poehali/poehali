<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$icon_num = intval($_POST['icon_num']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$file_arr = scandir($_SERVER['DOCUMENT_ROOT'].'/lib/svg');
$file_out = '';

foreach ($file_arr as $file) {
	if (strpos($file, '.svg')) {
		$name_arr = explode('.', $file);
		$name = $name_arr[0];
		$file_out .= '<img class="e_block_modal_icon_svg" src="/lib/svg/'.$name.'.svg" data-icon="'.$name.'">';		
	}
}

$icon = $content['items'][$num - 1]['icons'][$icon_num - 1]['ico'];

$content = 
'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Выбрать иконку</summary>'.
	'<div class="dan_flex_center">'.$file_out.'</div>'.
'</details>'.
'<table id="e_block_modal_icon_options" class="e_table_admin" style="margin:20px 0px;">'.
	'<tr>'.
		'<td class="e_td_r">Иконка:</td>'.
		'<td id="e_block_modal_icon_select_out"><img id="e_block_modal_icon_select_out" data-icon="'.$icon.'" src="/lib/svg/'.$icon.'.svg"></td>'.
	'</tr>'.
'</table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'id' => $id, 'content' => $content));
exit;

?>