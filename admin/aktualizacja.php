<?php
 session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../index.php');
		exit();
	}	
	
	include  "./menu.php";
    
	require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
 
	$lista_sql="SELECT pr.imie,pr.nazwisko  FROM pracownik as pr, uzytkownicy as uz where   pr.Email = uz.Email and pr.id_p<> uz.id_p";

     $pracownik = $db->query($lista_sql);
		$ile=$pracownik->rowCount();   //można dodć obsługę liości itp
		
	echo "Lista zaktualizowanych nazwisk: <BR>";
	
	foreach($pracownik as $row){
		
		echo $row['imie'] ." ".$row['nazwisko']."<BR>";
			
	}
		
	$akt_sql="update uzytkownicy as uz1, (SELECT pr.id_p,pr.Email,uz.ID_U  FROM pracownik as pr, uzytkownicy as uz where   pr.Email = uz.Email and pr.id_p<> uz.id_p) as takie set uz1.ID_P = takie.id_p where uz1.ID_U=takie.id_u";
		
	$aktualizuj = $db->prepare($akt_sql);
     if ($aktualizuj->execute()) {
		 echo $ile."  zaktualizowane ";
	 }





?>