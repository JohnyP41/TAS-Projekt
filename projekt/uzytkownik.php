<?php
session_start();

if(!isset($_SESSION['zalogowany']))
{
	header('Location: index.php');
	exit();
}
?>


<!doctype html>

<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

  <title>Wybory</title>
<body>

<?php



echo"<p>Zalogowano jako ".$_SESSION['fname']." ".$_SESSION['lname'].'.<a href="logout.php">[ Wyloguj się ]</a></p>';

?>


</body>

  
  

</head>
</html>