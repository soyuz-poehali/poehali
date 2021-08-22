<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/sites/blocks/menu/class/BlockMenu.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/sites/edit/block/check_page_block.php';

$block_id = intval($_POST['block_id']);
$url = trim(htmlspecialchars(strip_tags($_POST['url'])), '/');
$menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : false;

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

// НАХОДИМ ТЕКУЩИЙ $SITE->page_id
$stmt = $db->prepare("SELECT id FROM pages WHERE site_id = :site_id AND url = :url");
$stmt->execute(array('site_id' => $site_id, 'url' => $url));
if($stmt->rowCount() > 0 && $SITE)
{
	$SITE->page_id = $stmt->fetchColumn();
}
else
{
	header("HTTP/1.0 404 Not Found");
	include($_SERVER['DOCUMENT_ROOT'].'/404.php');
	exit;
}


// ДЕЙСТВИЯ
if($SITE->d[3] == 'menu_add')
{
	$title = 'Добавить пункт меню';
	$name = '';
	$url = '';
	$menu_id_input = '';
	$url_name = 'Ссылка';
	$url_out = '';
	$url_value = '';
}

if($SITE->d[3] == 'menu_edit')
{
	$title = 'Редактировать пункт меню';

	$stmt_m = $db->prepare("SELECT name, data FROM menu WHERE id = :id AND site_id = :site_id LIMIT 1");
	$stmt_m->execute(array('id' => $menu_id, 'site_id' => $site_id));
	$menu = $stmt_m->fetch();
	
	$name = $menu['name'];
	$url_value = $menu['data'];
	
	// Определяем тип меню
	$p_arr = explode('/', $menu['data']);
	$b_arr = explode('#', $menu['data']);

	$null_select = $page_select = $block_select = $url_select = '';
	
	if($menu['data'] == '' || $menu['data'] == '/')
	{
		$url_name = 'Страница';
		$url_out = 'Главная страница';		
	}
	elseif(count($p_arr) > 1 && $p_arr[0] == 'p' && count($b_arr) > 1) // Блок на странице
	{
		$page_id = $p_arr[1];
		$block_id = str_ireplace('block_', '', $b_arr[1]);
	
		$stmt_p = $db->prepare("SELECT title FROM pages WHERE id = :id AND site_id = :site_id");
		$stmt_p->execute(array('id' => $page_id, 'site_id' => $site_id));
		$page_name = $stmt_p->fetchColumn();
		
		$stmt_b = $db->prepare("SELECT ordering FROM blocks WHERE id = :block_id AND site_id = :site_id AND page_id = :page_id");
		$stmt_b->execute(array('block_id' => $block_id, 'site_id' => $site_id, 'page_id' => $page_id));
		$ordering = $stmt_b->fetchColumn();

		$url_name = 'Блок';
		$url_out = '№ '.$ordering.' на странице '.$page_name;
	}
	elseif($p_arr[0] == 'p') // Страница
	{
		$page_id = $p_arr[1];		
		$stmt_p = $db->prepare("SELECT title FROM pages WHERE id = :id AND site_id = :site_id");
		$stmt_p->execute(array('id' => $page_id, 'site_id' => $site_id));
		$page_name = $stmt_p->fetchColumn();

		$url_name = 'Страница';
		$url_out = $page_name;		
	}
	else
	{
		$url_name = 'Ссылка';
		$url_out = $menu['data'];		
	}
}

// Находим страницы
$stmt_p = $db->prepare("SELECT id, title FROM pages WHERE site_id = :site_id ORDER BY ordering");
$stmt_p->execute(array('site_id' => $site_id));

$pages_out = '';
$i = 1;
while($page = $stmt_p->fetch())
{
	$pages_out .= '<div class="e_block_modal_pages_item" data-id="'.$page['id'].'" data-title="'.$page['title'].'">'.$i.'. &nbsp; '.$page['title'].'</div>';
	$i++;
}

$content =
'<div id="e_block_modal_pages_out" style="display:none;">'.$pages_out.'</div>'. // Список страниц
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>'.$title.'</h2>'.
'<table id="e_block_modal_menu_options" class="e_table_admin">'.
	'<tr>'.
		'<td class="e_td_r">Пункт меню</td>'.
		'<td>'.
			'<input id="e_block_modal_menu_name" class="input" type="text" value="'.$name.'">'.
		'</td>'.
	'</tr>'.
	'<tr>'.
		'<td id="e_block_modal_menu_description" class="e_td_r">'.$url_name.'</td>'.
		'<td>'.
			'<div id="e_block_modal_menu_out" class="e_inline_block">'.
				$url_out.
			'</div>'.
			'<div class="e_inline_block">'.
				'<select id="e_block_modal_menu_type" class="input">'.
					'<option value="">Выбрать:</option>'.
					'<option value="page">Страница</option>'.
					'<option value="block">Блок</option>'.
					'<option value="url">Cсылка</option>'.
				'</select>'.
			'</div>'.
		'</td>'.
	'</tr>'.
'</table>'.
'<input id="e_block_modal_menu_url" type="hidden" value="'.$url_value.'">'.
'<table class="e_table_admin e_table_admin_buttons" style="margin-top:20px;">'.
	'<tr>'.
		'<td class="e_td_r"><input id="e_block_menu_modal_send" class="button_green" name="submit" type="submit" value="Сохранить"></td>'.
		'<td><input id="e_block_menu_modal_cancel" class="button_white" name="reset" type="reset" value="Отменить"></td>'.
	'</tr>'.
'</table>'.
'</div>'
;

echo json_encode(array('answer' => 'success', 'content' => $content, 'p' => $SITE->page_id));

exit;

?>