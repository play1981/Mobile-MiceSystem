<<<<<<< HEAD
<!DOCTYPE html>
<html>
	<head>
		<title>Mobile</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="/favicon.ico" type="image/x-icon" rel="SHORTCUT ICON">
		
		<link type="text/css" rel="stylesheet" media="all" href="/css/jquery.mobile.min.css"/>
		<link type="text/css" rel="stylesheet" media="all" href="/css/index.css"/>

		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/index.js"></script>
		<script type="text/javascript" src="/js/jquery.mobile.min.js"></script>
	</head>

	<body>
		<div id="index" data-role="page" data-dom-cache="false">
			<div data-role="header">
				<h1>Личный кабинет</h1>
			</div>

			<div data-role="content">
				
				<div data-inline="true">
					<a href="#about" data-transition="slide" data-role="button">About</a>
					<a href="/users" rel="external" data-transition="slide" data-role="button">Users</a>
				</div>

				<p>Как можно было увидеть, в представленном примере отсутствуют элементы управления, осуществляющие возврат на главную страницу. Это не случайно, так как библиотека jQuery Mobile, если не указано явно, автоматически включает этот элемент навигации в заголовок каждой страницы второго уровня. Если же по какой-то причине этого не требуется, то в тег, описывающий верхний колонтитул, необходимо добавить атрибут data-backbtn="false".</p>

			</div>

		</div>

		<div id="about" data-role="page" data-dom-cache="false">
			<div data-role="header">
				<h1>О проекте</h1>
			</div>

			<div data-role="content">
				<p><a href="/" data-transition="slide" data-role="button">Index</a></p>
				<p>Одна из особенностей мобильных Web-интерфейсов, редко встречающаяся в оконных приложениях, - это анимированные переходы между страницами. Так как библиотека jQuery Mobile предназначена для создания Web-интерфейсов для мобильных платформ, то в нее уже встроен набор спецэффектов. В листинге 1 имеется строка, содержащая атрибут data-transition, как показано ниже.</p>
				<p>Текущее время: <b><?=date("d.m.Y H:i:s");?></b></p>
			</div>
		</div>


	</body>
=======
<!DOCTYPE html>
<html>
	<head>
		<title>Mobile</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="/favicon.ico" type="image/x-icon" rel="SHORTCUT ICON">
		
		<link type="text/css" rel="stylesheet" media="all" href="/css/jquery.mobile.min.css"/>
		<link type="text/css" rel="stylesheet" media="all" href="/css/index.css"/>

		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/index.js"></script>
		<script type="text/javascript" src="/js/jquery.mobile.min.js"></script>
	</head>

	<body>
		<div id="index" data-role="page" data-dom-cache="false">
			<div data-role="header">
				<h1>Личный кабинет</h1>
			</div>

			<div data-role="content">
				
				<div data-inline="true">
					<a href="#about" data-transition="slide" data-role="button">About</a>
					<a href="/users" rel="external" data-transition="slide" data-role="button">Users</a>
				</div>

				<p>Как можно было увидеть, в представленном примере отсутствуют элементы управления, осуществляющие возврат на главную страницу. Это не случайно, так как библиотека jQuery Mobile, если не указано явно, автоматически включает этот элемент навигации в заголовок каждой страницы второго уровня. Если же по какой-то причине этого не требуется, то в тег, описывающий верхний колонтитул, необходимо добавить атрибут data-backbtn="false".</p>

			</div>

		</div>

		<div id="about" data-role="page" data-dom-cache="false">
			<div data-role="header">
				<h1>О проекте</h1>
			</div>

			<div data-role="content">
				<p><a href="/" data-transition="slide" data-role="button">Index</a></p>
				<p>Одна из особенностей мобильных Web-интерфейсов, редко встречающаяся в оконных приложениях, - это анимированные переходы между страницами. Так как библиотека jQuery Mobile предназначена для создания Web-интерфейсов для мобильных платформ, то в нее уже встроен набор спецэффектов. В листинге 1 имеется строка, содержащая атрибут data-transition, как показано ниже.</p>
				<p>Текущее время: <b><?=date("d.m.Y H:i:s");?></b></p>
			</div>
		</div>


	</body>
>>>>>>> 7c1adfc55f19ed1a45b631b7d312e7e4e12a606f
</html>