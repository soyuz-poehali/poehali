<?php
defined('AUTH') or die('Restricted access');

$block_id = intval($_POST['id']);

// НАХОДИМ БЛОК
$stmt = $db->prepare("SELECT settings FROM blocks WHERE id = :id AND page_id = 0 AND type = 'menu'");
$stmt->execute(array('id' => $block_id));
if($stmt->rowCount() == 0)
{
	echo json_encode(array('answer' => 'error'));
	exit;	
}
$s = $stmt->fetchColumn();

$BLOCK = unserialize($s);


$menu_type = 'top';

$stmt = $db->query("SELECT id, parent, name FROM menu WHERE menu_type = 'top' ORDER BY ordering ASC");
$db_arr = $stmt->fetchAll();

$tree_out = tree($db_arr);


$content =
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>Пункты меню</h2>'.
$tree_out.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;


function tree($arr, $menu_type = 'top', $parent = 0, $level = 0)
{
	global $db, $qs_arr, $block_id;

	$level++;
	$tree_out = '';
	$menu_out = '';
	$wrap_active = '';

	foreach ($arr as $menu)
	{
		if($menu['parent'] == $parent)
		{
			$menu_out .= '<div class="e_block_menu_'.$level.'">';
			$menu_out .= '<div class="e_block_modal_item flex_row" data-block="menu" data-item-id="'.$menu['id'].'">';
			$menu_out .= 	'<div class="e_block_modal_item_name">'.$menu['name'].'</div>';
			$menu_out .= 	'<div class="e_block_modal_item_ico"><svg class="drag_drop_ico"  data-id="'.$menu['id'].'" data-target-id="e_block_menu_container" data-class="e_block_menu_'.$level.'" data-direction="y"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/sites/edit/template/sprite.svg#cursor_24"></use></svg></div>';			
			$menu_out .= 	'<div class="e_block_modal_item_ico"><svg class="e_block_modal_item_del"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/sites/edit/template/sprite.svg#delete"></use></svg></div>';
			$menu_out .= '</div>';
			$menu_out .= tree($arr, $menu_type, $menu['id'], $level);
			$menu_out .= '</div>';
		}
	}

	if($menu_out != '')
	{
		$tree_out = 
		'<div id="e_block_menu_container" class="e_block_menu_'.$menu_type.'_'.$level.'_wrap'.$wrap_active.'" data-id="'.$block_id.'">'.$menu_out.'</div>'.
		'<table class="e_table_admin e_table_admin_buttons"><tbody>'.
			'<tr>'.
				'<td class="e_td_right"><input id="e_block_modal_send" class="button_green" name="submit" type="submit" value="Сохранить"></td>'.
				'<td><input id="e_block_modal_cancel" class="button_white" name="reset" type="reset" value="Отменить"></td>'.
			'</tr>'.
		'</tbody></table>';
	}

	return $tree_out;
}
?>