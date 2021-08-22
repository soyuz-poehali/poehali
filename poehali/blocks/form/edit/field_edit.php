<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$field_num = isset($_POST['field_num']) ? intval($_POST['field_num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

$type_selected = array_fill(0, 4, '');

if ($SITE->url_arr[3] == 'field_add') {
	$title = 'Добавить поле';
	$type = 'text';
	$text = 'Текст';
	$checked = '';
}

if ($SITE->url_arr[3] == 'field_edit') {
	$title = 'Редактировать поле';
	
	$field = $content['fields'][$field_num - 1];
	$type = $field['type'];
	$text = $field['text'];

	if($type == 'text') 
		$type_selected[0] = 'selected';
	if($type == 'email') 
		$type_selected[1] = 'selected';
	if($type == 'textarea') 
		$type_selected[2] = 'selected';
	if($type == 'checkbox') 
		$type_selected[3] = 'selected';

	$checked = $field['required'] == 1 ? 'checked' : '';
}

$content =
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>'.$title.'</h2>'.
'<table id="e_block_modal_form_options" class="e_table_admin">'.
	'<tr>'.
		'<td class="e_td_r">Тип поля</td>'.
		'<td>'.
			'<select id="e_block_modal_field_type" class="dan_input">'.
				'<option value="text" '.$type_selected[0].'>Текст</option>'.
				'<option value="email" '.$type_selected[1].'>Email</option>'.
				'<option value="textarea" '.$type_selected[2].'>Многострочная область ввода</option>'.
				'<option value="checkbox" '.$type_selected[3].'>Чекбокс</option>'.				
			'</select>'.
		'</td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Текст в поле ввода</td>'.
		'<td>'.
			'<input id="e_block_modal_field_text" class="dan_input" type="text" value="'.$text.'">'.
		'</td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Обязательно для заполнения</td>'.
		'<td>'.
			'<input  id="e_block_modal_field_required" class="dan_input_2" type="checkbox" value="1" '.$checked.'>'.
		'</td>'.
	'</tr>'.		
'</table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div>'.
		'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">'.
	'</div>'.
	'<div>'.
		'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">'.
	'</div>'.
'</div>'.
'<input type="hidden" name="id" value="'.$id.'">'.
'</div>'
;

echo json_encode(array('answer' => 'success', 'content' => $content));

exit;

?>