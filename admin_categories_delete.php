<?php
session_start();

require_once '_include_BD.php';
	
// Si l'id existe on select les éléments de cet id
if ( isset($_GET['id']) ){
	$id_categorie = (int) $_GET['id'];
	$reqCatDelete = $bd->prepare('SELECT id_categorie, categorie FROM categories WHERE id_categorie=:id_categorie AND ISNULL(suppression)'); // Prend les champs dont la suppression est null
	$reqCatDelete->bindValue('id_categorie', $id_categorie);
	$reqCatDelete->execute();
	$categorie = $reqCatDelete->fetch(PDO::FETCH_OBJ);
}

elseif ( !empty($categorie) ) {
	header('Location:admin_categories.php');
	exit();
}
//Réception du formulaire
if (isset($_POST['supprimer'])){ 

	// Si l'id de la catégorie est > 0 --> on modifie
	if($categorie->id_categorie>0){
			
		// Passage de suppression à 1
		$reqCatDelete= $bd->prepare('UPDATE categories SET suppression=1 WHERE id_categorie=:id_categorie');
		$reqCatDelete->bindValue(':id_categorie',$id_categorie);
		$reqCatDelete->execute();
		//echo $id_categorie;
	}
	header('Location:admin_categories.php');
	exit();
}
elseif (isset($_POST['annuler'])){
		
	// Sinon si c'est le bouton annuler qui est pressé, on renvoi vers la page categorie
	header('Location:admin_categories.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
		<title>VTT - Catégorie Suppression</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>

		<?php
			include '_include_header.php';
		?>

		<main class="main_categorie_edit">
			<p style="color:#DC143C">Vous êtes sur le point de supprimer la catégorie <strong id="nom_categorie"><?php echo $categorie->categorie ?></strong></p>
			<p style="color:#DC143C">Voulez vous continuer ?
			<form class="form_cat" action="admin_categories_delete.php?id=<?php echo $id_categorie; ?>" method="post">
				<fieldset class="fieldset_edit">
					<legend>Suppression de la catégorie suivante : <?php echo $categorie->categorie ?></legend>
						<input class="a_bouton" type="submit" name="supprimer" value="supprimer">
						<input class="a_bouton" type="submit" name="annuler" value="annluer">
						
				</fieldset>
			</form>
		</main>

		<?php
			include '_include_footer.php';
		?>

	</body>
</html>