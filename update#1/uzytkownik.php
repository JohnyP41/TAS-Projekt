<?php

function glosowanie()
{
//polaczenie do bazy danych
require_once "connect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
if($polaczenie->connect_errno!=0)
{
	echo "Error: nie dziaa.";
}
else
{
	//ustanowienie zapytania do bazy danych
	$sql = "SELECT * FROM uzytkownicy WHERE role=1";
	if($rezultat = @$polaczenie->query($sql))
	{
		//while skacze po wierszach bazy danych
		while($row = $rezultat->fetch_assoc())
		{
			

				echo "<br />Imię: ".$row['fname']."<br />Nazwisko: ".$row['lname']."<br />Email: ".$row['email']."<br />Aktualna punktacja: ".$row['points'].'<br/>';
				if ($_SESSION['points']>0){
				echo "<form method='post'>";
				echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Zagłosuj na tego kandydata' /><br/>";
				echo "</form>";
				
					if(array_key_exists($row['user'],$_POST)){
						$row['points']+=1;
						if($polaczenie->query('UPDATE uzytkownicy SET points = '.$row["points"].' WHERE id =' .$row["id"]))
						{	$_SESSION['points'] -=1;
							$polaczenie->query('UPDATE uzytkownicy SET points = '.$_SESSION["points"].' WHERE id =' .$_SESSION["id"]);
							header('Location: uzytkownik.php');
						}
					}
				}
			
			
	

		}	
	}
	
	
	
	$polaczenie->close();
}

//sprintf('SELECT id FROM uzytkownicy');


}
?>

<?php
session_start();

if(!isset($_SESSION['zalogowany']))
{
	header('Location: index2.php');
	exit();
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
<link rel="icon" href="favicon.png">
<body>

<?php



echo"<p>Zalogowano jako ".$_SESSION['fname']." ".$_SESSION['lname'].'.<a href="logout.php">[ Wyloguj się ]</a></p><br/>';
if($_SESSION['role']=='1')
{
	echo "Zarejestrowałeś się jako kandydat. Liczba głosów jaką uzyskałeś na dany moment: ".$_SESSION['points'];
}

if($_SESSION['role']=='2')
{
	echo "Zarejestrowałeś sie jako osoba zdolna do głosu. Liczba głosów jakich mozesz dokonać: ".$_SESSION['points']. "<br/><br/><br/>";
	
	echo "Kandydaci: <br/>";
	glosowanie();
	
}



?>


</body>
</head>
</html>