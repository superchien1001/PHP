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
		<title>VTT - Catégories</title>
	</head>
	<body>
		<?php
		include '_include_header.php';
		?>
		<main class="main_categorie">
			<div class="div_totale_cat">
				<?php
				$reqCat = $bd->prepare('SELECT id_categorie, categorie FROM categories WHERE ISNULL(suppression)'); // Prend les champs dont la suppression est null
				$reqCat->execute();
			
				while ( $categorie = $reqCat->fetch(PDO::FETCH_OBJ) ) {
					echo '<div class="div_categorie"><a href="admin_categories_edit.php?id=',$categorie->id_categorie,'" class="nom_categorie">',$categorie->categorie,'</a><br>';
					echo '<a href="admin_categories_edit.php?id=',$categorie->id_categorie,'" class="a_bouton_edit">Editer</a><br>';
					echo '<a href="admin_categories_delete.php?id=',$categorie->id_categorie,'" class="a_bouton_edit">Supprimer</a></div>';
				}
				?>
			</div>
			<div class="div_totale_cat">
				<a href="admin_categories_edit.php?id=0" class="a_bouton">Nouvelle catégorie</a>
				<a href="admin.php" class="a_bouton">Page précédente</a>
			</div>
		</main>
		<?php
		include '_include_footer.php';
		?>
	</body>
</html>