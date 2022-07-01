<?php
  

  if (!isset($_SESSION['zalogowany']))
	{
	header('Location: ../index.php');
		exit();
	}
	
  ?>

<html>
<head>
 <link rel="stylesheet" href="../inc/kolorki.css">
<script>
function updatemenu() {
  if (document.getElementById('responsive-menu').checked == true) {
    document.getElementById('menu').style.borderBottomRightRadius = '0';
    document.getElementById('menu').style.borderBottomLeftRadius = '0';
  }else{
    document.getElementById('menu').style.borderRadius = '10px';
  }
}

function p_kasuj() {
    return confirm('Czy na pewno chcesz usunąć?');
}

</script>
</head>
<body>
<nav id='menu'>
  <input type='checkbox' id='responsive-menu' onclick='updatemenu()'><label></label>
  <ul>
    <li><a href='../logout.php'>Logout</a></li>
    <li><a href='./lista.php'>CzasPracy</a></li>
  </ul>
  <ul>
	<li><a href=''>Pracownik </a>
		<ul class='sub-menus'>
			<li><a href='../zh.php'>Zmień Hasło</a></li>
       </ul>
	</li>
  </ul>
</nav>