<?php
session_start();

require_once '_include_BD.php';

//Zone réservé aux admins
if ( $_SESSION['droits']<2 ) {
	header ('Location:index.php'); 
	exit();
}

// Chargement de la catégorie

if ( empty($_GET['id']) ){
	// Nouvelle catégorie --> id_marque = 0
	$id_marque = 0;
	$marque = new StdClass();
	$marque->id_marque=0;
	$marque->marque='';
}
else {
	// marque existante --> on prend son id
	$id_marque = (int) $_GET['id'];
																							// Prend les champs dont la suppression est null
	$reqMarque = $bd->prepare('SELECT id_marque, marque FROM marques WHERE id_marque=:id_marque AND ISNULL(suppression)');
		
	$reqMarque->bindValue('id_marque', $id_marque);
	$reqMarque->execute();
	$marque = $reqMarque->fetch(PDO::FETCH_OBJ);
			
	// Si marque n'extiste pas on renvoi sur la page 
	if ( empty($marque) ) {
		header('Location:admin_marques.php');
		exit();
	}
				
}


// Réception du formulaire
if ( isset($_POST['enregistrer']) ){
	
	// Suppression du code HTML ou PHP injecter
	$marque->marque = trim(strip_tags($_POST['marque']));
	
	// si le champ marque n'existe pas --> message d'erreur
	if ( empty($marque->marque) ) $erreurs['marque'] = 'Le nom de la marque ne peut pas être vide.';
	
	// Si aucune erreur, on execute la suite
	if ( empty($erreurs) ){
		
		// Si id_marque > 0 --> la marque existe donc on modifie
		if($marque->id_marque > 0) {
			
			//Modification d'une categorie existante
			$reqMarqueEdit = $bd->prepare('UPDATE marques SET marque=:marque WHERE id_marque=:id_marque');
			$reqMarqueEdit->bindValue(':marque', $marque->marque);
			$reqMarqueEdit->bindValue(':id_marque', $marque->id_marque);
			$reqMarqueEdit->execute();
		}
		else {
			//Sinon ajout d'une marque dans la table
			$reqMarqueEdit = $bd->prepare('INSERT INTO marques (marque) VALUES (:marque)');
			$reqMarqueEdit->bindValue(':marque', $marque->marque);
			$reqMarqueEdit->execute();
		}
		header('Location:admin_marques.php');
		exit();
	}
}


?><!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
		<title>VTT - Marques Edition</title>
	</head>
	<body>
		<?php
		include '_include_header.php';
		?>
		<main class="main_categorie_edit">
			<form class="form_cat" action="admin_marques_edit.php?id=<?php echo $id_marque; ?>" method="post">
				<fieldset class="fieldset_edit">
					<legend>Edition de la marque</legend>
					
					<label for="marque" <?php if ( isset($erreurs) ) echo 'class="red"'; ?>>Nom de la marque<br>
						<input type="text" maxlength="255" placeholder="Nom de la marque" required name="marque" id="marque" class="input_champ_cat" value="<?php echo $marque->marque; ?>">
					</label>
					<input type="submit" class="a_bouton" name="enregistrer" value="Enregistrer">
				
				</fieldset>
			
			</form>
		</main>
		<?php
		include '_include_footer.php';
		?>

		
	
	</body>
</html>