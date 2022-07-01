<?php
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		
		echo "Error: ".$polaczenie->connect_errno;
	}
	 
	if (!isset($_GET['klucz']) || empty($_GET['klucz'])) {
	    header('Location:index.php');
	}
	 
	 $klucz = $_GET['klucz'];
	 
	 
	$sql = sprintf("SELECT id_u, Potwierdz_email FROM uzytkownicy WHERE Kod = '%s'", mysqli_real_escape_string($polaczenie,$klucz));
	try{
	$result = $polaczenie->query($sql);   //jak pojawi się coś dziwnego w kodzie
	 } catch(mysqli_sql_exception $e){
	 echo "coś poszło nie tak :( ";
      exit; 
   } 
	 
	if ($result->num_rows > 0) {
	    $row = $result->fetch_assoc();
	    if ($row['Potwierdz_email']) {
	        $arr_message = [
	            'class' => 'alert-success',
	            'msg' => 'Twoje konto jest już aktywowane.',
	        ];
		
	    } else {
	        $sql = "UPDATE uzytkownicy SET Potwierdz_email = '1' WHERE id_u = ".$row['id_u']." AND Kod = '".$klucz."'";
	        $polaczenie->query($sql);
	 
	        $arr_message = [
	            'class' => 'alert-success',
	            'msg' => 'Twoje konto zostało aktywowane. możesz się zalogować <a href="http://localhost/index.php">Logowanie</a>.',
	        ];
	    }
	} else {
	    $arr_message = [
	        'class' => 'alert-danger',
	        'msg' => 'Błędny link, skontaktuj się z administratorem.',
	    ];
	}
	?>
	<div class="container">
	        <div class="row">
	            <div class="col-md-6">
	                <?php if(!empty($arr_message['msg'])) { ?>
	                    <div class="alert <?php echo $arr_message['class']; ?>">
	                        <?php echo $arr_message['msg']; ?>
	                    </div>
	                <?php } ?>
	            </div>
	        </div>
	    </div>