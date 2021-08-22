<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/case_2/edit/template/edit.css');

function block_case_2($data)
{
	global $SITE;
	$content = $data['content'];

	switch ($content['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
		case 'i': 
			$container_css = 
				'background-image: url(\'/blocks/case_2/background/'.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if($content['bg_image_size'] == 'cover') $container_css .= 'background-size: cover"';
			break;
		default: $container_css = '';
	}

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	// Тип вывода
	$flex_between = '';
	switch ($content['style']) {
		case 1 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/case_2/frontend/1/template.php';
			$case_out = block_case_2_1($data);
			break;		
	}

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div id="block_case_2_container_'.$data['id'].'" class="block_case_2_container dan_flex_row" '.$wrap_style.'>'.$case_out.'</div>'.
	'</div>';
}
?>