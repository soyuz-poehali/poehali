<?php
defined('AUTH') or die('Restricted access');

function block_image($data)
{
	global $SITE;

	$dir = '/files/pages/'.$SITE->page['id'].'/image/background/';
	$b = $data['content'];

	switch ($b['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$b['bg_color'].';'; break;
		case 'i': 
			$container_css = 
				'background-image: url(\''.$dir.$b['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($BLOCK->bg_image_size == 'cover')
					$container_css .= 'background-size: cover;';
			break;
		default: $container_css = '';
	}

	if ($b['font_size']) {
		if ($b['font_size'] == 'var(--font-size)')
			$container_css .= 'font-size:'.$b['font_size'].';';
		else 
			$container_css .= 'font-size:'.$b['font_size'].'px;';
	}

	$container_css .= $b['color'] ? 'color:'.$b['color'].';' : '';
	$container_css .= !$b['line_height'] || $b['line_height'] == 1 ? '' : 'line-height:'.($b['line_height'] + 0.2).';';

	$wrap_css = $b['max_width'] && $b['max_width'] != 100 ? 'max-width:'.$b['max_width'].'px;' : '';
	$wrap_css .= $b['margin'] != 0 ? 'margin:'.$b['margin'].'px auto;' : '';

	if ($b['wrap_bg_opacity'] == 1) {
		$wrap_css .= $b['wrap_bg_color'] ? 'background-color:'.$b['wrap_bg_color'].';' : '';
	} else {
		// RGB
		list($R, $G, $B) = sscanf($b['wrap_bg_color'], "#%02x%02x%02x");
		$wrap_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$b['wrap_bg_opacity'].');';
	}

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	// Шаблон вывода 
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/image/frontend/'.$b['style'].'/template.php';		
	$fn = 'block_image_'.$b['style'];
	$image_out = $fn($b);

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-type="block" data-block="image" data-id="'.$data['id'].'">'.
		'<div class="dan_flex_between" '.$wrap_style.'>'.$image_out.'</div>'.
	'</div>';
}
?>