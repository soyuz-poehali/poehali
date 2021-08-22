<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/DAN/hexToRGB/hexToRGB.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/link_page_block.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = $_POST['num'];
$button_num = $_POST['button_num'];

$content = $BLOCK_E->getBlock($id)['content'];

$video = $content['videos'][$num - 1];

$s_1 = $s_2 = '';

if ($video['ratio'] == 1) 
	$s_1 = 'selected';

if ($video['ratio'] == 2) 
	$s_2 = 'selected';

$button = 'button_'.$button_num;

if (!isset($video[$button])) {
	$video[$button] = array();
	$video[$button]['on'] = 1;
	$video[$button]['text'] = 'Подробнее';
	$video[$button]['link'] = '/';
	$video[$button]['bg_color'] = $SITE->settings->color_3;
	$video[$button]['text_color'] = $SITE->settings->font_color;
	$video[$button]['style'] = 'solid';
	$video[$button]['radius'] = 0;	
}


$on = $video[$button]['on'] == 1 ? 'checked' : '';
$type_selected['solid'] = $type_selected['border'] = '';
$type_selected[$video[$button]['style']] = 'selected';

$pb_arr = link_page_block($video[$button]['link']);

// Цвета из css
$css_file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/style.css', true);
preg_match("/\--\w*-1:\srgb\((.*)\)/", $css_file, $matches_1);
preg_match("/\--\w*-2:\srgb\((.*)\)/", $css_file, $matches_2);
preg_match("/\--\w*-3:\srgb\((.*)\)/", $css_file, $matches_3);

$color_1 = rgb_to_hex($matches_1[1]);
$color_2 = rgb_to_hex($matches_2[1]);
$color_3 = rgb_to_hex($matches_3[1]);

if ($video[$button]['bg_color'] == 'var(--color-1)')
	$video[$button]['bg_color'] = $color_1;

if ($video[$button]['bg_color'] == 'var(--color-2)')
	$video[$button]['bg_color'] = $color_2;

if ($video[$button]['bg_color'] == 'var(--color-3)')
	$video[$button]['bg_color'] = $color_3;

$content =
	'<div style="position:relative">'.
		$pb_arr['pages'].
		'<div>'.
			'<h2>Кнопкa '.$button_num.'</h2>'.
			'<div class="dan_modal_wrap">'.
				'<div class="e_str_left e_flex_basis_100">Вкл./выкл.:</div>'.
				'<div class="e_str_right">'.
					'<div class="e_flex_center_h">'.
						'<input id="e_block_modal_on" class="dan_input" type="checkbox" name="button" value="1" '.$on.'>'.
						'<label for="e_block_modal_on"></label>'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="dan_modal_wrap">'.
				'<div class="e_str_left e_flex_basis_100">Текст:</div>'.
				'<div class="e_str_right">'.
					'<div class="e_flex_center_h">'.
						'<input id="e_block_modal_text" class="dan_input" type="text" name="text" value="'.$video[$button]['text'].'">'.
					'</div>'.
				'</div>'.
			'</div>'.
			$pb_arr['link'].
			'<div class="dan_modal_wrap">'.
				'<div class="e_str_left e_flex_basis_100">Цвет кнопки:</div>'.
				'<div class="e_str_right">'.
					'<div class="e_flex_center_h">'.
						'<input id="e_block_modal_bg_color" class="dan_input" type="color" value="'.$video[$button]['bg_color'].'">'.
						'<input id="e_block_modal_bg_color_hidden" type="hidden" value="'.$video[$button]['bg_color'].'">'.
						'<div id="e_block_modal_bg_color_wrap" class="e_block_modal_color_round_wrap">'.
							'<div class="e_block_modal_color_round" style="background-color:var(--color-1)" data-color_var="var(--color-1)" data-color="'.$color_1.'"></div>'.
							'<div class="e_block_modal_color_round" style="background-color:var(--color-2)" data-color_var="var(--color-2)" data-color="'.$color_2.'"></div>'.
							'<div class="e_block_modal_color_round" style="background-color:var(--color-3)" data-color_var="var(--color-3)" data-color="'.$color_3.'"></div>'.
						'</div>'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="dan_modal_wrap">'.
				'<div class="e_str_left e_flex_basis_100">Цвет текста:</div>'.
				'<div class="e_str_right">'.
					'<div class="e_flex_center_h">'.
						'<input id="e_block_modal_text_color" class="dan_input" type="color" value="'.$video[$button]['text_color'].'">'.
						'<input id="e_block_modal_text_color_hidden" type="hidden" value="'.$video[$button]['text_color'].'">'.
						'<div id="e_block_modal_text_color_wrap" class="e_block_modal_color_round_wrap">'.
							'<div class="e_block_modal_color_round" style="background-color:var(--color-1)" data-color_var="var(--color-1)" data-color="'.$color_1.'"></div>'.
							'<div class="e_block_modal_color_round" style="background-color:var(--color-2)" data-color_var="var(--color-2)" data-color="'.$color_2.'"></div>'.
							'<div class="e_block_modal_color_round" style="background-color:var(--color-3)" data-color_var="var(--color-3)" data-color="'.$color_3.'"></div>'.
						'</div>'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="dan_modal_wrap">'.
				'<div class="e_str_left e_flex_basis_100">Тип:</div>'.
				'<div class="e_str_right">'.
					'<div class="e_flex_center_h">'.
						'<select id="e_block_modal_style" class="dan_input">'.
							'<option value="solid" '.$type_selected['solid'].'>Сплошная заливка</option>'.
							'<option value="border" '.$type_selected['border'].'>Обводка</option>'.
						'</select>'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="dan_modal_wrap">'.
				'<div class="e_str_left e_flex_basis_100">Радиус:</div>'.
				'<div class="e_str_right">'.
					'<div class="e_flex_center_h">'.
						'<input id="e_block_modal_radius" class="dan_input" type="number" name="link" value="'.$video[$button]['radius'].'">'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="e_modal_wrap_buttons">'.
				'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
				'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
			'</div>'.
		'</div>'.
	'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>