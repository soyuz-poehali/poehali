<?php
defined('AUTH') or die('Restricted access');
include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';
$ADMIN = new Administrators;
$admin_id = $_SESSION['admin'];
$administrator = $ADMIN->getAdmin($admin_id);

if ($administrator['status'] > 1) {
	$administrator_html = 
	'<a href="/admin/administrators" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#users"></use></svg>
		<div class="ico_square_text">Админы</div>
	</a>';

} else {
	$administrator_html = '';
}

$SITE->content = 
'<div class="dan_flex_row_start">
	<a href="/admin/com/poehali/projects" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#section"></use></svg>
		<div class="ico_square_text">Проекты</div>
	</a>
	<a href="/admin/com/poehali/projects/map" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#map"></use></svg>
		<div class="ico_square_text">Карта</div>
	</a>
	<a href="/admin/com/poehali/blogers" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#users"></use></svg>
		<div class="ico_square_text">Блогеры</div>
	</a>
</div>';
?>