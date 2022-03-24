<?php
session_start();

require_once '_include_BD.php';
	
// Si l'id existe on select les éléments de cet id
if ( isset($_GET['id']) ){
	$id_article = (int) $_GET['id'];
	$reqCatDelete = $bd->prepare('SELECT id_article, nom_article FROM articles WHERE id_article=:id_article AND ISNULL(suppression)'); // Prend les champs dont la suppression est null
	$reqCatDelete->bindValue('id_article', $id_article);
	$reqCatDelete->execute();
	$article = $reqCatDelete->fetch(PDO::FETCH_OBJ);
}
elseif ( !empty($article) ) {
	header('Location:admin_article.php');
	exit();
}
//Réception du formulaire
if (isset($_POST['supprimer'])){ 
	
	// Si l'id de la catégorie est > 0 --> on modifie
	if($article->id_article>0){
			
		// Passage de suppression à 1
		$reqCatDelete= $bd->prepare('UPDATE articles SET suppression=1 WHERE id_article=:id_article');
		$reqCatDelete->bindValue(':id_article',$id_article);
		$reqCatDelete->execute();
		echo $id_article;
	}
	header('Location:admin_articles.php');
	exit();
}
elseif (isset($_POST['annuler'])){
		
	// Sinon si c'est le bouton annuler qui est pressé, on renvoi vers la page article
	header('Location:admin_articles.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<title>VTT - Catégorie Suppression</title>
		<link rel="stylesheet" href="style.css">
		<meta name="author" content="Nicolas Ghin">
		<meta name="robots" content="noindex,nofollow">
	</head>
	<body>

		<?php
			include '_include_header.php';
		?>

		<main class="main_categorie_edit">
			<p style="color:#DC143C">Vous êtes sur le point de supprimer l'article <strong id="nom_categorie"><?php echo $article->nom_article ?></strong></p>
			<p style="color:#DC143C">Voulez vous continuer ?
			<form class="form_cat" action="admin_articles_delete.php?id=<?php echo $id_article; ?>" method="post">
				<fieldset class="fieldset_edit">
					<legend>Suppression de la catégorie suivante : <?php echo $article->nom_article ?></legend>
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