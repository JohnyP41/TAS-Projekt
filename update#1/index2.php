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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>Wybory</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<body align = "center">
	<form action="zaloguj.php" method="post">
		Login: <br/><input type="text" name="login" /><br/>
		Hasło: <br/><input type="password" name="haslo" /><br/>
		<input type="submit" value="Zaloguj się">
	</form>
	<br>
	<a href="rejestracja.php">Aby się zarejestrować kliknij tutaj</a><br/><br/>
	
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