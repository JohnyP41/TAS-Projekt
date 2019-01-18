<?php
	session_start();
	
	if((!isset($_SESSION['udanarejestracja'])))
	{
		header('Location: index2.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
?>

<!doctype html>

<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

  <title>Wybory</title>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<body>

	<a href="index2.php">Konto zostało utworzone. Zaloguj sie na swoje konto.</a><br/><br/>



</body>

  
  

</head>
</html>