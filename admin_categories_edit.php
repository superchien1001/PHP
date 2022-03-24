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
	// Nouvelle catégorie
	$id_categorie = 0;
	$categorie = new StdClass();
	$categorie->id_categorie=0;
	$categorie->categorie='';
}
else {
	// Catégorie existante
	$id_categorie = (int) $_GET['id'];
	$reqCat = $bd->prepare('
		SELECT id_categorie, categorie 
		FROM categories 
		WHERE id_categorie=:id_categorie AND ISNULL(suppression)'); // Prend les champs dont la suppression est null
		$reqCat->bindValue('id_categorie', $id_categorie);
		$reqCat->execute();
		$categorie = $reqCat->fetch(PDO::FETCH_OBJ);
			
		// Categorie inexistante
		if ( empty($categorie) ) {
			header('Location:admin_categories.php');
			exit();
		}
				
}

// Réception du formulaire
if ( isset($_POST['enregistrer']) ){
	$categorie->categorie = trim(strip_tags($_POST['categorie']));
	
	if ( empty($categorie->categorie) ) $erreurs['categorie'] = 'Le nom de la catégorie ne peut pas être vide.';
	
	if ( empty($erreurs) ){
		if($categorie->id_categorie > 0) {
			
			//Modification d'une categorie existante
			$reqCatEdit = $bd->prepare('UPDATE categories SET categorie=:categorie WHERE id_categorie=:id_categorie');
			$reqCatEdit->bindValue(':categorie', $categorie->categorie);
			$reqCatEdit->bindValue(':id_categorie', $categorie->id_categorie);
			$reqCatEdit->execute();
		}
		else {
			//Modification d'une categorie existante
			$reqCatEdit = $bd->prepare('INSERT INTO categories (categorie) VALUES (:categorie)');
			$reqCatEdit->bindValue(':categorie', $categorie->categorie);
			$reqCatEdit->execute();
		}
		header('Location:admin_categories.php');
		exit();
	}
}


?>
<!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
		<title>VTT - Catégorie Edition</title>
		<style>
			.red { color: #DC143C;}
		</style>
	</head>
	<body>
		<?php
		include '_include_header.php';
		?>
		<main class="main_categorie_edit">
			<form class="form_cat" action="admin_categories_edit.php?id=<?php echo $id_categorie; ?>" method="post">
				<fieldset class="fieldset_edit">
					<legend>Edition de catégorie</legend>
					
					<label for="categorie" <?php if ( isset($erreurs) ) echo 'class="red"'; ?>>Nom de la catégorie<br>
						<input type="text" maxlength="255" placeholder="Nom de la catégorie" required name="categorie" id="categorie" class="input_champ_cat" value="<?php echo $categorie->categorie; ?>">
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