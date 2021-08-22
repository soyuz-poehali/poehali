<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadCode('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');
$SITE->setHeadFile('/blocks/mapsyandex/frontend/BLOCK.mapsyandex.js');

function block_mapsyandex($data)
{
	global $SITE;
	$content = $data['content'];

	$dir = '/files/pages/'.$SITE->page['id'].'/mapsyandex/background/';

	// --- Стили для фона и подложки ---
	switch ($content['bg_type']) {
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
		if($content['font_size'] == 'var(--font-size)')	
			$container_css .= 'font-size:'.$content['font_size'].';';
		else 
			$container_css .= 'font-size:'.$content['font_size'].'px;';
	}

	$container_css .= $content['color'] ? 'color:'.$content['color'].';' : '';
	$container_css .= !$content['line_height'] || $content['line_height'] == 1.2 ? '' : 'line-height:'.$content['line_height'].';';

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= 'height:'.$content['height'].'px;';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';
	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = 'style="'.$wrap_css.'"';


	// Точки на карте
	if (isset($content['points'])) 
		$points_arr = 'var points_arr = '.json_encode($content['points']).';';
	else 
		$points_arr = 'var points_arr = false;';

	$out =
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div id="block_mapsyandex_'.$data['id'].'" '.$wrap_style.'></div>'.
		'<script>'.
			$points_arr.
			'var coordinate = ['.$content['coordinate'][0].', '.$content['coordinate'][1].'];'.
			'BLOCK.mapsyandex.run("block_mapsyandex_'.$data['id'].'", coordinate, '.$content['zoom'].', points_arr, "'.$content['mark_type'].'");'.
		'</script>'.		
	'</div>';

	return $out;
}
?>