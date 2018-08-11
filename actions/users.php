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
				<h1>Текущая дата</h1>
			</div>

			<div data-role="content">
				<p><a href="/" rel="external" data-transition="slide" data-role="button">Index</a></p>

				<p>Текущее время: <b><?=date("d.m.Y H:i:s");?></b></p>
			</div>
		</div>


	</body>
</html>