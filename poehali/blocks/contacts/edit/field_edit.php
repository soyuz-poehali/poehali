<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$field_num = isset($_POST['field_num']) ? intval($_POST['field_num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

$field = $content['fields'][$field_num - 1];

$name_arr['address'] = 'Адрес';
$name_arr['phone'] = 'Телефон';
$name_arr['viber'] = 'Viber';
$name_arr['whatsapp'] = 'WhatsApp';
$name_arr['skype'] = 'Skype';
$name_arr['email'] = 'Email';
$name_arr['youtube'] = 'Ссылка на канал Youtube';
$name_arr['instagram'] = 'Ссылка на Instagram';
$name_arr['vk'] = 'Ссылка на группу VK';
$name_arr['fb'] = 'Ссылка на группу Facebook';
$name_arr['ok'] = 'Ссылка Одноклассники';
$name_arr['telegram'] = 'Ссылка на Телеграмм';
$name_arr['code'] = 'Произвольный код';
$name_arr['mapyandex'] = 'Яндекс карта';
$name_arr['working_hours'] = 'Время работы';
$name_arr['form'] = 'Форма обратной связи';


if ($field['type'] == 'code') {
	$f = '<textarea id="e_modal_value" class="dan_input e_w_100" style="height:100px;">'.htmlspecialchars($field['content']).'</textarea>';
} else {
	$f = '<input id="e_modal_value" class="dan_input" type="content" value="'.htmlspecialchars($field['content']).'" required>';
}

$html =
'<h2>Редактировать поле</h2>'.
'<div class="dan_flex_row e_p_5_20">'.
	'<div class="e_str_left e_flex_basis_100">'.$name_arr[$field['type']].':</div>'.	
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.$f.'</div>'.
	'</div>'.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';
'<input type="hidden" name="id" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>