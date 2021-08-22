<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Catalog/Catalog.php';
$BLOCK_E = new BlockEdit;
$CATALOG = new Catalog;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$wrap_width_select_100 = $wrap_width_select_1600 = $wrap_width_select_1440 = $wrap_width_select_1280 = $wrap_width_select_600 = '';

switch ($content['max_width']) {
	case '100': $wrap_width_select_100 = 'selected'; break;
	case '1600': $wrap_width_select_1600 = 'selected'; break;
	case '1440': $wrap_width_select_1440 = 'selected'; break;
	case '1280': $wrap_width_select_1280 = 'selected'; break;
	case '600': $wrap_width_select_600 = 'selected'; break;
	default: $wrap_width_select_custom = 'selected'; break;
}

$arr = array(100, 1600, 1440, 1280, 600);
$wrap_width_select_custom_option = !in_array($content['max_width'], $arr) ? '<option value="'.$content['max_width'].'" '.$wrap_width_select_custom.'>'.$content['max_width'].'</option>' : '';

$catalogs = $CATALOG->getCatalogs();

$option_html = '';
$selected = '';
foreach ($catalogs as $catalog) {
	if ($content['catalog_id'] == $catalog['id'])
		$selected = 'selected';
	$option_html .= '<option value="'.$catalog['id'].'" '.$selected.'>'.$catalog['name'].'</option>';
}

$content =
'<h2>Настройки блока</h2>'.
'<div>'.
	'<table class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Максимальная ширина</td>'.
			'<td>'.
				'<select id="e_block_modal_max_width" class="dan_input">'.
					'<option value="100" '.$wrap_width_select_100.'>100%</option>'.
					'<option value="1600" '.$wrap_width_select_1600.'>1600px</option>'.
					'<option value="1440" '.$wrap_width_select_1440.'>1440px</option>'.
					'<option value="1280" '.$wrap_width_select_1280.'>1280px</option>'.
					'<option value="600" '.$wrap_width_select_600.'>600px</option>'.
					$wrap_width_select_custom_option.
				'</select>'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Отступ</td>'.
			'<td><input id="e_block_modal_margin" class="dan_input" type="number" min="0" max="100" value="'.$content['margin'].'"></td>'.
		'</tr>'.
	'</table>'.
'</div>'.
'<table id="e_block_modal_icon_options" class="e_table_admin">'.
	'<tr>'.
		'<td class="e_td_right">Выбрать каталог</td>'.
		'<td>'.
			'<select id="e_block_modal_catalog_id" name="style" class="dan_input">'.
				$option_html.
			'</select>'.
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
'<input type="hidden" name="id" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $content));

exit;

?>