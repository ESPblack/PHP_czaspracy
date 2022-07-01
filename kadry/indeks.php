<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../index.php');
		exit();
	}
	if (($_SESSION['typ_id'])!= 2)
	{
		session_unset();
		header('Location: ../index.php');
		exit();
	}
?>

	
<?php
    include "./menu.php";
	echo "<p>Witaj ".$_SESSION['login'].'! [  ]</p>';

?>

</body>
</html>
