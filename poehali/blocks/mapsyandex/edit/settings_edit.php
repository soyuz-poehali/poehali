<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$wrap_width_select_100 = $wrap_width_select_1600 = $wrap_width_select_1440 = $wrap_width_select_1280 = '';

switch ($content['max_width']) {
	case '100': $wrap_width_select_100 = 'selected'; break;
	case '1600': $wrap_width_select_1600 = 'selected'; break;
	case '1440': $wrap_width_select_1440 = 'selected'; break;
	case '1280': $wrap_width_select_1280 = 'selected'; break;
}

if (!isset($content['mark_type']))
	$content['mark_type'] = 'islands#redBlue';

$mark_checked['islands#blueIcon'] = '';
$mark_checked['islands#redIcon'] = '';
$mark_checked['islands#darkOrangeIcon'] = '';
$mark_checked['islands#nightIcon'] = '';
$mark_checked['islands#darkBlueIcon'] = '';
$mark_checked['islands#pinkIcon'] = '';
$mark_checked['islands#grayIcon'] = '';
$mark_checked['islands#brownIcon'] = '';
$mark_checked['islands#darkGreenIcon'] = '';
$mark_checked['islands#violetIcon'] = '';
$mark_checked['islands#blackIcon'] = '';
$mark_checked['islands#yellowIcon'] = '';
$mark_checked['islands#greenIcon'] = '';
$mark_checked['islands#orangeIcon'] = '';
$mark_checked['islands#lightBlueIcon'] = '';
$mark_checked['islands#oliveIcon'] = '';

$mark_checked['islands#blueStretchyIcon'] = '';
$mark_checked['islands#redStretchyIcon'] = '';
$mark_checked['islands#darkOrangeStretchyIcon'] = '';
$mark_checked['islands#nightStretchyIcon'] = '';
$mark_checked['islands#darkBlueStretchyIcon'] = '';
$mark_checked['islands#pinkStretchyIcon'] = '';
$mark_checked['islands#grayStretchyIcon'] = '';
$mark_checked['islands#brownStretchyIcon'] = '';
$mark_checked['islands#darkGreenStretchyIcon'] = '';
$mark_checked['islands#violetStretchyIcon'] = '';
$mark_checked['islands#blackStretchyIcon'] = '';
$mark_checked['islands#yellowStretchyIcon'] = '';
$mark_checked['islands#greenStretchyIcon'] = '';
$mark_checked['islands#orangeStretchyIcon'] = '';
$mark_checked['islands#lightBlueStretchyIcon'] = '';
$mark_checked['islands#oliveStretchyIcon'] = '';
$mark_checked[$content['mark_type']] = 'checked';

$html =
'<h2>Настройки блока</h2>'.
'<details class="dan_accordion">'.
	'<summary>Размер</summary>'.
	'<div>'.
		'<div class="dan_flex_row e_p_5_20">'.
			'<div class="e_str_left e_flex_basis_150">Максимальная ширина</div>'.		
				'<div class="e_str_right">'.
					'<div class="dan_flex_center">'.
						'<select id="e_block_modal_max_width" class="dan_input">'.
							'<option value="100" '.$wrap_width_select_100.'>100%</option>'.
							'<option value="1600" '.$wrap_width_select_1600.'>1600px</option>'.
							'<option value="1440" '.$wrap_width_select_1440.'>1440px</option>'.
							'<option value="1280" '.$wrap_width_select_1280.'>1280px</option>'.
						'</select>'.
					'</div>'.
				'</div>'.		
		'</div>'.
		'<div class="dan_flex_row e_p_5_20">'.
			'<div class="e_str_left e_flex_basis_150">Высота карты</div>'.		
				'<div class="e_str_right">'.
					'<div class="dan_flex_center">'.
						'<input id="e_block_modal_mapsyandex_height" type="range" min="200" max="1000" step="10" value="'.$content['height'].'">'.
						'<div class="e_modal_range_out"><span id="e_block_modal_mapsyandex_height_out">'.$content['height'].'</span></div>'.					
					'</div>'.
				'</div>'.	
		'</div>'.
		'<div class="dan_flex_row p_5_20">'.		
			'<div class="e_str_left e_flex_basis_150">Внешний отступ (от подложки)</div>'.		
			'<div class="e_str_right">'.
				'<div class="dan_flex_center">'.
					'<input id="e_block_modal_margin" class="dan_input" type="number" min="0" max="100" value="'.$content['margin'].'">'.				
				'</div>'.
			'</div>'.		
		'</div>'.
	'</div>'.
