  <?php
	
	session_start();
	
  	if (!isset($_SESSION['zalogowany']))
	{
	header('Location: ../index.php');
		exit();
	}
 
   
   include "./menu.php";
  
  	    
   require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
 
	echo'<form action="" method="post">';
    	echo "<br>rok? <br>";
    	echo'<input type="text" name="rok" id="rok" value="'.date("Y").'">';
    	echo "<br>miesiac? <br>";
    	echo'<input type="text" name="miesiac" id="miesiac" value="'.date("m").'">';
    	echo'<input type="submit" name="znajdzm" value="Raport miesieczny">';
		echo'<input type="submit" name="znajdzr" value="Raport roczmy">';
    	
    	echo'</form>';
     
    if(isset($_POST['znajdzm']))
    {
	echo	"<h2>Raport Miesięczny<h2> ";
    
	$rok = $_POST['rok'];
    $miesiac = $_POST['miesiac'];
    $id_u =$_SESSION['id_u']; // 
	
	$lista=("SELECT imie,nazwisko,data,czas FROM 
			czas_lista where year(data)='$rok' and month(data)='$miesiac' and id_u=$id_u 
			ORDER BY data DESC");
		
	$czas = $db->query($lista);
 ?>
	
	<table border="1" cellpadding="10" cellspacing="0">
			<tr><th colspan=3> Miesiąc: <?php echo $miesiac;  ?> </th></tr>
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
	}
	
	
	
	 if(isset($_POST['znajdzr']))
    {
		$rok = $_POST['rok'];
		
		echo	"<h2>Raport Roczny<h2> ";
			$rok = $_POST['rok'];
			$miesiac = $_POST['miesiac'];
			$id_u =$_SESSION['id_u']; // 
	
			$lista=("SELECT imie,nazwisko,month(data) as mm, sum(czas) as czas FROM 
				pracownik as pr, czaspracy as cp,uzytkownicy as uz 
				where pr.id_p=cp.id_p and  pr.id_p=uz.id_p and uz.id_u=$id_u and year(data)=$rok  
				group by  imie,nazwisko,month(data)
				ORDER BY month(data);");
		
			$czas = $db->query($lista);
	 ?>
		<table border="1" cellpadding="10" cellspacing="0">
			<tr><th colspan=3> Rok: <?php echo $rok;  ?> </th></tr>
			<tr>
			<th>Imię Nazwisko</th>
			<th>Miesiac</th>
			<th>Przepracowany czas</th>
			</tr>
			
<?php		
	$ilosc_godzin=0;
	foreach($czas as $row){
		
			echo "<tr>";
			echo "<td>" . $row['imie'] ." ".$row['nazwisko']. "  </td>";
			echo "<td>" . $row['mm'] . "</td>";
			echo "<td  style='text-align: center'>" . $row['czas'] . "</td>";
			echo "</tr>";
			$ilosc_godzin += $row['czas'];		
							
							}
							
		echo "<tr><th colspan=2>"."Razem:"."</th><th>".$ilosc_godzin."</th> </tr>";
							
		echo "</table>";	
	
	}
?>