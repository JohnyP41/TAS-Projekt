<?php

session_start();

if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
	header('Location: index2.php');
	exit();
}

require_once "connect.php";

	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		
		
		if($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				if(password_verify($haslo,$wiersz['pass']))
				{
					
					
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['fname'] = $wiersz['fname'];
					$_SESSION['lname'] = $wiersz['lname'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['role'] = $wiersz['role'];
					$_SESSION['points'] = $wiersz['points'];
					
					
					
					unset($_SESSION['bladlogowania']);
					$rezultat->close();
					header('Location: uzytkownik.php');
				}
				else
				{
					$_SESSION['bladlogowania']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index2.php');
				}
			}
			else{
				$_SESSION['bladlogowania']='<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index2.php');
			}
		}
		
		
		$polaczenie->close();
	}
	
	

	


?>