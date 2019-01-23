<?php
	session_start();

	
//poprawnosc formularza
	if(isset($_POST['email']))
	{
		$works=true;
		
$fname = $_POST['fname'];
		if((strlen($fname)<2) || (strlen($fname)>20))
		{
			$works=false;
			$_SESSION['err_fname']="Imię musi posiadać od 2 do 20 znaków";
		}
		
		if(!preg_match("![^a-zA-ZąĄćĆęĘóÓśŚłŁżŻźŹńŃ]+!i",  $fname))
		{
			//echo "poprawne znaki";
		}
		else
		{
			$works=false;
			$_SESSION['err_fname']="Można używać jedynie liter";
		}
		
		
$lname = $_POST['lname'];
		if((strlen($lname)<2) || (strlen($lname)>20))
		{
			$works=false;
			$_SESSION['err_lname']="Nazwisko musi posiadać od 2 do 20 znaków";
		}
		
		if(!preg_match("![^a-zA-ZąĄćĆęĘóÓśŚłŁżŻźŹńŃ]+!i",  $lname))
		{
			//echo "poprawne znaki";
		}
		else
		{
			$works=false;
			$_SESSION['err_lname']="Można używać jedynie liter";
		}
$email = $_POST['email'];
		$emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$works=false;
			$_SESSION['err_email']="Niepoprawny E-mail"	;
		}
		
		
		
		
		
$user = $_POST['user'];
		if((strlen($user)<6) || (strlen($user)>20))
		{
			$works=false;
			$_SESSION['err_user']="Login musi posiadać od 6 do 20 znaków";
		}
		
		if(!preg_match("![^a-zA-Z0-9]+!i",  $user))
		{
			//echo "poprawne znaki";
		}
		else
		{
			$works=false;
			$_SESSION['err_user']="Można używać jedynie liter(Bez polskich znaków) i cyfr";
		}
		
$passA = $_POST['passA'];
$passB = $_POST['passB'];
		if((strlen($passA)<6) || (strlen($passB)>20))
		{
			$works=false;
			$_SESSION['err_passA']="Hasło musi posiadać od 6 do 20 znaków";

		}
		
		if($passA!=$passB)
		{
			$works=false;
			$_SESSION['err_passB']="Hasła muszą być identyczne";
			
		}
		
		
		$pass_hash = password_hash($passA,PASSWORD_DEFAULT);
		
		
		if(!isset($_POST['role']))
		{
			$role = "2";
			$points = 1;
		}
		else
		{
			$role = "1";
			$points = 0;
		}
		
		
		
		require_once "connect.php";
		
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name, $db_role);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				$howmany_email = $rezultat->num_rows;
				if($howmany_email>0)
				{
		
					$works=false;
					$_SESSION['err_email']="Istnieje już konto przypisane do tego adresu Email";
			
		
				}
				
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$user'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				$howmany_user = $rezultat->num_rows;
				if($howmany_user>0)
				{
		
					$works=false;
					$_SESSION['err_user']="Istnieje już konto przypisane do tej nazwy uzytkownika";
			
		
				}
						
						
				if ($works==true)
				{
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES(NULL,'$user','$pass_hash','$fname','$lname','$email','$points','$role')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}	
					else
					{
						throw new Exception($polaczenie->error);
					}
				}
				$polaczenie->close();
			}
		
		}
		catch(Exception $e)
		{
			echo "Błąd serwera.";
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
		
		
	}
	
	
?>

<!doctype html>

<html lang="pl">
<head>
  <link rel="stylesheet" href="css/styles1.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

  <title>Wybory - Rejestracja</title>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="icon" href="favicon.png">
<body>
  <div name="div1">
	  <h1>Rejestracja</h1><br><br>
	  <form method="post" align ="center">
	  <div name="div2">
		  <br/><input type="text" name=fname placeholder="Imię"><br>
		  <?php
			if(isset($_SESSION['err_fname']))
			{
				echo "<font color=\"red\">".$_SESSION['err_fname']."<font color=\"black\">";
				unset($_SESSION['err_fname']);
			}
		  ?>
		  <br>
		  <br/><input type="text" name=lname placeholder="Nazwisko"><br>
			<?php
			if(isset($_SESSION['err_lname']))
			{
				echo "<font color=\"red\">".$_SESSION['err_lname']."<font color=\"black\">";
				unset($_SESSION['err_lname']);
			}
		  ?>
		  <br>
		  <br/><input type="text" name=email placeholder="E-mail"><br>
			<?php
			if(isset($_SESSION['err_email']))
			{
				echo "<font color=\"red\">".$_SESSION['err_email']."<font color=\"black\">";
				unset($_SESSION['err_email']);
			}
		  ?>
		  <br>
		  <br/><input type="text" name=user placeholder="Login"><br>
			<?php
			if(isset($_SESSION['err_user']))
			{
				echo "<font color=\"red\">".$_SESSION['err_user']."<font color=\"black\">";
				unset($_SESSION['err_user']);
			}
		  ?>
		  <br>
		  <br/><input type="password" name='passA' placeholder="Hasło"><br>
			<?php
			if(isset($_SESSION['err_passA']))
			{
				echo "<font color=\"red\">".$_SESSION['err_passA']."<font color=\"black\">";
				unset($_SESSION['err_passA']);
			}
		  ?>
		  <br>
		  <br/><input type="password" name='passB' placeholder="Powtórz hasło"><br>
			<?php
			if(isset($_SESSION['err_passB']))
			{
				echo "<font color=\"red\">".$_SESSION['err_passB']."<font color=\"black\">";
				unset($_SESSION['err_passB']);
			}
		  ?>
		  <br>
		</div>
	  <label>
		<br>Chcę Kandydować: <input type="checkbox" name=role> <br/><br/>
	  </label>
	  <br/><input type="submit" value="Załóż konto">
	  
	  
	  
	  </form>
  </div>
</body>
</head>
</html>