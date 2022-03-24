<?php
session_start();

require_once '_include_BD.php';
	
// Si l'id existe on select les éléments de cet id
if ( isset($_GET['id']) ){
	$id_marque = (int) $_GET['id'];
	$reqMarqueDelete = $bd->prepare('SELECT id_marque, marque FROM marques WHERE id_marque=:id_marque AND ISNULL(suppression)'); // Prend les champs dont la suppression est null
	$reqMarqueDelete->bindValue('id_marque', $id_marque);
	$reqMarqueDelete->execute();
	$marque = $reqMarqueDelete->fetch(PDO::FETCH_OBJ);
}
elseif ( !empty($marque) ) {
	header('Location:admin_marques.php');
	exit();
}

//Réception du formulaire
if (isset($_POST['supprimer'])){ 
	
	// Si l'id de la catégorie est > 0 --> on modifie
	if($marque->id_marque>0){
			
		// Passage de suppression à 1
		$reqMarqueDelete= $bd->prepare('UPDATE marques SET suppression=1 WHERE id_marque=:id_marque');
		$reqMarqueDelete->bindValue(':id_marque',$id_marque);
		$reqMarqueDelete->execute();
		//echo $id_categorie;
	}
	header('Location:admin_marques.php');
	exit();
}
elseif (isset($_POST['annuler'])){
		
	// Sinon si c'est le bouton annuler qui est pressé, on renvoi vers la page categorie
	header('Location:admin_marques.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
		<title>VTT - Marques Suppression</title>
	</head>
	<body>

		<?php
			include '_include_header.php';
		?>

		<main class="main_categorie_edit">
			<p style="color:#DC143C">Vous êtes sur le poits de supprimer la marque <strong id="marque"><?php echo $marque->marque ?></strong></p>
			<p style="color:#DC143C">Voulez vous continuer ?
			<form class="form_cat" action="admin_marques_delete.php?id=<?php echo $id_marque; ?>" method="post">
				<fieldset class="fieldset_edit">
					<legend>Suppression de la marque suivante : <?php echo $marque->marque ?></legend>
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