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

			<div class="framebar">
				<div class="active" id="agreements-nav-div" onclick="loadSection('agreements')">ACUERDOS CELEBRADOS</div>
				<div id="recieved-folders-nav-div" onclick="loadSection('recieved_folders')">CARPETAS RECIBIDAS</div>
				<div id="folders-to-investigation-nav-div" onclick="loadSection('folders_to_investigation')">CARPETAS ENVIADAS A INVESTIGACIÓN</div>
				<div id="people-served-nav-div" onclick="loadSection('people_served')">PERSONAS ATENDIDAS</div>
				<div id="processing-folders-nav-div" onclick="loadSection('processing_folders')">CARPETAS DE TRÁMITE</div>
				<div id="folders-to-validation-nav-div" onclick="loadSection('folders_to_validation')">CARPETAS ENVIADAS A VALIDACIÓN</div>
				<div id="entered-folders-nav-div" onclick="loadSection('entered_folders')">CARPETAS INGRESADAS</div>
				<div id="entered-folders-super-nav-div" onclick="loadSection('entered_folders_super')">CARPETAS INGRESADAS (CAPTURA)</div>
				<div id="capture-period-nav-div" onclick="loadSection('capture_period')">PERIODO DE CAPTURA</div>
			</div>

			<br>

			<h1 class="title"></h1>

			<br>

			<div id="content"></div>

			<hr>

			<div id="records-section"></div>

			<!--<img src="../../assets/img/fge_nav.png" alt="" width="500" height="500" style="opacity: 0.5;">-->

		</div>


	</body>
</html>