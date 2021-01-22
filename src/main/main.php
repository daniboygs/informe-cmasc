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
		<link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		
        <script src="../../node_modules/es6/ES6.js"></script>
		<script src="../../node_modules/jquery/dist/jquery.min.js" ></script>
		<script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js" ></script>
		
        <script src="json/sections-attr.js"></script>
		<script src="js/script.js"></script>

		<title>CMASC</title>
	</head>
	<body class="text-center" style="display: block; zoom: 85%;">

        <div id="content"></div>
		
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