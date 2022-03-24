<?php
session_start();

require_once '_include_BD.php';

//Zone réservé aux admins
if ( $_SESSION['droits']<2 ) {
	header ('Location:index.php'); 
	exit();
}
	
?><!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
		<title>Administration | VTT</title>
		
	</head>
	<body class="body_admin">
		<?php
		include '_include_header.php';
		?>
		<main class="admin_main">
			<nav class="admin_menu">
				<a href="admin_categories.php" class="a_bouton">Catégories</a>
				<a href="admin_articles.php" class="a_bouton">Articles</a>
				<a href="admin_marques.php" class="a_bouton">Marques</a>
			</nav>
			<form id="deco" method="post" action="index.php">
				<p><button type="submit" class="bouton_connexion" name="deconnexion" id="deconnexion">Déconnexion</button>
			</form>
		</main>
		<?php
		include '_include_footer.php';
		?>

		
	
	</body>
</html>