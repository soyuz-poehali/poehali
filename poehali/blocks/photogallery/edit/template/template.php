<?php
defined('AUTH') or die('Restricted access');

function block_photogallery($data)
{
	global $SITE;

	$dir = '/files/pages/'.$SITE->page['id'].'/photogallery/background/';

	$cpanel =
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="add" title="Добавить изображение"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#add"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.
		'</div>';

	// --- Стили для фона и подложки ---
	switch ($data['content']['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$data['content']['bg_color'].';'; break;
		case 'i':
			$container_css =
				'background-image: url(\''.$dir.$data['content']['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if($data['content']['bg_image_size'] == 'cover')$container_css .= 'background-size: cover;';
			break;
		default: $container_css = '';
	}

	if ($data['content']['font_size']) {
		if($data['content']['font_size'] == 'var(--font-size)')	
			$container_css .= 'font-size:'.$data['content']['font_size'].';';
		else 
			$container_css .= 'font-size:'.$data['content']['font_size'].'px;';
	}

	$container_css .= $data['content']['color'] ? 'color:'.$data['content']['color'].';' : '';
	$container_css .= !$data['content']['line_height'] || $data['content']['line_height'] == 1.2 ? '' : 'line-height:'.$data['content']['line_height'].';';

	$wrap_css = $data['content']['max_width'] && $data['content']['max_width'] != 100 ? 'max-width:'.$data['content']['max_width'].'px;' : '';
	$wrap_css .= $data['content']['margin'] != 0 ? 'margin:'.$data['content']['margin'].'px auto;' : '';

	if ($data['content']['wrap_bg_opacity'] == 1) {
		$wrap_css .= $data['content']['wrap_bg_color'] ? 'background-color:'.$data['content']['wrap_bg_color'].';' : '';
	} else {
		// RGB
		list($R, $G, $B) = sscanf($data['content']['wrap_bg_color'], "#%02x%02x%02x");
		$wrap_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$data['content']['wrap_bg_opacity'].');';
	}

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	// --- Тип 1 ---
	switch ($data['content']['style']) {
		case 1 :
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/template/1/template.php';
			$photos = block_photogallery_1($data);
			break;
		case 2 :
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/template/2/template.php';
			$photos = block_photogallery_2($data);
			break;
		case 3 :
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/template/3/template.php';
			$photos = block_photogallery_3($data);
			break;
	}

	$out =
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-block="photogallery" data-id="'.$data['id'].'">'.
		$cpanel.
		'<div '.$wrap_style.'><div id="block_photogallery_container_'.$data['id'].'" class="dan_flex_center relative">'.$photos.'</div></div>'.
		'<script>'.
			'DAN.show("block_photogallery_photo_'.$data['content']['style'].'_image", "block_photogallery_container_'.$data['id'].'");'.
		'</script>'.
	'</div>';

	return $out;
}
?>