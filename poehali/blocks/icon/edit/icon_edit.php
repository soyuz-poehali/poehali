<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : '';

$content = $BLOCK_E->getBlock($id)['content'];


if ($SITE->url_arr[3] == 'icon_add') {
	$title = 'Добавить иконку';
	$text_1 = '';
	$text_2 = '';
	$icon_out = '<img id="e_block_modal_icon_select" data-icon="im-coffee-8" src="/lib/svg/im-coffee-8.svg">';	
}

if ($SITE->url_arr[3] == 'icon_edit') {
	$title = 'Редактировать иконку';
	$icon = $content['icons'][$num - 1];
	$text_1 = $icon['text_1'];
	$text_2 = $icon['text_2'];
	$text_2 =  preg_replace('/\<br(\s*)?\/?\>/i', "", $text_2);
	$icon_out = '<img id="e_block_modal_icon_select" data-icon="'.$icon['icon'].'" src="/lib/svg/'.$icon['icon'].'.svg">';
}


$file_arr = scandir($_SERVER['DOCUMENT_ROOT'].'/lib/svg');
$file_out = '';

foreach ($file_arr as $file) {
	if (strpos($file, '.svg')) {
		$name_arr = explode('.', $file);
		$name = $name_arr[0];
		$file_out .= '<img class="e_block_modal_icon_svg" src="/lib/svg/'.$name.'.svg" data-icon="'.$name.'">';		
	}
}

$html =
'<h2>'.$title.'</h2>'.
'<div id="e_block_icon_modal_message"></div>'.
'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Выбрать иконку</summary>'.
	'<div class="flex_center">'.$file_out.'</div>'.
'</details>'.
'<table id="e_block_modal_icon_options" class="e_table_admin">'.
	'<tr>'.
		'<td class="e_td_r">Иконка:</td>'.
		'<td id="e_block_modal_icon_select_out">'.
		$icon_out.	
		'</td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Текст 1</td>'.
		'<td>'.
			'<input id="e_block_modal_icon_text_1" class="dan_input" style="width:100%" type="text" value="'.$text_1.'">'.
		'</td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Текст 2</td>'.
		'<td>'.
			'<textarea id="e_block_modal_icon_text_2" class="dan_input" rows="5" style="width:100%">'.$text_2.'</textarea>'.
		'</td>'.
	'</tr>'.		
'</table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>'.
'<input type="hidden" name="id" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>