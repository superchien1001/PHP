<?php
	session_start();

	require_once '_include_BD.php';

	// Si le bouton connexion est pressé :
	if(isset ($_POST['connexion'])){
		//traitement du formulaire
		//On trim la chaine de caractère
		if ( !empty($_POST['login'])){
			if($_POST['login']){
				$login = trim($_POST['login']) ;
			}
		}
		else $error['login']=true;

		// On SHA1 le mot de passe
		if ( !empty($_POST['password'])){
			if($_POST['password']){
				$password = SHA1( trim($_POST['password']) ) ;
				//echo $password;
			}
		}
		else $error['password']=true;	

		if(empty($error)){
			$reqConnexion = $bd->prepare('SELECT * FROM users');
			$reqConnexion->execute();
			
			//récupère les données (mot de passe haché dans la base de donnée) et les compare le tout en un seul while :D
			while( $user = $reqConnexion->fetch(PDO::FETCH_OBJ) ){
				if( $login==$user->login and $password==$user->password){
					$_SESSION['pseudo']=$user->login;
					$_SESSION['droits']=$user->droits;
					header('Location:index.php');
					exit();
				}
			}
		}
	}
	else if (isset($_POST['deconnexion'])){
		session_destroy();
		header("Location:index.php");
	}
?>
<!DOCTYPE html>
<html lang='fr'>
	<head>
		<meta charset="utf-8">
		<title>Connexion</title>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300&display=swap" rel="stylesheet">
		<meta name="author" content="Nicolas Ghin">
		<style>
			.red { color: #DC143C;}
		</style>
	</head>
	<body class="body_connexion">

		<?php
			if (empty ($_SESSION)){
		?>

		<main class="index_main">
			<form action="index.php" method="post"> 
				<div class="formulaire">
					<h2 class="connexion_h2">Connexion</h2>
					
					<?php 	
						if ( isset($error['login'])) {
							echo '<p class="red">Veuillez remplir le champ identifiant</p>';
						}
						
						if ( isset($error['password'])) {
							echo '<p class="red">Veuillez remplir le champ mot de passe</p>';
						}
					?>
					
					<!-- ATTENTION : Si required est mis la class red ne se lance pas, car le navigateur affiche lui même du JAVASCRIPT
					Pour faire fonctinner mon erreur, supprimer le Required -->
					<p>
						<label for="login" <?php if ( isset($error['login']) ) echo 'class="red"'; ?>>Identifiant :<br>
							<input type="text" placeholder="Login" name="login" id="login" class="input_connexion" required>
						</label>
					<p>
						<label for="password" <?php if ( isset($error['password']) ) echo 'class="red"'; ?>>Mot de passe :<br>
							<input type="password" placeholder="Password" name="password" id="password" class="input_connexion" required>
						</label>
						<button class="bouton_connexion" type="submit" name="connexion" id="connexion">Connexion</button>
				</div>
			</form>
		</main>
		<?php
			}
			else{ 
				echo '<main class="connexion_ok"><div><h3>Bonjour ' . $_SESSION['pseudo'];
				echo ", vous êtes connecté en tant qu";
					if($_SESSION['droits']==2){
						echo "' admin";
					}
					else{
						echo "e visiteur";
					}
				echo "</h3></div>";
		?>
			<?php
				if($_SESSION['droits']==2){
			?>
			<?php
				}
				if($_SESSION['droits']<2){
					echo '<p class="red">Veuillez vous connecter à un compte admin</p>';
				}
			?>
				<a href="admin.php" class="a_bouton">Visualiser la base de données</a><br>
				<form id="deco" method="post" action="index.php">
					<p><button type="submit" class="bouton_connexion" name="deconnexion" id="deconnexion">Déconnexion</button>
				</form>
			</main>
		<?php
			}
		?>
		
		<?php
			include '_include_footer.php';
		?>

	</body>
</html>