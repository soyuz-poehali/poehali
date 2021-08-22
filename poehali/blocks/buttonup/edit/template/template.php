<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/buttonup/frontend/BLOCK.buttonup.css');
$SITE->setHeadFile('/blocks/buttonup/frontend/BLOCK.buttonup.js');

function block_buttonup($data)
{
	global $SITE;
	$content = $data['content'];

	$cpanel =
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
		'</div>';
	
	$out =
	'<div id="block_buttonup" style="width:'.$content['size'].'px; height:'.$content['size'].'px; bottom:'.$content['bottom'].'px; left:'.$content['left'].'px; background-color:'.$content['color'].';" class="block block_buttonup" data-block="buttonup" data-id="'.$data['id'].'">'.
		$cpanel.
		'<div id="block_buttonup_container_'.$data['id'].'" class="block_buttonup_wrap"><svg class="block_blockup_svg" style="width:'.($content['size']/2).'px; height:'.($content['size']/2).'px; margin-top:-'.intval($content['size']/20).'px;"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
	'</div>';

	return $out;
}
?>