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
		<link rel="stylesheet" href="../../css/styles-210914131500.css">
		<link rel="stylesheet" href="css/styles-210914131500.css">
		<link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../libs/font-awesome-4.7.0/css/font-awesome.min.css">
		
		<script src="../../node_modules/es6/ES6.js"></script>
		<script src="../../node_modules/jquery/dist/jquery.min.js" ></script>
		<script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" ></script>
		<script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
		
		<script src="../../js/script-210914131500.js"></script>
		<script src="json/sections-attr-210914131500.js"></script>
		<script src="json/data-210914131500.js"></script>
		<script src="json/inegi-210914131500.js"></script>
		<script src="js/inegi-210914131500.js"></script>
		<script src="js/multiselect-210914131500.js"></script>
		<script src="js/script-210914131500.js"></script>
		<script src="js/rejected-folders-210914131500.js"></script>

		<title>CMASC</title>
	</head>
	<body>

		<div id="loader-div"></div>

		<div class="topnav">
			<div class="home">CMASC</div>
			<div class=""><?php session_start(); echo $_SESSION['user_data']['name'].' '.$_SESSION['user_data']['paternal_surname'].' '.$_SESSION['user_data']['maternal_surname'] ?></div>
			<div class="session" onclick="closeSession()">CERRAR SESION</div>
		</div>

		<div id="frame">

			<div class="framebar" id="framebar"></div>

			<br>

			<h1 class="title"></h1>

			<div id="dashboard-alert-section">
				<!--<div class="alert alert-warning" role="alert">
					<strong>Atención!</strong>, Se ha precargado Información previamente capturada.
				</div>-->
			</div>


			<div id="content"></div>

			<div id="month-records-label-section">REGISTROS DEL MES</div>

			<hr>

			<div id="records-section"></div>

		</div>

	</body>
</html>