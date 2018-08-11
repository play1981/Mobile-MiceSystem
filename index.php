<?php
	session_start();

	// Если пользователь авторизован, открываем ему соответствующую страничку ПО УМОЛЧАНИЮ
	$url_default = isSet($_SESSION['Auth']['group_id']) ? ($_SESSION['Auth']['group_id'] == 4 ? 'edit' : 'index') : 'index';

	$url = isset($_REQUEST['__url']) && !empty($_REQUEST['__url']) ? $_REQUEST['__url'] : $url_default;
	$url_array = explode('/', $url);
	$admin_mode = $url_array[0] == 'admin' ? true : false;

	if ($admin_mode) {
		define('BASE', dirname(__FILE__));
		define('dBASE', BASE.'/admin/actions');
		array_shift($url_array);
		$url = implode('/', $url_array);
	}
	else {
		define('BASE', dirname(__FILE__));
		define('dBASE', BASE.'/actions');
	}

	$index = count($url_array);

	$action = $url;
	$_URL = array();

	// Ищем php-файл по указанном пути до тех пор, пока не закончится количество элементов url-а
	while (!file_exists(dBASE.'/'.$action.'/index.php') && !file_exists(dBASE.'/'.$action.'.php') && $index > 1) {
		$index --;
		$action = implode('/', array_slice($url_array, 0, $index));
		$_URL = array_slice($url_array, $index, count($url_array) - $index);
	}

	// Проверяем, нашли ли мы конечный файл для указанного url
	$file = file_exists(dBASE.'/'.$action.'/index.php') ? dBASE.'/'.$action.'/index.php' : dBASE.'/'.$action.'.php';
	if (!file_exists($file)) {
		$file = dBASE.'/default.php';
		$action = 'default';
		$_URL = explode('/', $url);
	}

	include('autoload.php');

//echo $file;
//exit;

	$_SESSION['action'] = $action;
	$_SESSION['menu_url'] = $action_tmp;
	$_SESSION['URL'] = $_URL;
	include($file);
?>