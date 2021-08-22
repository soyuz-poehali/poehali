<?php
defined('AUTH') or die('Restricted access');

function block_video_1($data)
{
	$content = $data['content'];
	$video_out = '';

	$i = 1;
	foreach ($content['videos'] as $video) {
		if ($video['ratio'] == 2) 
			$youtube_ratio_padding = 'style="padding-bottom:75%;"';
		else  
			$youtube_ratio_padding = '';

		if (!empty($content['padding'])) 
			$youtube_padding = 'padding:'.$content['padding'].'px;';
		else 
			$youtube_padding = '';

		if (!empty($youtube_padding)) 
			$youtube_style = 'style="'.$youtube_padding.'"';
		else 
			$youtube_style = '';

		$block_youtube_wrap = empty($video['text']) ? '' : '<div class="block_video_text">'.$video['text'].'</div>';

		$video_out .= 
		'<div class="dan_flex_grow_1 e_block_item" '.$youtube_style.' data-block="video" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
			$block_youtube_wrap.
			'<div class="block_youtube_wrap">'.
				'<div class="dan_youtube" '.$youtube_ratio_padding.'><iframe style="width:560px; height:315px;" src="'.$video['url'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'</div>'.
			'<div class="e_item_panel">'.
				'<div class="e_block_panel_ico" data-id="'.$data['id'].'" data-action="text_edit" title="Редактировать текст"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
				'<div class="e_block_panel_ico" data-id="'.$data['id'].'" data-action="video_edit" title="Редактировать видео"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#youtube"></use></svg></div>'.
				'<div class="drag_drop_ico" data-id="'.$data['id'].'" data-target-id="block_video_container_'.$data['id'].'" data-class="e_block_item" title="Перетащить видео внутри блока" data-f="EDIT.block.video.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
				'<div class="e_block_panel_ico" data-id="'.$data['id'].'" data-action="video_delete" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'</div>'.
		'</div>';
		$i++;
	}

	return $video_out;
}

?>