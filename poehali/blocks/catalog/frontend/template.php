<?php
defined('AUTH') or die('Restricted access');

function block_catalog($data)
{
	global $SITE, $catalog;
	$catalog_html = '';
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/main.php';

	$b = $data['content'];
	$wrap_css = $b['max_width'] && $b['max_width'] != 100 ? 'max-width:'.$b['max_width'].'px;' : '';
	$wrap_css .= $b['margin'] != 0 ? 'margin:'.$b['margin'].'px auto;' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	if (isset($catalog['catalog_html']))
		$catalog_html .= $catalog['catalog_html'];

	return 
	'<div id="block_'.$data['id'].'" class="block">'.
		'<div class="block_catalog_wrap" '.$wrap_style.'>'.$catalog_html.'</div>'.
	'</div>';
}
?>