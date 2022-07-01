



<?php
	session_start();
	
  	if (!isset($_SESSION['zalogowany']))
	{
	header('Location: ../index.php');
		exit();
	}
 
   
   include "./menu.php";
  



require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
	
	
	
	$id_u=$_SESSION['id_u'];   // id uzytkownika wpisujacego dane -- pobierać z $_SESSION
	
	$lista=("SELECT id_p,imie,nazwisko FROM pracownik order by nazwisko,imie ");
		
	$prac = $db->query($lista);
	
	$i1=0 ; // licznik
	$i2=0  ;
	//$t_czas[]
	
	 $rezultat = $prac->fetchAll(PDO::FETCH_ASSOC);
	
	//echo $rezultat['imie'];
?>	
	
	
	<form method="post" >
	Data<input type="date" name= "data_k" value="<?php
         if(isset($_POST['data_k']))
		 { $p_data=trim($_POST['data_k']); echo $p_data;  } else {	print trim(date("Y-m-d"));} 
	?>"
	><br>
	<table>
		<tr>
			<th>LP</th><th>Nazwisko</th><th>ilosc godzin</th></tr>
	
	
<?php	
	foreach($rezultat as $row)
	{
	
	$i1+=1;
	echo "<tr><td >".$i1."</td>";	
	echo "<td><input name='id_p[]' type='hidden' value=".$row['id_p']." /> ".$row['nazwisko']. "  " . $row['imie']."</td>";
	echo "<td><input name='czas[]' /></td></tr>";
	
	}
	
?>

	</table>
	<input type="submit" name="wprowadz" value="Wyślij formularz">
	<input type="reset" value="Wyczyść dane">
	</form>
	
	
<?php
		
	//echo $i;
		
	
?>

<?php
// wprowadzanie danych do bazy	
	
if(isset($_POST['wprowadz']) && $_POST['data_k'] && is_array($_POST['id_p']) && is_array($_POST['czas']))
{
	$num = count($_POST['id_p']);
	//$all_data = array();
	
	
	$dodaj_sql=("INSERT INTO czaspracy ( ID_P, Data, Czas, Kto_wpisal) VALUES (?,?,?,?)");	
	
		
	for($i=0;$i<$num;++$i)
	{
		$id_p = $_POST['id_p'][$i];
		$data_k= $_POST['data_k'];
		$czas = $_POST['czas'][$i];
		
		//$all_data[$i] = array('id_p'=>$id_p, 'data_k'=>$data_k, 'czas'=>$czas );

	     if ($czas>0)
		 {
            	        
			
			$dodaj = $db->prepare($dodaj_sql);
					
			$dodaj  -> bindParam(1, $id_p, PDO::PARAM_INT);
			$dodaj  -> bindParam(2, $data_k, PDO::PARAM_STR);
			$dodaj  -> bindParam(3, $czas, PDO::PARAM_INT);
			$dodaj  -> bindParam(4, $id_u, PDO::PARAM_INT);
			
			//print $dodaj_sql."----".$id_p."----".$data_k."----".$czas."----".$id_u."<br>";
			try {
			$dodaj -> execute(); 
			
			$i2+=1;
			
			    }
               catch ( PDOException $e )
				{
					print $e."----x";
				}
         } 	
	
	}
	print "Dodano ".$i2."  rekordów";
	//print_r($all_data);
	
	
	} else
	
	{ echo "brak danych";}
 
?>	
	

