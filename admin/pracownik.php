<?php
	session_start();
	
  if (!isset($_SESSION['zalogowany']))
{
header('Location: ../index.php');
  exit();
}
include "./menu.php";
?>

<h3>Tabela pracownicy - SELECT, INSERT, UPDATE, DELETE</h3>
<?php

require_once "../connect.php"; 
		
	$link = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($link->connect_errno!=0)
	{
		echo "Error: ".$link->connect_errno;
	} 


if (!isset($_POST['co'])) $_POST['co'] = '';
if (!isset($_GET['co'])) $_GET['co'] = '';

// Tutaj metoda POST.
if ($_POST['co'] == 'dodaj') {
  if ( $_POST['imie'] && $_POST['nazwisko'] && $_POST['email'] && $_POST['dzial']) {
    $query = "INSERT INTO pracownik (imie,nazwisko,email,dzial )VALUES 
      ( '$_POST[imie]', '$_POST[nazwisko]', '$_POST[email]', '$_POST[dzial]');";
    print '<font color="red">' . $query . '</font>';
    $wynik = mysqli_query ($link, $query);
  }
}

// Poprawienie wybranego rekordu.
elseif ($_GET['co'] == 'popraw') {
  if ($_GET['imie'] && $_GET['nazwisko'] && $_GET['dzial']) {
    $query = "UPDATE pracownik SET ";
    $query .= "imie = '$_GET[imie]', nazwisko = 
      '$_GET[nazwisko]', email = '$_GET[email]', dzial = '$_GET[dzial]'";
    $query .= " WHERE id_p = $_GET[id_p];";
    print '<font color="red">' . $query . '</font>';
    $wynik = mysqli_query ($link, $query);
  }
} 

// Przygotowanie do poprawek (wpisanie wybranego rekordu do pol edycyjnych).
elseif ($_GET['co'] == 'edytuj') {
  $query ="SELECT * FROM pracownik WHERE id_p = $_GET[id_p]";/*UPDATE `pracownik` SET `Imie` = 'Zbignieww', `Nazwisko` = 'Chociulw', `Dzial` = 'Tartakw' WHERE `pracownik`.`ID_P`= $_GET[id_p]; */
  $wynik = mysqli_query ($link, $query);
  $rekord = mysqli_fetch_array ($wynik, MYSQLI_NUM);
  $id_p =       $rekord[0];
  $imie =     $rekord[1];
  $nazwisko = $rekord[2];
  $email =  $rekord[3];
  $dzial =  $rekord[4];
  print '<font color="red">' . $query . '</font>';

  print '<form method = "get"><b>Poprawa rekordu:</b><br><br>';
  print '<input type = "hidden" name = "co" value = "popraw">';
  print '<table>';
  print '<tr><td>id pracownika:</td><td><input type = "text" name = "id_p"       value = "'.$id_p.'"></td></tr>';
  print '<tr><td>imie:         </td><td><input type = "text" name = "imie"     value = "'.$imie.'">    </td></tr>';
  print '<tr><td>nazwisko:     </td><td><input type = "text" name = "nazwisko" value = "'.$nazwisko.'"></td></tr>';
  print '<tr><td>email:      </td><td><input type = "email" name = "email"  value = "'.$email.'"> </td></tr>';
  print '<tr><td>dzial:      </td><td><input type = "text" name = "dzial"  value = "'.$dzial.'"> </td></tr>';
  print '</table>';
  print '<input type ="submit" value="Popraw">';
  print '</form>';
}
 
elseif ($_GET['co'] == 'kasuj') {
  $wynik = mysqli_query ($link, "DELETE FROM pracownik WHERE id_p = $_GET[id_p];");
}

// Wypisanie aktualnej zawartosci tabeli PRAC.
$wynik = mysqli_query ($link, "SELECT * FROM pracownik;") or die ("Blad w zapytaniu do bazy.");

print "<table cellpadding=5 border=1>";
print "<tr>";
print "<td><b>id_p      </b></td>";
print "<td><b>imie    </b></td>";
print "<td><b>nazwisko</b></td>";
print "<td><b>email </b></td>";
print "<td><b>dzial </b></td>";
print "<td><b>&nbsp;  </b></td>";
print "<td><b>&nbsp;  </b></td>";
print "</tr>\n";

while ($rekord = mysqli_fetch_array ($wynik, MYSQLI_NUM)) {
  $id_p =       $rekord[0];
  $imie =     $rekord[1];
  $nazwisko = $rekord[2];
  $email =  $rekord[3];
  $dzial =  $rekord[4];  
  
  print "<tr>";
  print "<td>$id_p      </td>";
  print "<td>$imie    </td>";
  print "<td>$nazwisko</td>";
  print "<td>$email </td>";
  print "<td>$dzial </td>";  
  print "<td><a href = 'pracownik.php?co=kasuj&id_p=".$id_p."'   onclick='return p_kasuj();'  >kasuj  </a></td>";
  print "<td><a href = 'pracownik.php?co=edytuj&id_p=".$id_p."' >edytuj</a></td>";
  print "<tr>";
}
print "</table>";
print("&nbsp;");

// W formularzu nie ma ACTION. Jezeli nie wskazujemy skryptu do
// obslugi formularza, zostanie uzyty skrypt biezacy.
// Formularz do dodawania nowego rekordu.
print '<form method = "post"><b>Nowy rekord:</b><br><br>';
print '<input type = "hidden" name = "co" value = "dodaj">';
print '<table>';
print '<tr><td>imie:         </td><td><input type = "text" name = "imie">    </td></tr>';
print '<tr><td>nazwisko:     </td><td><input type = "text" name = "nazwisko"></td></tr>';
print '<tr><td>email:      </td><td><input type = "email" name = "email"> </td></tr>';
print '<tr><td>dzial:      </td><td><input type = "text" name = "dzial"> </td></tr>';
print '</table>';
print '<input type = "submit" value = "Dodaj">';
print '</form>';
?>

</body>
</html>
