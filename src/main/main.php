<?php
session_start();
if(!isset($_SESSION['user_data'])){
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!--<link rel="stylesheet" href="node_modules/normalize.css">-->
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
		
        <script src="../../node_modules/es6/ES6.js"></script>
		<script src="../../node_modules/jquery/dist/jquery.min.js" ></script>
		<script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js" ></script>
		
        <script src="json/sections-attr.js"></script>
        <script src="json/data.js"></script>
		<script src="js/script.js"></script>

		<title>CMASC</title>
	</head>
    <body>

		<!--<div class="topnav">
			<a class="active" href="#home">Home</a>
			<a href="#news">News</a>
			<a href="#contact">Contact</a>
			<a href="#about">About</a>
		</div>-->

    
        <div id="frame">

		<div class="topnav">
			<div class="active" id="agreements-nav-div" onclick="loadSection('agreements')">ACUERDOS CELEBRADOS</div>
			<div id="recieved-folders-nav-div" onclick="loadSection('recieved_folders')">CARPETAS RECIBIDAS</div>
			<div id="folders-to-investigation-nav-div" onclick="loadSection('folders_to_investigation')">CARPETAS ENVIADAS A INVESTIGACIÓN</div>
			<div id="people-served-nav-div" onclick="loadSection('people_served')">PERSONAS ATENDIDAS</div>
			<div id="processing-folders-nav-div" onclick="loadSection('processing_folders')">CARPETAS DE TRAMITE</div>
			<div id="folders-to-validation-nav-div" onclick="loadSection('folders_to_validation')">CARPETAS ENVIADAS A VALIDACIÓN</div>
		</div>

		<br>

            <h1 class="title"></h1>

            <br>

            <div id="content"></div>

        </div>

        
		
		</body>
	</html>

<?php
}
else{
?>
    <script>
        window.location = 'src/main/index.php';
    </script>
<?php
}
?>