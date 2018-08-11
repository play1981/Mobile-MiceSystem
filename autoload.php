<<<<<<< HEAD
<?php
	// Запускаем сессии
	session_start();

	// Определяем основные каталоги хранения скриптов и шаблонов
	define('BASE', dirname(__FILE__));
	define('dBASE', BASE.'/actions');
	define('INC', 	BASE.'/includes');
	define('TPL',   BASE.'/tpl');
	define('DATA',  BASE.'/data');

	define('AINC', BASE.'/admin/includes');
	define('ATPL', BASE.'/admin/tpl');

	// Функция автозагрузки классов
	function __autoload($class) {
		$file = BASE.'/core/'.strtolower($class).'.class.php';
		if (file_exists($file)) include_once($file);
			else die('Class {'.$class.'} not found!');
	}
	
	// Получаем настройки сайта
	$_SESSION['settings'] = Utils::GetSettings();

	// Проверяем, авторизировался ли пользователь. Авторизоваться могут только пользователи из группы АДМИНИСТРАТОР
	$_SESSION['authorized'] = isSet($_SESSION['Auth']['group_name']) ? ($_SESSION['Auth']['group_name'] == 'guest' ? false : true) : false;


	// По умолчанию для ДАННОГО САЙТА делаем только один проект и делаем его сразу активным
	// В дальнейшем, если будет несколько проектов, надо будет после авторизации на сайте сделать выбор нужного проекта из списка
	$_SESSION['PROJECT'] = array(
		'ID' => 1,
		'NAME' => 'Бизнес Форум 2018'
	);

	$script = substr($_SERVER['SCRIPT_NAME'], 1, strlen($_SERVER['SCRIPT_NAME']));
	$script = $script == 'index.php' ? 'actions/'.$action.'.php' : (file_exists(BASE.'/'.$script) ? $script : 'actions/'.$action.'.php');

	// Проверка прав доступа текущего пользователя к рабочему скрипту
//	if (Auth::CheckPermission(($admin_mode ? 'admin/' : '').$script, $_SESSION['Auth']['group_id']) <> 1) {
//		header('location: /entrance');
//		exit;
//	}
=======
<?php
	// Запускаем сессии
	session_start();

	// Определяем основные каталоги хранения скриптов и шаблонов
	define('BASE', dirname(__FILE__));
	define('dBASE', BASE.'/actions');
	define('INC', 	BASE.'/includes');
	define('TPL',   BASE.'/tpl');
	define('DATA',  BASE.'/data');

	define('AINC', BASE.'/admin/includes');
	define('ATPL', BASE.'/admin/tpl');

	// Функция автозагрузки классов
	function __autoload($class) {
		$file = BASE.'/core/'.strtolower($class).'.class.php';
		if (file_exists($file)) include_once($file);
			else die('Class {'.$class.'} not found!');
	}
	
	// Получаем настройки сайта
	$_SESSION['settings'] = Utils::GetSettings();

	// Проверяем, авторизировался ли пользователь. Авторизоваться могут только пользователи из группы АДМИНИСТРАТОР
	$_SESSION['authorized'] = isSet($_SESSION['Auth']['group_name']) ? ($_SESSION['Auth']['group_name'] == 'guest' ? false : true) : false;


	// По умолчанию для ДАННОГО САЙТА делаем только один проект и делаем его сразу активным
	// В дальнейшем, если будет несколько проектов, надо будет после авторизации на сайте сделать выбор нужного проекта из списка
	$_SESSION['PROJECT'] = array(
		'ID' => 1,
		'NAME' => 'Бизнес Форум 2018'
	);

	$script = substr($_SERVER['SCRIPT_NAME'], 1, strlen($_SERVER['SCRIPT_NAME']));
	$script = $script == 'index.php' ? 'actions/'.$action.'.php' : (file_exists(BASE.'/'.$script) ? $script : 'actions/'.$action.'.php');

	// Проверка прав доступа текущего пользователя к рабочему скрипту
//	if (Auth::CheckPermission(($admin_mode ? 'admin/' : '').$script, $_SESSION['Auth']['group_id']) <> 1) {
//		header('location: /entrance');
//		exit;
//	}
>>>>>>> 7c1adfc55f19ed1a45b631b7d312e7e4e12a606f
?>