   
     <?php
    
    session_start();
    ?>
     
     <head>
 <link rel="stylesheet" href="./styles.css">

</head> 

    <div class="content">
     
    <?php
     
    if (!isset($_SESSION['zalogowany'])) { // dostęp dla zalogowanego użytkownika
     
        require_once "connect.php"; // połączenie się z bazą danych
        
		$polaczenie = mysqli_connect($host, $db_user, $db_password, $db_name);
		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	
		$blad = 0;	
		$tabela = 'uzytkownicy'; // zdefiniowanie tabeli MySQL
     
    if (isset($_POST["wyslane"])) { // jeżeli formularz został wysłany, to wykonuje się poniższy skrypt
     
            // filtrowanie treści wprowadzonych przez użytkownika
            $login =  (trim($_POST["login"]));
            $haslo = (trim($_POST["haslo"]));
            $haslo2 = (trim($_POST["haslo2"]));
            $email= (trim($_POST["email"]));
     
            // system sprawdza czy prawidło zostały wprowadzone dane
            if (strlen($login) < 3 or strlen($login) > 30 or !preg_match("/^[a-zA-Z0-9_.]+$/", $login)) {
                $blad++;
                echo '<span class="blad">Proszę poprawny wprowadzić login (od 3 do 30 znaków).</span>';
            } else {
           //   $wynik = mysql_query("SELECT * FROM $tabela WHERE login='$login'") or die(mysql_error());
        
		if ($wynik = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
		mysqli_real_escape_string($polaczenie,$login))))
		$ilu_userow = $wynik->num_rows ;
			if($ilu_userow>0) 
			{ 
		  $blad++;
          echo "Wybrany login jest już używany przez innego użytkownika.";
        }
		
		if ($wynik = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE email='%s' ",
		mysqli_real_escape_string($polaczenie,$email))))
		$ilu_userow = $wynik->num_rows ;
			if($ilu_userow>0) 
			{ 
		  $blad++;
          echo "Wybrany email jest już używany przez innego użytkownika.";
        }
		
      }
     
            if (strlen($haslo) < 6 or strlen($haslo) > 30 ) {
                $blad++ ;
                echo '<span class="blad">Proszę poprawnie wpisać hasło (od 6 znaków do 30 znaków).</span>';
            }
            if ($haslo !== $haslo2) {
                $blad++;
                echo '<span class="blad">Podane hasła nie są ze sobą zgodne.</span>';
            }
            if (!preg_match("/^[0-9a-z_.-]+@([0-9a-z-]+\.)+[a-z]{2,4}$/", $email)) {
                $blad++;
                echo '<span class="blad">Proszę wprowadzić poprawnie adres email.</span>';
            }
     
            // jeżeli nie ma żadnego błedu, użytkownik zostaje zarejestronwany i wysłany do niego e-mail z linkiem aktywacyjnym
           
		   if ( $blad == 0 ) {
     
                $haslo = md5($haslo); // zaszyfrowanie hasla
                $kod = uniqid(rand()); // tworzenie unikalnego kodu dla użytkownika
     
                $wynik = mysqli_query($polaczenie,"INSERT INTO $tabela (Login,Haslo,Email,Kod) VALUES( '$login', '$haslo', '$email', '$kod')");
                if ($wynik) 
				{
                   $list = <<<STR
				   Witaj $login ! <br> Kliknij w poniższy link, aby aktywować swoje konto. <a href="http://localhost/aktywacja.php?klucz=$kod"
				   target="_blank"> http://localhost/aktywacja.php?klucz=$kod"</a> <br> Pozdrawiamy <br> Zespół HR
STR;
				 
					echo   '<br> polecenie wysyłania:   mail(html_entity_decode($email), "Rejestracja użytkownika", $list, "From: <kontakt@localhost>")   <br><br><br> Poniżej przykładowy list z linkiem atywacji <br> <br>';
                 
					echo $list;
					
					echo '<br><br><br><br> Komunikat pokazujący się na tronie po prawidłowej rejestracji: <BR>';
					echo "<p>Dziękujemy za rejestrację! W ciągu nabliższych 5 minut dostaniesz wiadomość e-mail z dalszymi wskazówkami rejestracji.</p>";
                  
                    exit;
                }
            }
            
        }
     
        // tworzenie formularza HTML
        include 'formadd.php' ;    
    } 
     
    ?>
     
    </div>
     
   