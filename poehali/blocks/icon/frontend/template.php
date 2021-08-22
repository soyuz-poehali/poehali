<?php
defined('AUTH') or die('Restricted access');

function block_icon($data)
{
	global $SITE;
	$content = $data['content'];

	$dir = '/files/pages/'.$SITE->page['id'].'/icon/background/';

	// --- Стили для фона и подложки ---
	switch($content['bg_type'])
	{
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
		case 'i':
			$container_css =
				'background-image: url(\''.$dir.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($content['bg_image_size'] == 'cover')
					$container_css .= 'background-size: cover;';
			break;
		default: $container_css = '';
	}

	if ($content['font_size']) {
		if ($content['font_size'] == 'var(--font-size)')	
			$container_css .= 'font-size:'.$content['font_size'].';';
		else 
			$container_css .= 'font-size:'.$content['font_size'].'px;';
	}

	$container_css .= $content['color'] ? 'color:'.$content['color'].';' : '';
	$container_css .= !$content['line_height'] || $content['line_height'] == 1.2 ? '' : 'line-height:'.($content['line_height']).';';

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	switch ($content['style']) {
		case 1 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/icon/frontend/1/template.php';
			$icons = block_icon_1($data);
			break;		
		case 2 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/icon/frontend/2/template.php';
			$icons = block_icon_2($data);
			break;
		case 3 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/icon/frontend/3/template.php';
			$icons = block_icon_3($data);
			break;		
	}

	$html =
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div '.$wrap_style.'><div id="block_icon_container_'.$data['id'].'" class="dan_flex_center relative">'.$icons.'</div></div>'.
	'</div>';

	return $html;
}
?>