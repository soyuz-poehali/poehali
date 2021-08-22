<?php
defined('AUTH') or die('Restricted access');

$SITE->content = 
'<div class="dan_flex_row_start">'.
	'<a href="/admin/crm/users" target="blank" class="a_ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#users_2"></use></svg>
		<div class="a_ico_square_text">Контакты</div>
	</a>'.
	'<a href="/admin/crm/tasks" target="blank" class="a_ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#task"></use></svg>
		<div class="a_ico_square_text">Задачи</div>
	</a>'.
	'<a href="/admin/crm/lead" target="blank" class="a_ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#target"></use></svg>
		<div class="a_ico_square_text">Лиды</div>
	</a>'.
	'<a href="/admin/crm/help" target="blank" class="a_ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#help_2"></use></svg>
		<div class="a_ico_square_text">Помощь</div>
	</a>'.
'</div>';

?>