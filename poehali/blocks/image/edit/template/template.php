<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/css/imgareaselect-default.css');
$SITE->setHeadFile('/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/scripts/jquery.min.js');
$SITE->setHeadFile('/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/scripts/jquery.imgareaselect.min.js');
$SITE->setHeadFile('/lib/IMAGE_RESIZE/IMAGE_RESIZE.css');
$SITE->setHeadFile('/lib/IMAGE_RESIZE/IMAGE_RESIZE.js');


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
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/template/'.$b['style'].'/template.php';		
	$fn = 'block_image_'.$b['style'];
	$image_out = $fn($b);

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-type="block" data-block="image" data-id="'.$data['id'].'">'.
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="edit_image" title="Редактировать изображение"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#image_2"></use></svg></div>'.		
			'<div class="e_block_panel_ico" data-action="edit_text" title="Редактировать текст"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#text"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="copy" title="Копировать"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#copy"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.	
		'</div>'.
		'<div class="dan_flex_between" '.$wrap_style.'>'.$image_out.'</div>'.
	'</div>';
}
?>