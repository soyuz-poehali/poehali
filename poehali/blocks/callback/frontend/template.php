<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/callback/frontend/BLOCK.callback.css');
$SITE->setHeadFile('/blocks/callback/frontend/BLOCK.callback.js');

function block_callback($data)
{
	global $SITE;
	$content = $data['content'];

	$path = $_SERVER['DOCUMENT_ROOT'].'/lib/svg/phone-3.svg';
	$svg = file_get_contents($path);

	$html =
	'<div onclick="BLOCK.callback.form('.$data['id'].')" id="block_'.$data['id'].'" style="width:'.($content['size'] * 2).'px; height:'.($content['size'] * 2).'px; bottom:'.($content['bottom'] * 2).'px; right:'.($content['right'] * 2).'px;" class="block block_callback">'.
		'<div id="block_callback_container_'.$data['id'].'" class="block_calltoorder_circle" style="background-color:'.$content['color'].'">'.$svg.'</div>'.
		'<div class="block_calltoorder_circle_wave_out" style="background-color:'.$content['color'].'"></div>'.
		'<div class="block_calltoorder_circle_wave_in" style="border-color:'.$content['color'].'"></div>'.
	'</div>';

	return $html;
}
?>