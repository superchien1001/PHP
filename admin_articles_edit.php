<?php
session_start();

require_once '_include_BD.php'; //commande

//zone réservé aux admins
if($_SESSION['droits']<2){
	header('Location:index.php');
	exit();
}

//Chargement de l'article
if ( empty($_GET['id'])){
	//Nouvelle article
	$id_article=0;
	$article= new StdClass();
	$article->id_article=0;
	$article->nom_article='';
	$article->annee='';
	$article->prix='';
	$article->id_categorie='';
	$article->id_marque='';
	$reqCat = $bd->prepare('SELECT  id_marque, marque FROM marques WHERE ISNULL(suppression)');
	$reqCatMarq = $bd->prepare('SELECT  id_categorie, categorie FROM categories WHERE ISNULL(suppression)');
}
else{
	//Article existant
	$id_article=(int)$_GET['id'];
	$reqCat = $bd->prepare('SELECT  id_article, nom_article, annee, prix, id_categorie, id_marque
							FROM articles 
							WHERE id_article=:id_article AND ISNULL(suppression)');
	$reqCat->bindValue('id_article',$id_article);
	$reqCat->execute();	
	$article = $reqCat->fetch(PDO::FETCH_OBJ);
	$reqCat = $bd->prepare('SELECT  id_marque, marque FROM marques WHERE ISNULL(suppression)');
	$reqCatMarq = $bd->prepare('SELECT  id_categorie, categorie FROM categories WHERE ISNULL(suppression)');


	//Article inexistant
	if( empty($article)){
		header('Location:admin_articles.php');
		exit();
	}
}

	//Réception du formulaire
if (isset($_POST['enregistrer'])){
	
	
	$article->nom_article = trim(strip_tags($_POST['nom_article']));
	$article->annee=$_POST['annee'];
	$article->prix=$_POST['prix'];
	$article->id_marque=$_POST['marque'];
	$article->id_categorie=$_POST['categorie'];
	
	if (empty ($article->nom_article)) $error['nom_article'] = 'Veuillez remplir le champ nom.';
	if (empty ($article->annee)) $error['annee'] = 'Veuillez remplir le champ annee.';
	if (empty ($article->prix)) $error['prix'] = 'Veuillez remplir le champ prix.';
	if (empty ($article->id_marque)) $error['id_marque'] = 'Veuillez choisir une marque.';
	if (empty ($article->id_categorie)) $error['categorie'] = 'Veuillez choisir une categorie.';
	
	if(empty($error))
	{
		if($article->id_article>0){
			$reqCatEdit= $bd->prepare('UPDATE articles SET nom_article=:nom_article,annee=:annee,prix=:prix,id_marque=:id_marque,id_categorie=:id_categorie WHERE id_article=:id_article'); //Fonctionne pas, à voir
			$reqCatEdit->bindValue(':nom_article',$article->nom_article);
			$reqCatEdit->bindValue(':id_article',$article->id_article);
			$reqCatEdit->bindValue(':id_marque',$article->id_marque);
			$reqCatEdit->bindValue(':id_categorie',$article->id_categorie);
			$reqCatEdit->bindValue(':prix',$article->prix);
			$reqCatEdit->bindValue(':annee',$article->annee);
			$reqCatEdit->execute();

		}
		else{
			$reqCatEdit= $bd->prepare('INSERT INTO articles (nom_article,annee,prix,id_marque,id_categorie) VALUES (:nom_article,:annee,:prix,:id_marque,:id_categorie)');
			$reqCatEdit->bindParam(':nom_article',$article->nom_article);
			$reqCatEdit->bindParam(':annee',$article->annee);
			$reqCatEdit->bindParam(':prix',$article->prix);
			$reqCatEdit->bindParam(':id_marque',$article->id_marque);
			$reqCatEdit->bindParam(':id_categorie',$article->id_categorie);
			$reqCatEdit->execute();
		}
		header('Location:admin_articles.php');
		exit();
	}
}

?>
<!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
		<meta charset="utf-8">
		<title>Édition d'article</title>
		<link rel="stylesheet" href="style.css">
		<style>
			.red { color: #DC143C;}
		</style>
	</head>
	<body>

		<?php
			include '_include_header.php';
		?>

		<main class="main_categorie_edit">
			<form class="form_cat" action="admin_articles_edit.php?id=<?php echo $id_article; ?>" method="post">
				<fieldset class="fieldset_edit">
					<legend>Édition de l'article</legend>
					<label for="nom_article" <?php if (isset ($error['nom_article'])) echo 'class="red"'; ?>>
						Nom de l'article<br>
						<input type="text" maxlength="255" placeholder="Nom de l'article" required name="nom_article" id="nom_article" class="input_champ_cat" value="<?php echo $article->nom_article; ?>"> 
					</label>
					
					<label for="annee" <?php if (isset ($error['annee'])) echo 'class="red"'; ?>>
						Année<br>
						<input type="text" maxlength="255" placeholder="Année" required name="annee" id="annee" class="input_champ_cat" value="<?php echo $article->annee; ?>"> 
					</label>
					
					<label for="prix" <?php if (isset ($error['prix'])) echo 'class="red"'; ?>>
						Prix<br>
						<input type="text" maxlength="255" placeholder="Prix" required name="prix" id="prix" class="input_champ_cat" value="<?php echo $article->prix; ?>"> 
					</label>
					
					<label for="marque" <?php if (isset ($error['id_marque'])) echo 'class="red"'; ?>>
						Nom de la marque<br>
						<select name="marque" id="marque" class="input_champ_cat" required>
							<?php
								$reqCat->execute();
								if (empty($article->id_marque)){echo '<option value="">Choisisez une option</option>';}
								while( $id_marque = $reqCat->fetch(PDO::FETCH_OBJ) ){
									echo '<option value="',$id_marque->id_marque,'" ';
									if($id_marque->id_marque==$article->id_marque) echo "selected";
									echo ">",$id_marque->marque,'</option>';
								}
							?>
						</select>
					</label>
					
						Nom de la catégorie<br>
					<label for="categorie" <?php if (isset ($error['id_categorie'])) echo 'class="red"'; ?>>
						<select name="categorie" id="categorie" class="input_champ_cat" required>
							<?php
								$reqCatMarq->execute();
								if (empty($article->id_categorie)){echo '<option value="">Choisisez une option</option>';}
								while( $id_categorie = $reqCatMarq->fetch(PDO::FETCH_OBJ) ){
									echo '<option value="',$id_categorie->id_categorie,'" ';
									if($id_categorie->id_categorie==$article->id_categorie) echo "selected";
									echo ">",$id_categorie->categorie,'</option>';
								}
							?>
						</select>
					</label>

					<p><input type="submit" class="a_bouton" name="enregistrer" value="Enregistrer">
				</fieldset>
			</form>
		</main>

		<?php
			include '_include_footer.php';
		?>

	</body>
</html>