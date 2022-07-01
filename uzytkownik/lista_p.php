    <?php
    
	
  // include "./menu.php";
  session_start();
  $_SESSION['id_u']=1;


  
   require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
 
	
	
	echo'<form action="" method="post">';
    	echo "<br>rok? <br>";
    	echo'<input type="text" name="rok" id="rok" value="">';
    	echo "<br>miesiac? <br>";
    	echo'<input type="text" name="miesiac" id="miesiac" value="">';
    	echo'<input type="submit" name="znajdz" value="znajdz">';
    	echo'<input type="reset" value="wyczyść">';
    	echo'</form>';
     
    if(isset($_POST['znajdz']))
    {

    $rok = $_POST['rok'];
    $miesiac = $_POST['miesiac'];
      
        
     $id_u =$_SESSION['id_u']; // 
	
	$lista=("SELECT imie,nazwisko,data,czas FROM 
			pracownik as pr, czaspracy as cp,uzytkownicy as uz 
			where pr.id_p=cp.id_p and  pr.id_p=uz.id_p and uz.id_u=$id_u and year(data)='$rok' and month(data)='$miesiac' 
			ORDER BY data DESC");
		
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
		
    }
    ?>