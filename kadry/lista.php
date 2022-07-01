  <?php
	
	session_start();
	
  	if (!isset($_SESSION['zalogowany']))
	{
	header('Location: ../index.php');
		exit();
	}
 
   
   include "./menu.php";
  
  	    
   require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
 
    //wyciąganie listy pracowników
	$lista=("SELECT id_p,imie,nazwisko FROM pracownik
				order by nazwisko");
		
	$prac = $db->query($lista);
	
	$id_p=0;
	
	if(isset($_POST['id_p']))
				{  $id_p = $_POST['id_p']; } 
	
	echo'<form action="" method="post">';
		
		print '<select name="id_p"  style="width:150px" >' ;
			echo '<option value="0"> Wybierz pracownika </option>';
			
			foreach($prac as $row)
					{
					echo '<option value='.$row['id_p'];
						if ($id_p == $row['id_p']){ echo ' selected ';} 
						
					echo  ' >'.$row['nazwisko']." ".$row['imie'].' </option>';
					}
					
		print  '<BR>';
    	echo "<br>rok? <br>";
    	echo'<input type="text" name="rok" id="rok" value="'.date("Y").'">';
    	echo "<br>miesiac? <br>";
    	echo'<input type="text" name="miesiac" id="miesiac" value="'.date("m").'">';
    	echo'<input type="submit" name="znajdzm" value="Raport miesieczny">';
		echo'<input type="submit" name="znajdzr" value="Raport roczmy">';
		
    	echo'</form>';
    
  
  // notatk sprawdzenie
  //if (isset($_POST['notatka']))
  //	  { echo $_POST['notatka'];}



	
  
// dodawanie notatek
  if(isset($_POST['dodan']))
  {
	  echo "<h2>Dodaj notatkę</h2>";
	  
	  $id_c=$_POST['id_c1'];
	  
	  echo "Notatka";
	
	  echo  "<form  action='' method='POST'>  
			<input name='id_c' type='hidden' value='$id_c'  >
			<input name='notatka' type='text' size=100 > <br>
			<input type='submit' name='dodan_a' value='Dodaj notatkę'>
			 </form>";	
			 
	    }


// dodawanie notatek akcja
	if(isset($_POST['dodan_a']))
	
	{
		$id_c=$_POST['id_c'];
		$notatka = $_POST['notatka'];
		
		
		$dodajn_sql = "INSERT INTO notatki (id_c,notatka ) VALUES (?,?)";
		
		$dodaj = $db->prepare($dodajn_sql);
		$dodaj  -> bindParam(1, $id_c, PDO::PARAM_INT);
		$dodaj  -> bindParam(2, $notatka, PDO::PARAM_STR);
		try {
			$dodaj -> execute(); 
		    }
			catch ( PDOException $e )
				{
					print $e."----x";
				}
			
		$_POST['znajdzm'] ="111"; // załadowanie zmienej do wywołania raportu - można wpisać dowolny ciąg
	
	}	
		
		
//edycja notatek
  
  if(isset($_POST['edytn']))
  {
	  echo "edytuj notatkę";
	  
	  $id_n = $_POST['id_n'] ; 
	  $notatka = $_POST['notatka']   ;  
      echo 	"         
			<form action='' method='POST'>
			<input type='hidden' name='id_n' value=$id_n  >
			<input type='text'   name='notatka' value='$notatka' size ='100'  > <br>
			<input type='submit' name='edytn_a' value='Popraw notatkę' >
			<input type='submit' name='usunn_a' value='Usuń notatkę'  onclick='return p_kasuj();' > </form>";
   
  }
//edycja notatek akcja - edycja

  if(isset($_POST['edytn_a']))
  {
			$id_n= $_POST['id_n'];
			$notatka = $_POST['notatka'];	
			
				$enot_sql = "Update notatki set notatka=? where id_n=?" ;
							
				$enot = $db->prepare($enot_sql);
				$enot  -> bindParam(1, $notatka, PDO::PARAM_STR);
				$enot  -> bindParam(2, $id_n, PDO::PARAM_INT);
					try {
						$enot -> execute(); 
						}
						catch ( PDOException $e )
						{
							print $e."----x";
						}
	  
	$_POST['znajdzm'] ="111"; // załadowanie zmienej do wywołania raportu - można wpisać dowolny ciąg	  
	  
	  
  }





//edycja notatek akcja - kasowanie
  if(isset($_POST['usunn_a']))
  {
	 $id_n= $_POST['id_n'];
				
			
				$dnot_sql = "delete from notatki  where id_n=?" ;
							
				$dnot = $db->prepare($dnot_sql);
				
				$dnot  -> bindParam(1, $id_n, PDO::PARAM_INT);
					try {
						$dnot -> execute(); 
						}
						catch ( PDOException $e )
						{
							print $e."----x";
						}
	  
	$_POST['znajdzm'] ="111"; // załadowanie zmienej do wywołania raportu - można wpisać dowolny ciąg	  
	   
	  
	  
  }


// raport miesiaca
  if(isset($_POST['znajdzm']))
    {
	echo	"<h2>Raport Miesięczny<h2> ";
          
		  //spradzenie zmiennych i dopisanie icz do tabeli _SESSION
		 
		 if(isset($_POST['rok']))
		 { $rok = $_POST['rok']; $_SESSION['rok'] = $rok ;  } else {  $rok = $_SESSION['rok']  ; }
		 
		 if(isset($_POST['miesiac']))
		 { $miesiac = $_POST['miesiac']; $_SESSION['miesiac'] = $miesiac ;  } else {  $miesiac = $_SESSION['miesiac']  ; }
		
		if(isset($_POST['id_p']))
		 { $id_p = $_POST['id_p']; $_SESSION['id_p'] = $id_p ;  } else {  $id_p = $_SESSION['id_p']  ; }
		
			
		
		if ($id_p=='0')
			{
			$lista=("SELECT id_c,imie,nazwisko,data,czas,id_n,notatka FROM 
				czas_lista where year(data)='$rok' and month(data)='$miesiac'  
				ORDER BY data,nazwisko ");				
			} else 
			{
			$lista=("SELECT id_c,imie,nazwisko,data,czas, id_n ,notatka FROM 
				czas_lista where year(data)='$rok' and month(data)='$miesiac' and id_p= $id_p 
				ORDER BY data,nazwisko ");				
			}
		
		
		
	
		
		$czas = $db->query($lista);
 ?>
	
	<table border="1" cellpadding="10" cellspacing="0">
			<tr><th colspan=4> Miesiąc: <?php echo $miesiac;  ?> </th></tr>
			<tr>
			<th>Imię Nazwisko</th>
			<th>Data</th>
			<th>Przepracowany czas</th>
			<th>operacje</th>
			</tr>
			
<?php			
 $ilosc_godzin=0;
	foreach($czas as $row){
		
			echo "<tr>";
			echo "<td>" . $row['nazwisko'] ." ".$row['imie']. "  </td>";
			echo "<td>" . $row['data'] . "</td>";
			echo "<td  style='text-align: center'>" . $row['czas'] . "</td>";
			if (is_null($row['id_n']))
				{
				echo "<td><form  method='POST'> <input type='hidden' name='id_c1' value=".$row['id_c']." ><input type='submit' name='dodan' value='Dodaj not.'></form></td></tr>";	
				} else
			    {
				echo 	"<td rowspan=2>
						<form  method='POST'> <input type='hidden' name='id_c1' value=".$row['id_c']." >
						<input type='hidden' name='id_n' value=".$row['id_n']."  /><input type='hidden' name='notatka' value='".$row['Notatka']."'  />
						<input type='submit' name='edytn' value='Edytuj not.'/>
						<input type='submit' name='usunn_a' value='Kasuj not.' onclick='return p_kasuj();'    / >
						</form></td>
						</tr><tr><td colspan=3>".$row['Notatka']."</td></tr>";
				}
			
			$ilosc_godzin += $row['czas'];		
							
							}
							
		echo "<tr><th colspan=2>"."Razem:"."</th><th>".$ilosc_godzin."</th><td></td> </tr>";
							
		echo "</table>";	
	}
	
	
	
	 if(isset($_POST['znajdzr']))
    {
		$rok = $_POST['rok'];
		$id_p = $_POST['id_p'];
		
		
		echo	"<h2>Raport Roczny<h2> ";
			$rok = $_POST['rok'];
			$miesiac = $_POST['miesiac'];
			// $id_u =$_SESSION['id_u']; // 
	        
			if ($id_p=='0')
			{
				$lista=("SELECT imie,nazwisko,miesiac, czas  FROM 
				czas_lista_s 
				ORDER BY miesiac;");
			} else {
				$lista=("SELECT imie,nazwisko,miesiac, czas  FROM 
					czas_lista_s where id_p=$id_p
					ORDER BY miesiac;");
				}
	
			
		
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
			echo "<td>" . $row['nazwisko'] ." ".$row['imie']. "  </td>";
			echo "<td>" . $row['miesiac'] . "</td>";
			echo "<td  style='text-align: center'>" . $row['czas'] . "</td>";
			echo "</tr>";
			$ilosc_godzin += $row['czas'];		
							
							}
							
		echo "<tr><th colspan=2>"."Razem:"."</th><th>".$ilosc_godzin."</th> </tr>";
							
		echo "</table>";	
	
	}
	
	
	
	
	
	
	
	
	
?>

