<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/sites/blocks/menu/class/BlockMenu.php';

$block_id = intval($_POST['block_id']);
// $page_id = intval($_POST['page_id']);
$menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : false;
$name = trim(htmlspecialchars(strip_tags($_POST['name'])));
$menu_url = trim(htmlspecialchars(strip_tags($_POST['menu_url'])));

// НАХОДИМ БЛОК
$stmt = $db->prepare("SELECT settings FROM blocks WHERE id = :id AND site_id = :site_id AND page_id = 0 AND type = 'menu'");
$stmt->execute(array('id' => $block_id, 'site_id' => $site_id));
if($stmt->rowCount() == 0)
{
	echo json_encode(array('answer' => 'error', 'content' => 'Page not found'));
	$SITE->errLog('Не найден block_id => '.$block_id.' для сайта site_id => '.$site_id.', cтраница => 0 (menu), пользователь => '.$USER->auth());
	exit;
}
$s = $stmt->fetchColumn();
$BLOCK = unserialize($s);

// Если тип menu_url - блок, добавляем страницу перед блоком - p/page_id/#block_id
/*
if($menu_url[0] == '#')
{
	$menu_url = 'p/'.$page_id.'/'.$menu_url;
}
*/

if(!$menu_id) // Добавить пункт меню	
{
	$stmt_m = $db->prepare("SELECT MAX(ordering) max_ordering FROM menu WHERE site_id = :site_id");
	$stmt_m->execute(array('site_id' => $site_id));
	$ordering = $stmt_m->fetchColumn() + 1;	

	$stmt_insert = $db->prepare("INSERT INTO menu SET site_id = :site_id, parent = 0, ordering = :ordering, name = :name, data = :menu_url");
	$stmt_insert->execute(array('site_id' => $site_id, 'ordering' => $ordering, 'name' => $name, 'menu_url' => $menu_url));
}
else // Обновить пункт меню
{
	$stmt_update_m = $db->prepare("UPDATE menu SET name = :name, data = :menu_url WHERE id = :menu_id AND site_id = :site_id LIMIT 1");
	$stmt_update_m->execute(array('menu_id' => $menu_id, 'site_id' => $site_id, 'name' => $name, 'menu_url' => $menu_url));	
}

$settings = serialize($BLOCK);

$stmt_update_b = $db->prepare("UPDATE blocks SET settings = :settings WHERE id = :block_id AND site_id = :site_id");
$stmt_update_b->execute(array('settings' => $settings, 'block_id' => $block_id, 'site_id' => $site_id));

echo json_encode(array('answer' => 'success'));
exit;

?>