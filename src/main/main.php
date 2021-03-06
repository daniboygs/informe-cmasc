<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="pragma" content="no-cache" />
		<!--<link rel="stylesheet" href="node_modules/normalize.css">-->
		<link rel="shortcut icon" href="../../assets/img/fge.png"/>
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
		
		<script src="../../node_modules/es6/ES6.js"></script>
		<script src="../../node_modules/jquery/dist/jquery.min.js" ></script>
		<script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js" ></script>
		<script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
		
		<script src="../../js/script.js"></script>
		<script src="json/sections-attr.js"></script>
		<script src="json/data.js"></script>
		<script src="js/script.js"></script>

		<title>CMASC</title>
	</head>
	<body>

		<div class="topnav">
			<div class="home">CMASC</div>
			<div class=""><?php session_start(); echo $_SESSION['user_data']['name'].' '.$_SESSION['user_data']['paternal_surname'].' '.$_SESSION['user_data']['maternal_surname'] ?></div>
			<div class="session" onclick="closeSession()">CERRAR SESION</div>
		</div>

		<div id="frame">

			<div class="framebar" id="framebar">
				
			</div>

			<br>

			<h1 class="title"></h1>

			<br>

			<div id="content"></div>

			<hr>

			<div id="records-section"></div>

		</div>

	</body>
</html>