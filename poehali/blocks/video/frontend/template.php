<?php
defined('AUTH') or die('Restricted access');

function block_video($data)
{
	global $SITE;

	$content = $data['content'];

	$dir = '/files/pages/'.$SITE->page['id'].'/video/background/';

	switch ($content['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
		case 'i': 
			$container_css = 
				'background-image: url(\''.$dir.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if($content['bg_image_size'] == 'cover') $container_css .= 'background-size: cover"';
			break;
		default: $container_css = '';
	}

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';

	if ($content['wrap_bg_opacity'] == 1) {
		$wrap_css .= $content['wrap_bg_color'] ? 'background-color:'.$content['wrap_bg_color'].';' : '';
	} else {
		// RGB
		list($R, $G, $B) = sscanf($content['wrap_bg_color'], "#%02x%02x%02x");
		$wrap_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$content['wrap_bg_opacity'].');';
	}

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	// Тип вывода
	$flex_between = '';
	switch ($content['style']) {
		case 1 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/video/frontend/1/template.php';
			$video_out = block_video_1($data);
			$flex_between = 'class="dan_flex_between"';
			break;		
		case 2 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/video/frontend/2/template.php';
			$video_out = block_video_2($data);
			break;		
	}

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div id="block_video_container_'.$data['id'].'" '.$flex_between.' '.$wrap_style.'>'.$video_out.'</div>'.
	'</div>';
}
?>