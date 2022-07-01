  <?php
	
	session_start();
	
  	if (!isset($_SESSION['zalogowany']))
	{
	header('Location: ../index.php');
		exit();
	}
 
   
   include "./menu.php";
  
  	    
   require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
 
	$id_u =$_SESSION['id_u']; // 
	
	$lista="SELECT imie,nazwisko,data,czas FROM pracownik as pr, czaspracy as cp,uzytkownicy as uz where pr.id_p=cp.id_p and  pr.id_p=uz.id_p and uz.id_u=$id_u ORDER BY data DESC";
		
	$czas = $db->query($lista);
 ?>
	<p>.</p>
	<table border="1" cellpadding="10" cellspacing="0">
			<tr>
			<th>Imię Nazwisko</th>
			<th>Data</th>
			<th>Przepracowany czas</th>
			</tr>
			
<?php			
 $ilosc_godzin=0;
	foreach($czas as $row){
		
			echo "<tr>";
			echo "<td>" . $row['imie'] ." ".$row['nazwisko']. "  </td>";
			echo "<td>" . $row['data'] . "</td>";
			echo "<td  style='text-align: center'>" . $row['czas'] . "</td>";
			echo "</tr>";
			$ilosc_godzin += $row['czas'];		
							
							}
							
		echo "<tr><th colspan=2>"."Razem:"."</th><th>".$ilosc_godzin."</th> </tr>";
							
		echo "</table>";	
		
?>
	
		
		
		
		
		
		
	