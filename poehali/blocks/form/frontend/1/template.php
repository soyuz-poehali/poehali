<?php
defined('AUTH') or die('Restricted access');

function block_form_1($data)
{
	global $SITE;
	$content = $data['content'];

	$dir = '/files/pages/'.$SITE->page['id'].'/form/background/';

	switch ($content['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
		case 'i':
			$container_css =
				'background-image: url(\''.$dir.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if($content['bg_image_size'] == 'cover')$container_css .= 'background-size: cover;';
			break;
		default: $container_css = '';
	}

	if ($content['font_size']) {
		if($content['font_size'] == 'var(--font-size)')	$container_css .= 'font-size:'.$content['font_size'].';';
		else $container_css .= 'font-size:'.$content['font_size'].'px;';
	}

	$container_css .= $content['color'] ? 'color:'.$content['color'].';' : '';
	$container_css .= !$content['line_height'] || $content['line_height'] == 1 ? '' : 'line-height:'.$content['line_height'].';';

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';
	$wrap_css .= $content['padding'] != 0 ? 'padding:'.$content['padding'].'px;' : '';

	if($content['wrap_bg_opacity'] == 1) {
		$wrap_css .= $content['wrap_bg_color'] ? 'background-color:'.$content['wrap_bg_color'].';' : '';
	} else {
		// RGB
		list($R, $G, $B) = sscanf($content['wrap_bg_color'], "#%02x%02x%02x");
		$wrap_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$content['wrap_bg_opacity'].');';
	}

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	$SITE->setHeadFile('/blocks/form/frontend/1/BLOCK.form_1.css');

	$items_out = '';
	$i = 0;

	foreach ($content['fields'] as $field) {
		$required = $field['required'] == 1 ? 'required' : '';

		if ($field['type'] == 'text' || $field['type'] == 'email') {
			$items_out .= 
			'<div class="block_form_1_wrap e_block_item">'.		
				'<input class="dan_input" name="field['.$i.']" type="'.$field['type'].'" placeholder="'.$field['text'].'" '.$required.'>'.
			'</div>';		
		}

		if ($field['type'] == 'textarea') {
			$items_out .= 
				'<div class="block_form_1_wrap e_block_item">'.
					'<textarea class="dan_input" name="field['.$i.']" placeholder="'.$field['text'].'" '.$required.'></textarea>'.
				'</div>';
		}

		if ($field['type'] == 'checkbox') {
			$class_checkbox = $field['required'] == 1 ? 'block_form_checkbox_1' : 'dan_input';
			$items_out .= 
				'<div class="block_form_1_wrap e_block_item">'.
					'<input id="block_form_'.$data['id'].'_checkbox_'.$i.'" class="'.$class_checkbox.'" name="field['.$i.']" type="checkbox" value="1">'.
					'<label for="block_form_'.$data['id'].'_checkbox_'.$i.'"></label> '.$field['text'].
				'</div>';
		}

		$i++;
	}

	if (count($content['fields']) > 3) {
		$items_out .= '<div class="block_form_1_wrap_submit"><input id="block_form_submit" class="dan_input" name="submit" type="submit" value="'.$content['button_text'].'" style="background-color:'.$content['button_bg_color'].';color:'.$content['button_color'].';"></div>';
	} else {
		$items_out .= '<div class="block_form_1_wrap"><input id="block_form_submit" class="dan_input" name="submit" type="submit" value="'.$content['button_text'].'" style="background-color:'.$content['button_bg_color'].';color:'.$content['button_color'].';"></div>';
	}

	$items_out .= '<input type="hidden" name="block_id" value="'.$data['id'].'">';

	return
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div '.$wrap_style.'>'.
			'<div id="block_form_'.$data['id'].'_container" class="block_form_1_container">'.
				'<div class="block_form_1_text block_form_text">'.$content['text'].'</div>'.
				'<div class="block_form_1_wrap">'.
					'<form method="post" id="block_form_container_'.$data['id'].'" class="relative" action="/block/form/send">'.
						$items_out.
						'<div class="block_form_1_personal_information">'.
							'<input required="" checked="" title="???? ???????????? ???????? ???????????????? ?????????? ??????????????????" type="checkbox">'.
							'?? ???????????????? ???? <a href="/personal_information" target="_blank">?????????????????? ???????????????????????? ????????????</a>'.
						'</div>'.
						'<input name="block_id" type="hidden" value="'.$data['id'].'">'.
						'<input name="refer" type="hidden" value="'.$_SERVER['REQUEST_URI'].'">'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>'.
	'</div>';
}
?>