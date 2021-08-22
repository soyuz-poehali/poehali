<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';
$SITE->setHeadFile('/administrator/components/poehali/projects/template/map.css');
$SITE->setHeadFile('/administrator/components/poehali/projects/template/map.js');

$SITE->setHeadCode('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');

$breadcrumbs_arr['/admin/com/poehali'] = 'Поехали';
$breadcrumbs_arr['/admin/com/poehali/projects'] = 'Проекты';
$breadcrumbs_arr[''] = 'Карта';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);
$POEHALI = new AdminPoehali();
$projects_arr = $POEHALI->projectGetProjects();

$points_html = '';
if ($projects_arr) {
	$n = 1;
	$tr = '';
	$tr_class_arr = array('unpub', 'active', '');
	foreach ($projects_arr as $project) {
		if ($project['coordinates'] != '') {
			$coordinates_arr = explode(',', $project['coordinates']);
			if (count($coordinates_arr) == 2) {
				$points_html .= 
				'{"coordinates":['.$coordinates_arr[0].','.$coordinates_arr[1].'],'.
				'"title":"'.$project['name'].'",'.
				'"description":"'.$project['date'].'",'.
				'"link":"/admin/com/poehali/projects/edit/'.$project['id'].'"}, ';
			}
		}
	}
}

$script = 	
'<script>'.
	'var points_arr = ['.$points_html.'];'.
	'let id = "poehali_project_mapsyandex";'.
	'let coordinate = [53.271893, 50.237382];'.
	'let zoom = 8.47;'.
	'ADMIN.poehali.mapsyandex.run("poehali_projects_map", coordinate, 9, points_arr, "islands#redBlue");'.
'</script>';




$SITE->setHeadCode($script);

$SITE->content = 
	$breadcrumbs.
	'<h1>Карта</h1>'.
	'<div id="poehali_projects_map"></div>';
