<?php

	session_start();
	
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		//header('Location: index.php');
		//exit();
	}

?>
<link rel="stylesheet" href="styles.css" />





		<form action="" method="post">
		
			

			<div class="bg" aria-hidden="true">
				<div class="bg__dot"></div>
				<div class="bg__dot"></div>
			</div>
		
				<div class="form__icon" aria-hidden="true"></div>
				<div class="form__input-container">
					<input
						aria-label="Haslo"
						class="form__input"
						type="password"
						id="haslo"
						name="haslo"
						placeholder=" "
					/>
					<label class="form__input-label" for="login">Hasło</label>
				</div>
				<div class="form__input-container">
					<input
						aria-label="Nowe Hasło"
						class="form__input"
						type="password"
						id="nhaslo"
						name="nhaslo"
						placeholder=" "
					/>
					<label class="form__input-label" for="haslo">Nowe Hasło</label>
				</div>
				<div class="form__input-container">
					<input
						aria-label="Powtórz Nowe Hasło"
						class="form__input"
						type="password"
						id="nhaslo2"
						name="nhaslo2"
						placeholder=" "
					/>
					<label class="form__input-label" for="haslo">Powtórz Nowe Hasło</label>
				</div>
				
			
<?php
require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
{






	$id_u  =  $_SESSION['id_u'];
	$login  = $_SESSION['login'] ;
	$typ_id = $_SESSION['typ_id'];

    $haslo_sql="Select haslo from uzytkownicy where id_u=$id_u";
	
	$haslo_p = mysqli_query ($polaczenie, $haslo_sql);
	$haslo_a = mysqli_fetch_array ($haslo_p, MYSQLI_NUM);		
    $haslos =  $haslo_a[0];
    //echo $haslos;

	if (isset($_POST['powrot']))
		{

           $i = $typ_id;
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
		}					



	if (isset($_POST['zmienh']))
		{
		if  ($_POST['haslo'] && $_POST['nhaslo'] && $_POST['nhaslo2'] ) 
			{
							
				$nhaslo = $_POST['nhaslo'];
				$nhaslo2 = $_POST['nhaslo2'] ;
				$haslo = $_POST['haslo'];
				$haslo=md5($haslo);
				
				
				if ($haslo !== $haslos) 
				{
				 echo "Podano nieprawidłowa stare hasło";	
					
				}
			else
				{
				
				
					if ($nhaslo !== $nhaslo2) 
						{ 
						echo '<span class="blad">Podane hasła nie są ze sobą zgodne.</span>';
						} else 
						{
					$haslo = md5($nhaslo);
	
					$query = "UPDATE uzytkownicy SET 
					haslo='$haslo' 
					WHERE id_u = $id_u;";
					// print '<font color="red">' . $query . '</font>'; //sprawdzenie
    	
					$wynik = mysqli_query ($polaczenie, $query);
						echo ' Hasło użytkownika <font color="red">'.$login.'</font> zostało zmienione';
						}
				}					
  
  } else { 
		echo 'brak danych do zmiany<br>';}
	
		}


}

// &#9760;  / czacha

?>
 <div class="form__spacer" aria-hidden="true"></div>
				
				<button class="form__button" name="zmienh" >Zmień Hasło</button>
				<button class="form__button" name="powrot" >Wróć</button>	
				
			
			</form>
			<p></p>			