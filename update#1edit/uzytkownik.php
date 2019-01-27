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
	$sql2 = "SELECT * FROM uzytkownicy WHERE id=1";
	if($rezultat = @$polaczenie->query($sql2))
	{	
		while($row = $rezultat->fetch_assoc())
		{
			$glosowanie=$row['points'];

		}
	}
	if(($rezultat = @$polaczenie->query($sql))and($glosowanie==1))
	{
		//while skacze po wierszach bazy danych
		while($row = $rezultat->fetch_assoc())
		{
			

				echo "<br />Imię: ".$row['fname']."<br />Nazwisko: ".$row['lname']."<br /><br/>";
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
	else 
	{
		echo "Aktualnie glosowanie jest niemożliwe.";
	}
	
	
	
	$polaczenie->close();
}

//sprintf('SELECT id FROM uzytkownicy');


}





function dodawanie()
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
	$sql = "SELECT * FROM uzytkownicy WHERE role=3";
	$sql1 = "SELECT * FROM uzytkownicy WHERE id=1";
	if($rezultat = @$polaczenie->query($sql))
	{
		//while skacze po wierszach bazy danych
		while($row = $rezultat->fetch_assoc())
		{
			

				echo "<br />Imię: ".$row['fname']."<br />Nazwisko: ".$row['lname']."<br />Email: ".$row['email']."<br />Aktualna punktacja: ".$row['points'].'<br/>';
				if ($_SESSION['points']>0){
				echo "<form method='post'>";
				echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Zaakceptuj kandydata' /><br/>";
				echo "</form>";
				
					if(array_key_exists($row['user'],$_POST)){
						
						if($polaczenie->query('UPDATE uzytkownicy SET role = "1" WHERE id =' .$row["id"]))
						{	

							header('Location: uzytkownik.php');
						}
					}
				}
			
			
	

		}	
	}
	if($rezultat = @$polaczenie->query($sql1))
	{
		while($row = $rezultat->fetch_assoc())
		{
			echo "<br />Głosowanie ".$row['fname'];
				if($row['points']==0){
				echo "<form method='post'>";
				echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Start' /><br/>";
				echo "</form>";
				
					if(array_key_exists($row['user'],$_POST)){
						
						if($polaczenie->query('UPDATE uzytkownicy SET points = 1 WHERE id =1'))
						{	
							
							header('Location: uzytkownik.php');
						}
					}
				
			
				}
				else
				{
				echo "<form method='post'>";
				echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Stop' /><br/>";
				echo "</form>";
				
					if(array_key_exists($row['user'],$_POST)){
						
						if($polaczenie->query('UPDATE uzytkownicy SET points = 0 WHERE id =1'))
						{	
							
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
	header('Location: index.html');
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
 
$dataPoints = array();
//Best practice is to create a separate file for handling connection to database
try{
     // Creating a new connection.
    // Replace your-hostname, your-db, your-username, your-password according to your database
    $link = new \PDO(   'mysql:host=localhost;dbname=kandydaci;charset=utf8mb4', //'mysql:host=localhost;dbname=canvasjs_db;charset=utf8mb4',
                        'root', //'root',
                        '', //'',
                        array(
                            \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            \PDO::ATTR_PERSISTENT => false
                        )
                    );
	
    $handle = $link->prepare('select id,fname, points from uzytkownicy where points>1'); 
    $handle->execute(); 
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);
		
    foreach($result as $row){
        array_push($dataPoints, array("x"=> $row->id, "y"=> $row->points,"name"=> $row->fname));
    }
	$link = null;
}
catch(\PDOException $ex){
    print($ex->getMessage());
}
	
?>
 
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Wyniki"
	},
	data: [{
		showInLegend: true,
		type: "pie", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  

<?php



echo"<p>Zalogowano jako ".$_SESSION['fname']." ".$_SESSION['lname'].'.<a href="logout.php">[ Wyloguj się ]</a></p><br/>';
if($_SESSION['role']=='1')
{
	echo "Zarejestrowałeś się jako kandydat.";
}

if($_SESSION['role']=='2')
{
	echo "Zarejestrowałeś sie jako osoba zdolna do głosu. Liczba głosów jakich mozesz dokonać: ".$_SESSION['points']. "<br/><br/><br/>";
	
	echo "Kandydaci: <br/>";
	glosowanie();
	
}

if($_SESSION['role']=='0')
{
	echo "Witaj Adminie!";

	dodawanie();
	//startStop();
	
}

if($_SESSION['role']=='3')
{
	echo "Zarejestrowałeś się jako kandydat. Oczekuj aż Twoja kandydatura zostanie zaakceptowana.<br/><br/>";

	
	
}
//echo $_SESSION['role'];


?>


</body>
</head>
</html>