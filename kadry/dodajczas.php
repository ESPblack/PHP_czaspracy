<?php
	session_start();
	
  	if (!isset($_SESSION['zalogowany']))
	{
	header('Location: ../index.php');
		exit();
	}
 
   
   include "./menu.php";
  




// Formularz do dodawania nowego rekordu.
 require_once "../inc/baza.php"; // połączenie się z bazą danych tym razem PDO
 $lista=("SELECT id_p,imie,nazwisko FROM pracownik ");
		
	$prac = $db->query($lista);

print '<form method = "post"><b>Nowy wpis:</b><br><br>';

print '<table>';
print '<tr><td>pracownik</td><td>    <select name="id_p"  style="width:150px" >' ;

foreach($prac as $row)
	{
	echo '<option value='.$row['id_p'].' >'.$row['nazwisko'].	'</option>';
	}
print  ' </td></tr>';
print '<tr><td>Data rej:</td><td><input type = "date" value='.date("Y-m-d").'   name = "data_k"></td></tr>';
print '<tr><td>ilosc godzin</td><td><input type = "text" name = "czas"></td></tr>';

print '</table>';
print '<input type = "submit" name="dodaj" value = "Dodaj">';
print '</form>';


if(isset($_POST['dodaj']) && $_POST['data_k'] && ($_POST['id_p']) && ($_POST['czas']))
{
	
	
	
	
	$dodaj_sql=("INSERT INTO czaspracy ( ID_P, Data, Czas, Kto_wpisal) VALUES (?,?,?,?)");	
	

	    $id_u=$_SESSION['id_u'];
		$id_p = $_POST['id_p'];
		$data_k= $_POST['data_k'];
		$czas = $_POST['czas'];
		
		

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
			
			
			
			    }
               catch ( PDOException $e )
				{
					print $e."----x";
				}
         } 	
	
	
	print "Dodano rekord";
	//print_r($all_data);
	
	
	}  
 


?>