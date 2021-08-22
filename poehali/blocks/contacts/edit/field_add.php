<?php
defined('AUTH') or die('Restricted access');

$html =
'<h2>Добавить поле</h2>'.
'<div class="dan_flex_row">'.
	'<div class="e_str_left e_flex_basis_100">Выбрать поле</div>'.
	'<div class="e_str_right">'.
		'<select id="e_modal_type" class="dan_input">'.
			'<option value="address">Адрес</option>'.
			'<option value="phone">Телефон</option>'.
			'<option value="viber">Viber</option>'.
			'<option value="whatsapp">WhatsApp</option>'.
			'<option value="skype">Skype</option>'.
			'<option value="email">Email</option>'.
			'<option value="youtube">Youtube</option>'.
			'<option value="instagram">Instagram</option>'.
			'<option value="vk">Vkontakte</option>'.
			'<option value="fb">Facebook</option>'.
			'<option value="telegram">Телеграмм</option>'.
			'<option value="html">Html</option>'.
			'<option value="code">Код</option>'.
			'<option value="working_hours">Время работы</option>'.
			'<option value="mapyandex">Яндекс-Карты</option>'.
			'<option value="form">Форма</option>'.
		'</select>'.
	'</div>'.
'</div>'.
'<div class="dan_flex_row">'.
	'<div id="e_modal_str_1" class="e_str_left e_flex_basis_100">Адрес</div>'.
	'<div id="e_modal_str_2" class="e_str_right"><input id="e_modal_value" class="dan_input e_w_100" required></div>'.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>