'</details>'.		
'<details class="dan_accordion">'.
	'<summary>Тип точки</summary>'.
	'<div class="dan_flex_row e_p_5_20">'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_1" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#blueIcon" '.$mark_checked["islands#blueIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_1"><img src="/blocks/mapsyandex/edit/template/images/blueIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_2" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#redIcon" '.$mark_checked["islands#redIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_2"><img src="/blocks/mapsyandex/edit/template/images/redIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_3" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#darkOrangeIcon" '.$mark_checked["islands#darkOrangeIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_3"><img src="/blocks/mapsyandex/edit/template/images/darkOrangeIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_4" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#nightIcon" '.$mark_checked["islands#nightIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_4"><img src="/blocks/mapsyandex/edit/template/images/nightIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_5" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#darkBlueIcon" '.$mark_checked["islands#darkBlueIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_5"><img src="/blocks/mapsyandex/edit/template/images/darkBlueIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_6" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#pinkIcon" '.$mark_checked["islands#pinkIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_6"><img src="/blocks/mapsyandex/edit/template/images/pinkIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_7" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#grayIcon" '.$mark_checked["islands#grayIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_7"><img src="/blocks/mapsyandex/edit/template/images/grayIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_8" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#brownIcon" '.$mark_checked["islands#brownIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_8"><img src="/blocks/mapsyandex/edit/template/images/brownIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_9" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#darkGreenIcon" '.$mark_checked["islands#darkGreenIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_9"><img src="/blocks/mapsyandex/edit/template/images/darkGreenIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_10" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#violetIcon" '.$mark_checked["islands#violetIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_10"><img src="/blocks/mapsyandex/edit/template/images/violetIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_11" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#blackIcon" '.$mark_checked["islands#blackIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_11"><img src="/blocks/mapsyandex/edit/template/images/blackIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_12" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#yellowIcon" '.$mark_checked["islands#yellowIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_12"><img src="/blocks/mapsyandex/edit/template/images/yellowIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_13" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#greenIcon" '.$mark_checked["islands#greenIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_13"><img src="/blocks/mapsyandex/edit/template/images/greenIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_14" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#orangeIcon" '.$mark_checked["islands#orangeIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_14"><img src="/blocks/mapsyandex/edit/template/images/orangeIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_15" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#lightBlueIcon" '.$mark_checked["islands#lightBlueIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_15"><img src="/blocks/mapsyandex/edit/template/images/lightBlueIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_16" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#oliveIcon" '.$mark_checked["islands#oliveIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_16"><img src="/blocks/mapsyandex/edit/template/images/oliveIcon.png"></label>'.
		'</div>'.					
	'</div>'.							
	'<div class="dan_flex_row e_p_5_20">'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_17" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#blueStretchyIcon" '.$mark_checked["islands#blueStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_17"><img src="/blocks/mapsyandex/edit/template/images/blueStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_18" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#redStretchyIcon" '.$mark_checked["islands#redStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_18"><img src="/blocks/mapsyandex/edit/template/images/redStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_19" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#darkOrangeStretchyIcon" '.$mark_checked["islands#darkOrangeStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_19"><img src="/blocks/mapsyandex/edit/template/images/darkOrangeStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_20" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#nightStretchyIcon" '.$mark_checked["islands#nightStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_20"><img src="/blocks/mapsyandex/edit/template/images/nightStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_21" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#darkBlueStretchyIcon" '.$mark_checked["islands#darkBlueStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_21"><img src="/blocks/mapsyandex/edit/template/images/darkBlueStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_22" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#pinkStretchyIcon" '.$mark_checked["islands#pinkStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_22"><img src="/blocks/mapsyandex/edit/template/images/pinkStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_23" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#grayStretchyIcon" '.$mark_checked["islands#grayStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_23"><img src="/blocks/mapsyandex/edit/template/images/grayStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_24" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#brownStretchyIcon" '.$mark_checked["islands#brownStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_24"><img src="/blocks/mapsyandex/edit/template/images/brownStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_25" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#darkGreenStretchyIcon" '.$mark_checked["islands#darkGreenStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_25"><img src="/blocks/mapsyandex/edit/template/images/darkGreenStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_26" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#violetStretchyIcon" '.$mark_checked["islands#violetStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_26"><img src="/blocks/mapsyandex/edit/template/images/violetStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_27" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#blackStretchyIcon" '.$mark_checked["islands#blackStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_27"><img src="/blocks/mapsyandex/edit/template/images/blackStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_28" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#yellowStretchyIcon" '.$mark_checked["islands#yellowStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_28"><img src="/blocks/mapsyandex/edit/template/images/yellowStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_29" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#greenStretchyIcon" '.$mark_checked["islands#greenStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_29"><img src="/blocks/mapsyandex/edit/template/images/greenStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_30" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#orangeStretchyIcon" '.$mark_checked["islands#orangeStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_30"><img src="/blocks/mapsyandex/edit/template/images/orangeStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_31" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#lightBlueStretchyIcon" '.$mark_checked["islands#lightBlueStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_31"><img src="/blocks/mapsyandex/edit/template/images/lightBlueStretchyIcon.png"></label>'.
		'</div>'.
		'<div>'.
			'<input id="e_block_modal_mapsyandex_points_32" class="input_mapsyandex_points" name="e_block_modal_mapsyandex_points" type="radio" value="islands#oliveStretchyIcon" '.$mark_checked["islands#oliveStretchyIcon"].'>'.
			'<label for="e_block_modal_mapsyandex_points_32"><img src="/blocks/mapsyandex/edit/template/images/oliveStretchyIcon.png"></label>'.
		'</div>'.
	'</div>'.			
'</details>'.
e_block_settings_bg($data).
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>