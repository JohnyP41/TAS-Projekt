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
		$i = 1;
		//while skacze po wierszach bazy danych
		while($row = $rezultat->fetch_assoc())
		{
			if($i == 1)
			{
				echo "<div name = 'table'><table>";
				echo "<tr><td><b>Imię</b></td><td><b>Nazwisko</b></td><td><b>Decyzja</td></tr>";
				$i++;
			}
			if ($_SESSION['points']>0)
			{
			echo "<tr><td>".$row['fname']."</td><td>".$row['lname']."</td>";
			}
			else
			{
				echo "<tr><td>".$row['fname']."</td><td>".$row['lname']."</td></tr>";
			}
			if ($_SESSION['points']>0){
			echo "<td><form method='post'>";
			echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Zagłosuj na tego kandydata' /><br/>";
			echo "</form></td></tr>";
			
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
		echo "<div name = 'votingEnd'>Głosowanie zakończonoe.</div>";
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
	$i = 1;
	//ustanowienie zapytania do bazy danych
	$sql = "SELECT * FROM uzytkownicy WHERE role=3";
	$sql1 = "SELECT * FROM uzytkownicy WHERE id=1";
	if($rezultat = @$polaczenie->query($sql))
	{
		//while skacze po wierszach bazy danych
		while($row = $rezultat->fetch_assoc())
		{
				if($i == 1)
				{
					echo "<div name = 'table'><table>";
					echo "<tr><td><b>Imię</b></td><td><b>Nazwisko</b></td><td><b>Akceptacja</b></td></tr>";
					$i++;
				}
				echo "<tr><td>".$row['fname']."</td><td>".$row['lname'].'</td>';
				if ($_SESSION['points']>0){
				echo "<td><form method='post'>";
				echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Zaakceptuj kandydata'></input>";
				echo "</form></td></tr>";
					if(array_key_exists($row['user'],$_POST)){
						
						if($polaczenie->query('UPDATE uzytkownicy SET role = "1" WHERE id =' .$row["id"]))
						{	

							header('Location: uzytkownik.php');
						}
					}
				}
				
		}
		echo "</table></div>";
	}
	if($rezultat = @$polaczenie->query($sql1))
	{
		while($row = $rezultat->fetch_assoc())
		{
			if($row['points']==0){
			echo "<div name ='startstop'><form method='post'>";
			echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Start głosowania' /><br/>";
			echo "</form></div>";
			
				if(array_key_exists($row['user'],$_POST)){
					
					if($polaczenie->query('UPDATE uzytkownicy SET points = 1 WHERE id =1'))
					{	
						
						header('Location: uzytkownik.php');
					}
				}
			
		
			}
			else
			{
			echo "<div name ='startstop'><form method='post'>";
			echo "<input type='submit' name=".$row['user']." id=".$row['id']." value='Stop głosowania' /><br/>";
			echo "</form></div>";
			
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
  <link rel="stylesheet" href="css/styles2.css">

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
	
    $handle = $link->prepare('select id,fname, points from uzytkownicy where role = 1'); 
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
  
<div name='bar'>
<?php

if($_SESSION['role']=='1')
{
	echo "<b>Zarejestrowałeś się jako kandydat.</b>";
}

if($_SESSION['role']=='2')
{
	echo "<div cass='uInfo'><b>Liczba głosów do oddania: ".$_SESSION['points'] ."</b></div>";
	
	
}

if($_SESSION['role']=='0')
{
	echo "<div class='uInfo'><b>Witaj Adminie!</b></div>";
	//startStop();
	
}

if($_SESSION['role']=='3')
{
	echo "Zarejestrowałeś się jako kandydat. Oczekuj aż Twoja kandydatura zostanie zaakceptowana.<br/><br/>";
	
}

echo"<div name='logoutB'><b>Zalogowano jako ".$_SESSION['fname']." ".$_SESSION['lname'].'.<input type="button" value="Wyloguj" name = "logout" onClick="document.location.href=\'logout.php\'" /></div></b><br>';
//echo $_SESSION['role'];


?>
</div>

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
<div name='trend' id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php
	if($_SESSION['role']=='0')
{
	dodawanie();
}
if($_SESSION['role']=='2')
{
	glosowanie();
}
?>
</body>
</head>
</html>
