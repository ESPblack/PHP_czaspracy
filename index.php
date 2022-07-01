<?php

	session_start();
	//session_unset();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		//header('Location: index.php');
		//exit();
	}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Portal pracowniczy Firmy XYZ</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	
	<!DOCTYPE html>
	
	
		
			<meta charset="UTF-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<link rel="stylesheet" href="styles.css" />
			<title>Portal pracowniczy Firmy XYZ</title>
		
		<form action="zaloguj.php" method="post">
		
			

			<div class="bg" aria-hidden="true">
				<div class="bg__dot"></div>
				<div class="bg__dot"></div>
			</div>
		
				<div class="form__icon" aria-hidden="true"></div>
				<div class="form__input-container">
					<input
						aria-label="User"
						class="form__input"
						type="text"
						id="login"
						name="login"
						placeholder=" "
					/>
					<label class="form__input-label" for="login">Name</label>
				</div>
				<div class="form__input-container">
					<input
						aria-label="Password"
						class="form__input"
						type="password"
						id="haslo"
						name="haslo"
						placeholder=" "
					/>
					<label class="form__input-label" for="haslo">Password</label>
				</div>
				<div class="form__spacer" aria-hidden="true"></div>
				
				<button class="form__button" name="zaloguj" >Zaloguj</button>
					
				<button class="form__button" name="rejestruj" >Rejestruj</button>
			
			</form>
		


	
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>

</body>
</html>