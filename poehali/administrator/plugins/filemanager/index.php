<?php
define("AUTH", TRUE);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$FM_dir = '/administrator/plugins/filemanager/'; // Директория файлового менеджера

include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

$db_dsn = 'mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8';

$db_opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);

$db = new PDO($db_dsn, $db_user, $db_password, $db_opt);

session_start();
include_once $_SERVER['DOCUMENT_ROOT'].("/administrator/login.php");

$head = '';

// рабочая папка
$root = $_SERVER['DOCUMENT_ROOT'].'/files';

if(!is_dir($root)) 
	mkdir($root, 0755, true);

$psw = 'DAN_filemanager';
$rand = rand(0, 999999);
$vl_r = substr(md5($rand), 0, 16);

$v = isset($_GET['v']) ? $_GET['v'] : ''; // Вектор шифрования
$act = isset($_GET['a']) ? $_GET['a'] : ''; // Акт
$dir = isset($_GET['d']) ? $_GET['d'] : ''; // Кодированная директорияя
$s = isset($_GET['s']) ? $_GET['s'] : ''; // Сортировка


// Данные CKEditor
$cke_rq = '';
if(isset($_GET['CKEditor']))
	$cke_rq .= '&CKEditor='.$_GET['CKEditor'];

if(isset($_GET['CKEditorFuncNum']))
	$cke_rq .= '&CKEditorFuncNum='.$_GET['CKEditorFuncNum'];

if(isset($_GET['langCode']))
	$cke_rq .= '&langCode='.$_GET['langCode'];


$dir = decode($dir, $v);
$dir = preg_replace('/[^a-z0-9_\-\/]/i','',$dir); // Внимание! Не склеиваем три выражения в одно, иначе вместо ../../ == '' будет ../../ == //
$dir = preg_replace('/^(\/*)|(\/*)$/i','',$dir); // удаляем первый (первые) и последний (последние) слеши
$dir = preg_replace('/(\/){2,}/','/',$dir); // удаляем двойные слеши

$sort_a_class = '';
$sort_d_class = '';
if ($s == 'd'){
	$sort = '&s=d';
	$sort_d_class = 'active';
	$sort_js = 'var s = "d";';
} else {
	$sort = '';
	$sort_a_class = 'active';
	$sort_js = 'var s = "a";';
}

switch ($act) {
	case 'c': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'create_folder.php'); break;	// Создать папку
	case 'd': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'delete.php'); break;	// Удалить
	case 'h': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'tmp/help.php'); break;	// Помощь
	case 'r': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'rename.php'); break;	// Переименовать
	case 'u': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'upload.php'); break;	// Загрузить файл
	case 'i': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'image_resize.php'); break;	// Загрузить изображение с ресайзом
	case 'e': include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'url.php'); break; // Передаём управление в CKEditor
	default: include($_SERVER['DOCUMENT_ROOT'].$FM_dir.'browser.php'); exit;
}


function translit($_str) 
{
	// Запретим использовать любые символы, кроме букв русского и латинского алфавита, знака  "/", "-", "_", "." и цифр
	$pattern = "/[^(\w)|(\/)|(\-)|(\_)|(\.)|( )(\x7F-\xFF)]/";
	$replacement = "";
	$_str = mb_strtolower(preg_replace($pattern, $replacement, $_str));

	// Транслит
	$translit = array('а' => 'a','б' => 'b','в' => 'v','г' => 'g','д' => 'd','е' => 'e','ё' => 'yo','ж' => 'zh','з' => 'z','и' => 'i','й' => 'j','к' => 'k','л' => 'l','м' => 'm','н' => 'n','о' => 'o','п' => 'p','р' => 'r','с' => 's','т' => 't','у' => 'u','ф' => 'f','х' => 'h','ц' => 'c','ч' => 'ch','ш' => 'sh','щ' => 'csh','ь' => '','ы' => 'y','ъ' => '','э' => 'e','ю' => 'yu','я' => 'ya', ' ' => '_');
	$_str = str_replace(array_keys($translit),array_values($translit),$_str);

	return ($_str);
}

function encode($_str)
{
	global $psw, $vl_r;
	return urlencode(openssl_encrypt($_str, 'AES-256-CTR', $psw, 0, $vl_r));
}

function decode($_str, $_v)
{
	global $psw;
	return openssl_decrypt($_str, 'AES-256-CTR', $psw, 0, $_v);
}

function err($_text = '', $_log = '')
{
	if($_log == '') 
		$_log = $_text;

	if ($_text != '') {
		echo '<!DOCTYPE html><html><head><title>Ошибка</title></head> 
		<body>
			<h1>Ошибка</h1>
			<div>'.$_text.'</div>
		</body>
		</html>	
		';
	}
	
	exit;
}
?>