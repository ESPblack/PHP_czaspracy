<?php
	session_start();
	
  if (!isset($_SESSION['zalogowany']))
{
header('Location: ../index.php');
  exit();
}
include "./menu.php";
?>

<h3>Tabela użytkownicy - SELECT, INSERT, UPDATE, DELETE</h3>
<?php

require_once "../connect.php"; 
		
	$link = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($link->connect_errno!=0)
	{
		echo "Error: ".$link->connect_errno;
	} 


if (!isset($_POST['co'])) $_POST['co'] = '';
if (!isset($_POST['co'])) $_POST['co'] = '';

// Tutaj metoda POST.
if ($_POST['co'] == 'dodaj') {
  
 // echo $_POST['id_p']."  ". $_POST['login'] ."  ". $_POST['email']."  ". $_POST['id_typ'] ."  ".$_POST['haslo'];
  
  if ( 1==1)   //($_POST['id_p'] && $_POST['login'] && $_POST['email']   && $_POST['id_typ'] && $_POST['haslo'])) 
    {
		$haslo= md5($_POST['haslo']);
		$query = "INSERT INTO uzytkownicy (id_p,login,haslo,email,potwierdz_email,id_typ ) VALUES 
							( $_POST[id_p] , '$_POST[login]', '$haslo', '$_POST[email]' , 1 , $_POST[id_typ] );";
    // print '<font color="red">' . $query . '</font>';
			$wynik = mysqli_query ($link, $query);
  }
}

// Poprawienie wybranego rekordu.
elseif ($_POST['co'] == 'popraw') {
	// print "id_p:".$_POST['id_p']. "idu ". $_POST['id_u']. "  login:".$_POST['login']."  email:".$_POST['email']. "  potwierdz_email". $_POST['potwierdz_email']. "  id_typ".$_POST['id_typ']; // sprawdzenie danych do skasowania
	
  if  ($_POST['id_u'] )//&& $_POST['login'] && $_POST['email'] && $_POST['potwierdz_email']  && $_POST['id_typ']  ) 
  {
    $query = "UPDATE uzytkownicy SET ";
    $query .= "id_p = $_POST[id_p], login = '$_POST[login]',  email = '$_POST[email]',id_typ = $_POST[id_typ],potwierdz_email= $_POST[potwierdz_email]";
    $query .= " WHERE id_u = $_POST[id_u];";
    // print '<font color="red">' . $query . '</font>'; //sprawdzenie
    $wynik = mysqli_query ($link, $query);
  }
} 


if ($_POST['co'] == 'poprawh') {
		
  if  ($_POST['id_u'] && $_POST['haslo'] && $_POST['haslo2'] ) 
  {
    
	$id_u=$_POST['id_u'];
	$haslo = $_POST['haslo'];
	$haslo2 = $_POST['haslo2'] ;
	
	if ($haslo !== $haslo2) {
               
                echo '<span class="blad">Podane hasła nie są ze sobą zgodne.</span>';
            } else 
			{
				$haslo = md5($haslo);
	
				$query = "UPDATE uzytkownicy SET 
				haslo='$haslo' 
				WHERE id_u = $id_u;";
    // print '<font color="red">' . $query . '</font>'; //sprawdzenie
    	
				$wynik = mysqli_query ($link, $query);
					echo '<font color="red">hasło użytkownika id:'.$id_u .'  zostało zmienione</font>';
			}	
  
  } else { echo 'brak danych do zmiany';}
} 





// zmiana hasła
elseif ($_POST['co'] == 'zmienh') {
  $query = "SELECT * FROM uzytkownicy WHERE id_u = $_POST[id_u]";
  $wynik = mysqli_query ($link, $query);
  $rekord = mysqli_fetch_array ($wynik, MYSQLI_NUM);
  $id_u =       $rekord[0];
  $id_p =     $rekord[1];
  $login = $rekord[2];
    
  //print '<font color="red">' . $query . '</font>';

  print '<form method = "POST"><b>Poprawa rekordu:</b><br><br>';
  print '<input type = "hidden" name = "co" value = "poprawh">';
  print '<input type = "hidden" name = "id_u" value = "'.$id_u.'">';
  print '<table>';
  print '<tr><td>id użytkownika:</td><td>'.$id_u.'</td></tr>';
  print '<tr><td>Login: </td><td>'.$login.'</td></tr>';
  print '<tr><td>Hasło:</td><td><input type = "password" name = "haslo" > </td></tr>';
  print '<tr><td>Powtwierdz hasło</td><td><input type = "password" name = "haslo2"  > </td></tr>';

   print '</table>';
  print '<input type ="submit" value="Zmień Hasło">'; 
  print '</form>';
}
 





