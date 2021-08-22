<?php
defined('AUTH') or die('Restricted access');

function block_form($data)
{
	global $SITE;
	
	$cpanel = 
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="text" title="Редактировать текст"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#text"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="field_add" title="Добавить поле"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#add"></use></svg></div>'.
			// '<div class="e_block_panel_ico" data-action="fields" title="Поля"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#form"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering" title="Перетащить блок"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.	
		'</div>';

	$fields = '';
	$i = 0;

	// --- СТИЛЬ ---
	switch ($data['content']['style']) {
		case '1': 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/template/1/template.php';
			$out = block_form_1($data, $cpanel);
			break;
		case '2': 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/template/2/template.php';
			$out = block_form_2($data, $cpanel);
			break;
	}

	return $out;
}
?>