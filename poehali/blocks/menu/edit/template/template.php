<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Menu/Menu.php';


function block_menu($data)
{
	global $SITE;
	$content = $data['content'];

	$cpanel =
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="areas" title="Редактируемые области"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
		'</div>';

	if ($content['template'] == 999)
		include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/template/999/template.php';
	else
		include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/template/1/template.php';	

	return $out;
}


function tree($SITE, $MENU, $arr, $parent=0, $level=1)
{
	$tree_out = '';
	$menu_out = '';
	$active = '';

	foreach ($arr as $menu) {
		if ($menu['parent_id'] == $parent) {
			$url = '';

			if ($menu['link_type'] == 'page' || $menu['link_type'] == 'catalog') {
				$u = $MENU->getPageUrl($menu['parameter']);
				$active = $SITE->url == $u ? ' active' : '';
				$url = '/'.$u;
			}

			if ($menu['link_type'] == 'link') {
				$url = $menu['parameter'];
				$active = $SITE->url == $url ? ' active' : '';
			}

			if ($menu['link_type'] != '') {
				// $m = '<span class="block_menu_'.$menu_type.'_'.$level.'_a'.$active.'" onclick="DAN.jumpTo(\''.$block_id.'\')">'.$menu['name'].'</span>';	
				$m = '<a href="'.$url.'" class="block_menu_top_'.$level.'_a'.$active.'">'.$menu['name'].'</a>';
			} else {
				$m = '<span class="block_menu_top_'.$level.'_a'.$active.'">'.$menu['name'].'</span>';	
			}

			$menu_out .= '<div class="block_menu_top_'.$level.$active.'">'.$m;
			$level++;
			$menu_out .= tree($SITE, $MENU, $arr, $menu['id'], $level);
			$level--;
			$menu_out .= '</div>';
		}
	}

	if ($menu_out != '') 
		$tree_out = '<div class="block_menu_top_'.$level.'_wrap">'.$menu_out.'</div>';

	return $tree_out;
}

?>