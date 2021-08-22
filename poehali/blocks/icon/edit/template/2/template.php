<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/icon/frontend/2/BLOCK.icon_2.css');

function block_icon_2($data)
{
	global $SITE;
	$content = $data['content'];

	$item_style	= '';
	$item_css = '';
	
	if ($content['wrap_bg_color']) {
		if ($content['wrap_bg_opacity'] == 1) {
			$item_css .= 'background-color:'.$content['wrap_bg_color'].';padding:20px;';
		} else {
			// RGB
			list($R, $G, $B) = sscanf($content['wrap_bg_color'], "#%02x%02x%02x");
			$item_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$content['wrap_bg_opacity'].');padding:20px;';
		}
	}

	if($content['padding'] > 0) 
		$item_css .= 'margin:'.$content['padding'].'px;';
	
	if($item_css != '')	
		$item_style	= 'style="'.$item_css.'"';
	
	
	$item_wrap_css = '';
	$css_border = '';
	if ($content['padding'] != 0) {
		$item_wrap_css .= 'padding:'.$content['padding'].'px;';
		if($content['padding'] > 3) 
			$css_border = 'block_icon_icon_border';
	}
	
	// --- Items ---
	$icons = '';
	$i = 1;

	foreach ($content['icons'] as $icon) {
		$path = $_SERVER['DOCUMENT_ROOT'].'/lib/svg/'.$icon['icon'].'.svg';
		$svg = file_get_contents($path);

		if(!strpos($svg, 'viewBox')) $view_box = 'viewBox="0 0 24 24"';
		else $view_box = '';

		$replace = 'svg class="block_icon_item_svg" style="fill:'.$content['icon_color'].';width:'.($content['icon_size'] / 2).'px;height:'.($content['icon_size'] / 2).'px;top:'.($content['icon_size'] / 4).'px;left:'.($content['icon_size'] / 4).'px;" '.$view_box;

		$svg_out = str_replace('svg ', $replace, $svg);
		
		if($content['icon_color'] == '#ffffff') $hover_color = '#444444';
		else $hover_color = $content['icon_color'];

		$cpanel_item =
			'<div class="e_item_panel">'.
				'<div class="e_block_panel_ico" data-action="icon_edit" title="Редактировать"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
				'<div class="drag_drop_ico" title="Перетащить" data-id="'.$data['id'].'" data-target-id="block_icon_container_'.$data['id'].'" data-class="block_icon_item_2" data-f="EDIT.block.icon.update_ordering"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
				'<div class="e_block_panel_ico" data-action="icon_delete" title="Удалить"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'</div>';

			$item_wrap_style = $item_wrap_css != '' ? 'style="'.$item_wrap_css.'"' : '';
			$icons .=
				'<div class="block_icon_item_2 e_block_item" '.$item_style.' data-block="icon" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
					$cpanel_item.
					'<div class="block_icon_item_svg_wrap" style="border-color:'.$content['icon_color'].';width:'.$content['icon_size'] .'px;height:'.$content['icon_size'].'px;">'.
						'<div class="block_icon_item_svg_hover" style="background-color:'.$hover_color.';"></div>'.
						$svg_out.
					'</div>'.
					'<div class="block_icon_item_title" style="font-size:'.$content['title_size'].'px;">'.$icon['text_1'].'</div>'.
					'<div class="block_icon_item_text">'.$icon['text_2'].'</div>'.
				'</div>';
		$i++;
	}

	return $icons;
}
?>