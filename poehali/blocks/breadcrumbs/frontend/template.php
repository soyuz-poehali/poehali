<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/breadcrumbs/frontend/BLOCK.breadcrumbs.css');


if (!isset($MENU)) {
	include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Menu/Menu.php';
	$MENU = new Menu;
}

$menu_arr = $MENU->getMenu();
// Перебираем весь массив и находим id текущего пункта меню
$current_menu_id = 0;

foreach ($menu_arr as $menu_item) {
	if ($menu_item['parameter'] == $SITE->page['id'] && ($menu_item['link_type'] == 'page' || $menu_item['link_type'] == 'catalog')) {
		$current_menu = $menu_item;
	}
}


$breadcrumbs_arr = false;
switch ($current_menu['link_type']) {
	case 'page':
		$b_arr = $MENU->getBreadcrumbs($current_menu);

		$i = 0;
		$url = '';
		foreach ($b_arr as $b) {
			$url .'/'.$SITE->url_arr[$i];
			$breadcrumbs_arr[] = array('name' => $b['name'], 'url' => $b['url']);
		}
		break;

	case 'catalog':
		if (!isset($CATALOG)) {
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/classes/BlockCatalog.php';
			$CATALOG = new BlockCatalog;
		}

		$catalog = $CATALOG->getCatalogByUrl($SITE->url_arr[0]);

		// Каталог
		$breadcrumbs_arr[] = array('name' => $catalog['name'], 'url' => '/'.$SITE->url_arr[0]);

		// 2 уровень
		if ($SITE->url_arr[1] != '') {

			if ($SITE->url_arr[1] == 'basket') {  // Корзина
				$breadcrumbs_arr[] = array('name' => 'Корзина', 'url' => '/'.$SITE->url_arr[0].'/'.$SITE->url_arr[1]);	
			} else {  // Раздел
				$section = $CATALOG->getSection(array(
					'catalog_id' => $catalog['id'] , 
					'url' => $SITE->url_arr[1],
					'full_request' => 1
				));
				$breadcrumbs_arr[] = array('name' => $section['name'], 'url' => '/'.$SITE->url_arr[0].'/'.$SITE->url_arr[1]);	

				// Товар
				if ($SITE->url_arr[2] != '') {
					$item = $CATALOG->getItem(array(
						'catalog_id' => $catalog['id'], 
						'section_id' => $section['id'],
						'url' => $SITE->url_arr[2],
					));

					$breadcrumbs_arr[] = array('name' => $item['name'], 'url' => '/'.$SITE->url_arr[0].'/'.$SITE->url_arr[1].'/'.$SITE->url_arr[2]);
				}
			}
		}
		break;
}


$breadcrumbs_html = '';
if ($breadcrumbs_arr && count($breadcrumbs_arr) > 0) {
	$svg = ' <svg><use xlink:href="/lib/svg/sprite.svg#arrow_right_1"></use></svg>';
	$svg_home = '<a href="/admin"><svg class="home"><use xlink:href="/lib/svg/sprite.svg#home"></use></svg></a>';
	$i = 1;
	foreach ($breadcrumbs_arr as $b) {
		if (count($breadcrumbs_arr) == $i)
			$breadcrumbs_html .= $svg.'<span>'.$b['name'].'</span>';
		else
			$breadcrumbs_html .= $svg.'<a href="'.$b['url'].'">'.$b['name'].'</a>';
		$i++;
	}

	$breadcrumbs_html = '<div class="block_breadcrumbs">'.$svg_home.$breadcrumbs_html.'</div>';
}


function block_breadcrumbs($data)
{
	global $SITE, $MENU, $breadcrumbs_html;
	$content = $data['content'];

	switch ($content['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
		case 'i': 
			$container_css = 
				'background-image: url(\'/files/pages/'.$SITE->page_id.'/breadcrumbs/background/'.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($content['bg_image_size'] == 'cover') 
					$container_css .= 'background-size: cover"';
			break;
		default: $container_css = '';
	}

	$container_css .= $content['font_size'] != 12 ? 'font-size:'.$content['font_size'].'px;' : '';
	$container_css .= $content['color'] != '' ? 'color:'.$content['color'].';' : '';

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div id="block_breadcrumbs_container" class="block_breadcrumbs_container" '.$wrap_style.'>'.$breadcrumbs_html.'</div>'.
	'</div>';
}
?>