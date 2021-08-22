<?php
defined('AUTH') or die('Restricted access');


function block_php_code($data)
{
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/frontend/files/'.$data['content']['file_name'];
	$func = substr($data['content']['file_name'], 0, strlen($data['content']['file_name']) - 4);

	if (function_exists($func))
		$func_out = $func();
	else
		$func_out = '';

	return
	'<div id="block_'.$data['id'].'" class="block" data-type="block" data-block="php_code" data-id="'.$data['id'].'">'.
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="edit" title="Редактировать код"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="help" title="Помощь"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#help"></use></svg></div>'.
		'</div>'.
		'<div style="min-height:50px;">'.$func_out.'</div>'.
	'</div>';
}
?>