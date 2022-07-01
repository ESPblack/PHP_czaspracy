<?php

	session_start();
	
	 if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

if(isset($_POST['zaloguj']))
{

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = md5($_POST['haslo']);
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE login='%s' AND haslo='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$haslo))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
						
			{
				$wiersz = $rezultat->fetch_assoc();
				
				$potw = $wiersz['Potwierdz_email'];
				if ($potw == 0)
								{
									
						$_SESSION['blad'] = '<span style="color:red">Jeszcze nie masz potwierdzonego konta! Sprawdz email</span>';
					    header('Location: index.php');
					    exit();
								}	
				
				$_SESSION['zalogowany'] = true;
				
				$_SESSION['id_u'] = $wiersz['ID_U'];
				$_SESSION['login'] = $wiersz['Login'];
				$_SESSION['typ_id'] = $wiersz['Id_typ'];
				$i = $wiersz['Id_typ'];
				
				$rezultat->free_result();
				
				
				switch ($i) {
							case 0:
								header('Location: ./uzytkownik/indeks.php');
								break;
							case 2:
								header('Location: ./kadry/indeks.php');
								break;
							case 4:
								header('Location: ./admin/indeks.php');
								break;
							default;
								header('Location: ./uzytkownik/indeks.php');
								break;	
}
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
}
if(isset($_POST['rejestruj']))
{
	header('Location: ./dodaj.php');
		exit();
}
	
?>