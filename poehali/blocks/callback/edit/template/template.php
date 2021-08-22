<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/callback/frontend/BLOCK.callback.css');
$SITE->setHeadFile('/blocks/callback/frontend/BLOCK.callback.js');

function block_callback($data)
{
	global $SITE;
	$content = $data['content'];

	$cpanel =
	'<div class="e_block_panel">'.
		'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
		'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
	'</div>';

	$path = $_SERVER['DOCUMENT_ROOT'].'/lib/svg/phone-3.svg';
	$svg = file_get_contents($path);

	$html =
	'<div onclick="BLOCK.callback.form('.$data['id'].')" id="block_'.$data['id'].'" style="width:'.($content['size'] * 2).'px; height:'.($content['size'] * 2).'px; bottom:'.($content['bottom'] * 2).'px; right:'.($content['right'] * 2).'px;" class="block block_callback" data-block="callback" data-id="'.$data['id'].'">'.
		$cpanel.
		'<div id="block_callback_container_'.$data['id'].'" class="block_calltoorder_circle" style="background-color:'.$content['color'].'">'.$svg.'</div>'.
		'<div class="block_calltoorder_circle_wave_out" style="background-color:'.$content['color'].'"></div>'.
		'<div class="block_calltoorder_circle_wave_in" style="border-color:'.$content['color'].'"></div>'.
	'</div>';

	return $html;
}
?>