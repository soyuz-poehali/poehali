<?php defined("AUTH") or die("Restricted access");?>
<!DOCTYPE html>
<html> 
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
	<script src="/lib/DAN/DAN.js"></script>
	<link rel="stylesheet" href="/lib/DAN/DAN.css" type="text/css" />
	<script type="text/javascript" src="/lib/DAN/contextmenu/contextmenu.js" ></script>
	<link rel="stylesheet" href="/lib/DAN/contextmenu/contextmenu.css" type="text/css" />	
	<link rel="stylesheet" type="text/css" href="/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/css/imgareaselect-default.css" />
	<script type="text/javascript" src="/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/scripts/jquery.min.js"></script>
	<script type="text/javascript" src="/lib/IMAGE_RESIZE/jquery.imgareaselect-0.9.10/scripts/jquery.imgareaselect.pack.js"></script>
	<script type="text/javascript" src="/lib/IMAGE_RESIZE/IMAGE_RESIZE.js" ></script>	
	<link rel="stylesheet" href="/lib/IMAGE_RESIZE/IMAGE_RESIZE.css" type="text/css" />	
	<? echo $head ?>
	<script type="text/javascript" src="/administrator/plugins/filemanager/tmp/tmp_browser.js"></script>
	<link rel="stylesheet" href="/administrator/plugins/filemanager/tmp/tmp_browser.css" type="text/css" />	
	<title>Файловый менеджер</title>	
</head> 
<body>
<div class="header">
	<span class="header_title">Менеджер файлов</span>
	<a href="/administrator/plugins/filemanager/index.php?a=h" target="_blank"><svg class="header_ico" title="Создать папку"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#help"></use></svg></a>
	<span class="header_text">Действия</span>
	<svg id="create_folder" class="header_ico" title="Создать папку"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#folder_add"></use></svg>
	<svg  id="upload_file" class="header_ico" title="Загрузить файл"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#upload"></use></svg>
	<svg  id="upload_image" class="header_ico" title="Загрузить изображение с обработкой"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#image_resize"></use></svg>
	<span class="header_text">Сортировка</span>
	<svg  id="sort_az" class="header_ico <? echo $sort_a_class; ?>" title="По алфавиту"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#sort"></use></svg>	
	<svg  id="sort_date" class="header_ico <? echo $sort_d_class; ?>" title="По алфавиту"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#calendar"></use></svg>
</div>
<div class="content">
	<div id="left" class="left"><? echo $tree_out; ?></div>
	<div class="center">
		<div class="path">Вы здесь: <a href="/administrator/plugins/filemanager/index.php"><svg id="sort_date" class="path_home"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/administrator/plugins/filemanager/tmp/sprite.svg#home"></use></svg></a><? echo $path; ?></div>
		<div class="center_container"><? echo $ico_big; ?></div>
	</div>
</div>
</body>
</html>