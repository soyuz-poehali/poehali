<?php
defined('AUTH') or die('Restricted access');

function block_text($block)
{
	global $SITE;
	$b = $block['content'];

	$dir = '/files/pages/'.$SITE->page['id'].'/text';

	$css_container = '';
	
	switch ($b['bg_type']) {
		case '1': $css_container = 'background-color: var(--color-1);'; break;
		case '2': $css_container = 'background-color: var(--color-2);'; break;
		case '3': $css_container = 'background-color: var(--color-3);'; break;
		case 'c': $css_container = 'background-color: '.$b['bg_color'].';'; break;
		case 'i':
			$css_container =
				'background-image: url(\''.$dir.'/background/'.$b['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($b['bg_image_size'] == 'cover')
					$css_container .= 'background-size: cover;';
			break;
		default: 
			$css_container = '';
	}

	if ($b['font_size']) {
		if ($b['font_size'] == 'var(--font-size)')
			$css_container .= 'font-size:'.$b['font_size'].';';
		else 
			$css_container .= 'font-size:'.$b['font_size'].'px;';
	}

	$css_container .= $b['color'] ? 'color:'.$b['color'].';' : '';
	$css_container .= !$b['line_height'] || $b['line_height'] == 1 ? '' : 'line-height:'.($b['line_height'] + 0.2).';';

	$css_wrap = $b['max_width'] && $b['max_width'] != 100 ? 'max-width:'.$b['max_width'].'px;' : '';
	$css_wrap .= $b['margin'] != 0 ? 'margin:'.$b['margin'].'px auto;' : '';
	$css_wrap .= $b['padding'] != 0 ? 'padding:'.$b['padding'].'px;' : '';

	if($b['wrap_bg_opacity'] == 1)
		$css_wrap .= $b['wrap_bg_color'] ? 'background-color:'.$b['wrap_bg_color'].';' : '';
	else {
		// RGB
		list($R, $G, $B) = sscanf($b['wrap_bg_color'], "#%02x%02x%02x");
		$css_wrap .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$b['wrap_bg_opacity'].');';
	}

	$style_container = $css_container != '' ? 'style="'.$css_container.'"' : '';
	$style_wrap = $css_wrap != '' ? 'style="'.$css_wrap.'"' : '';

	return
	'<div id="block_'.$block['id'].'" class="block" '.$style_container.' data-type="block" data-block="text" data-id="'.$block['id'].'">'.
		'<div '.$style_wrap.'>'.$b['text'].'</div>'.
	'</div>';
}
?>