// Przygotowanie do poprawek (wpisanie wybranego rekordu do pol edycyjnych).
elseif ($_POST['co'] == 'edytuj') {
  $query = "SELECT * FROM uzytkownicy WHERE id_u = $_POST[id_u]";
  $wynik = mysqli_query ($link, $query);
  $rekord = mysqli_fetch_array ($wynik, MYSQLI_NUM);
  $id_u =       $rekord[0];
  $id_p =     $rekord[1];
  $login = $rekord[2];
  $haslo =  $rekord[3];
  $email =  $rekord[4];
  $potwierdz_email=  $rekord[5];
  $id_typ =  $rekord[6];
  $kod =  $rekord[7];
  
  //print '<font color="red">' . $query . '</font>';

  print '<form method = "POST"><b>Poprawa rekordu:</b><br><br>';
  print '<input type = "hidden" name = "co" value = "popraw">';
  print '<table>';
  print '<tr><td>id użytkownika:</td><td><input type = "text" name = "id_u"       value = "'.$id_u.'"></td></tr>';
  print '<tr><td>Id Pracownika:         </td><td><input type = "text" name = "id_p"     value = "'.$id_p.'">    </td></tr>';
  print '<tr><td>Login:     </td><td><input type = "text" name = "login" value = "'.$login.'"></td></tr>';
  print '<tr><td>Email:      </td><td><input type = "email" name = "email"  value = "'.$email.'"> </td></tr>';
  print '<tr><td>Potwierdzenie Email:      </td><td><input type = "text" name = "potwierdz_email"  value = "'.$potwierdz_email.'"> </td></tr>';
  print '<tr><td>Typ:      </td><td><input type = "text" name = "id_typ"  value = "'.$id_typ.'"> </td></tr>';
   print '</table>';
  print '<input type ="submit" value="Popraw">'; 
  print '</form>';
}
 
elseif ($_POST['co'] == 'kasuj') {
  $wynik = mysqli_query ($link, "DELETE FROM uzytkownicy WHERE id_u = $_POST[id_u] and id_typ <> 4 ;");
}

// Wypisanie aktualnej zawartosci tabeli uzytkownicy.
$wynik = mysqli_query ($link, "SELECT * FROM  uzytkownicy;") or die ("Blad w zapytaniu do bazy.");

print "<table cellpadding=5 border=1>";
print "<tr>";
print "<td><b>id urzytkownika      </b></td>";
print "<td><b>id pracownika    </b></td>";
print "<td><b>imie</b></td>";
print "<td><b>email </b></td>";
print "<td><b>potwierdz.email</b></td>";
print "<th>Id_typ</th>";
print "<th colspan=3 >Operacje</td>";
print "</tr>\n";

while ($rekord = mysqli_fetch_array ($wynik, MYSQLI_NUM)) {
  $id_u =       $rekord[0];
  $id_p =     $rekord[1];
  $login = $rekord[2];
  $haslo =  $rekord[3];
  $email =  $rekord[4];
  $potwierdz_email=  $rekord[5];
  $id_typ =  $rekord[6];
  $kod =  $rekord[7];
  
  
  print "<tr>";
  print "<td>$id_u    </td>";
  print "<td>$id_p    </td>";
  print "<td>$login</td>";
  print "<td>$email </td>";
  print "<td>$potwierdz_email </td>"; 
  print "<td>$id_typ </td>"; 
  print "<td> <form  method='POST'> <input type='hidden' name='id_u' value=$id_u  ><input type='submit' name='co' value='kasuj'   onclick='return p_kasuj();'> </form></td>"   ; 
  print "<td> <form  method='POST'> <input type='hidden' name='id_u' value=$id_u  ><input type='submit' name='co' value='edytuj'> </form></td>" ;
  print "<td> <form  method='POST'> <input type='hidden' name='id_u' value=$id_u  ><input type='submit' name='co' value='zmienh'> </form></td>" ;
  print "<tr>";
}
print "</table>";
print("&nbsp;");

// W formularzu nie ma ACTION. Jezeli nie wskazujemy skryptu do
// obslugi formularza, zostanie uzyty skrypt biezacy.
// Formularz do dodawania nowego rekordu.
print '<form method = "POST"><b>Nowy rekord:</b><br><br>';
print '<input type = "hidden" name = "co" value = "dodaj">';
print '<table>';
print '<tr><td>ID Prac:         </td><td><input type = "text" name = "id_p">    </td></tr>';
print '<tr><td>login:     </td><td><input type = "text" name = "login"></td></tr>';
print '<tr><td>Hasło:     </td><td><input type = "password" name = "haslo"></td></tr>';
print '<tr><td>email:      </td><td><input type = "email" name = "email"> </td></tr>';
print '<tr><td>Typ:      </td><td><input type = "text" name = "id_typ"> </td></tr>';
print '</table>';
print '<input type = "submit" value = "Dodaj">';
print '</form>';




?>

</body>
</html>
