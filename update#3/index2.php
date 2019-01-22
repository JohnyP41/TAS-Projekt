<?php
	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: uzytkownik.php');
	}
?>

<!doctype html>
<html lang="pl">
<head>
  <link rel="stylesheet" href="css/styles.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>Wybory</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="icon" href="favicon.png">
<body align = "center">
	<div>
		<h1>Wybory</h1>
		<br><br>
		<form action="zaloguj.php" method="post">
			<br/><input type="text" name="login" placeholder="Login"/><br/>
			<br/><input type="password" name="haslo" placeholder ="Hasło"/><br/>
			<input type="submit" value="Zaloguj się">
			<br>
			<input type="button" value="Rejestracja" name = "rejestracja" onClick="document.location.href='rejestracja.php'" />
		</form>
		<br>
	
<?php
	if(isset($_SESSION['bladlogowania']))
		echo "<br/>".$_SESSION['bladlogowania'];
?>
	
<?php
	if(isset($_SESSION['bladlogowania']))
		echo "<br/>".$_SESSION['bladlogowania'];
?>

</body>


</head>
</html>