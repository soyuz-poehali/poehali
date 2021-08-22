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
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/template/1/template.php';
			$video_out = block_video_1($data);
			$flex_between = 'class="dan_flex_between"';
			break;		
		case 2 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/template/2/template.php';
			$video_out = block_video_2($data);
			break;		
	}

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-type="block" data-block="video" data-id="'.$data['id'].'">'.
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="add" title="Добавить видео"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#add"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="copy" title="Копировать"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#copy"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.			
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.	
		'</div>'.
		'<div id="block_video_container_'.$data['id'].'" data-id="'.$data['id'].'" '.$flex_between.' '.$wrap_style.'>'.$video_out.'</div>'.
	'</div>';
}
?>