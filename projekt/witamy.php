<?php
	session_start();
	
	if((!isset($_SESSION['udanarejestracja'])))
	{
		header('Location: index.php');
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
<body>

	<a href="index.php">Konto zostało utworzone. Zaloguj sie na swoje konto.</a><br/><br/>



</body>

  
  

</head>
</html>