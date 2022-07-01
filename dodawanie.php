<form method="post">
<input type="submit" name="dodaj" value="dodaj rekord" > </input>
<input type="submit" name="usun" value="usun rekord" > </input>
</form>
<?php
	
	
		
	require_once "connect.php"; 
		
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	} 

		$sql="SELECT * FROM pracownik" ;

         $result = $polaczenie->query($sql);
		
		if ($result=$polaczenie->query($sql))
			{
				echo "znalezionych rekordów:" .$result->num_rows."<br>";

				if($result -> num_rows > 0)
			   {
				while ($row =  $result->fetch_assoc())
					{
						echo $row['ID_P']."<br>" . $row['Imie'] . $row['Nazwisko']."<br>" . $row['Dzial'] . "<br>"; 
			        }
			   }
		else 
		       {
			echo "brak danych";
		      }
			}
	if(isset($_POST["dodaj"]))
		{
			$sql=" INSERT INTO `pracownik` (`ID_P`, `Imie`, `Nazwisko`, `Email`, `Dzial`) VALUES (NULL, 'kamila', 'balii', 'lula@ie.pl', 'tartak')";
			if ($result2=$polaczenie->query($sql))
				{
					echo "dodano nowy rekord";
				}
				else {
					echo "blad";
					 }
		}

	if(isset($_POST["usun"]))
		{
			$sql="DELETE FROM `pracownik` WHERE `pracownik`.`ID_P` = 14";
			if ($result2=$polaczenie->query($sql))
				{
					echo "usunieto rekord";
				}
    else {
		echo "blad";
		}
		}
?>