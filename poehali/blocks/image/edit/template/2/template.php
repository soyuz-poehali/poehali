<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/image/edit/template/2/style.css');

function block_image_2($b)
{
	global $SITE;

	if (!empty($b['padding'])) {
		$padding = 'padding:'.$b['padding'].'px;';
		$style = 'style="'.$padding.'"';
		$text_wrap_style = '';
	} else {
		$padding = '';
		$style = '';
		$text_wrap_style = 'style="padding:40px;"';
	}

	$src = '/files/pages/'.$SITE->page['id'].'/image/'.$b['image'];

	$out =		
		'<div class="dan_flex_grow_1 block_image_2_text" '.$style.'><div class="block_images_text_wrap" '.$text_wrap_style.'>'.$b['text'].'</div></div>'.
		'<div class="dan_flex_grow_1" '.$style.'><img class="block_images_image" src="'.$src.'" alt="'.$b['alt'].'"></div>';
	
	return $out;
}

?>