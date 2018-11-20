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
<body>

	<a href="rejestracja.php">Rejestracja</a><br/><br/>


	<form action="zaloguj.php" method="post">
	
		Login: <br/><input type="text" name="login" /><br/>
		Hasło: <br/><input type="password" name="haslo" /><br/>
		<input type="submit" value="Zaloguj się">
	
	</form>
	
<?php
	if(isset($_SESSION['bladlogowania']))
		echo "<br/>".$_SESSION['bladlogowania'];
?>

</body>

  
  

</head>
</html>