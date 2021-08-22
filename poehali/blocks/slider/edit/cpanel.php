<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="slider" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/slider/edit/template/1/preview.jpg"></div>'.
	'<div class="e_cpanel_additional_title">Слайдер на всю ширину экрана</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="slider" data-style="2">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/slider/edit/template/2/preview.jpg"></div>'.
	'<div class="e_cpanel_additional_title">Слайдер с отступами</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>