<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/sites/blocks/menu/class/BlockMenu.php';

$block_id = intval($_POST['id']);
$menu = $_POST['menu'];

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

$menu_arr = explode(',', $menu);

$ordering = 1;
foreach($menu_arr as $menu_id)
{
	$stmt = $db->prepare("UPDATE menu SET ordering = :ordering WHERE id = :id AND site_id = :site_id");
	$stmt->execute(array('ordering' => $ordering ,'id' => $menu_id, 'site_id' => $site_id));
	
	$ordering++;
}

echo json_encode(array('answer' => 'success'));

exit;

?>