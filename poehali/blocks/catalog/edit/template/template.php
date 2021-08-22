<?php
defined('AUTH') or die('Restricted access');

// $SITE->setHeadFile('/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/css/imgareaselect-default.css');


function block_catalog($data)
{
	global $SITE;
	$catalog_html = '';
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/main.php';

	$b = $data['content'];
	$wrap_css = $b['max_width'] && $b['max_width'] != 100 ? 'max-width:'.$b['max_width'].'px;' : '';
	$wrap_css .= $b['margin'] != 0 ? 'margin:'.$b['margin'].'px auto;' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	return 
	'<div id="block_'.$data['id'].'" class="block" data-type="block" data-block="catalog" data-id="'.$data['id'].'">'.
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.	
		'</div>'.
		'<div class="block_catalog_wrap" '.$wrap_style.'>'.$catalog_html.'</div>'.
	'</div>';
}
?>