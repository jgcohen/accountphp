<?php

session_start();
require('connect.php');
if(!empty($_POST['email']) && !empty($_POST['password'])){
	// LES VARIABLES
	$email= htmlspecialchars($_POST['email']);
	$password= htmlspecialchars($_POST['password']);

	/// Adresse email syntaxe
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header('location: index.php?error=1&message=Votre adress email est invalide.');
	exit();
	}
	//CHIFFRAGE DU MOT DE PASSE

	$password = "re6z".sha1($password."117")."o1r7i";

	///EMAIL DEJA UTILISE

	$req = $pdo->prepare('SELECT
		count(*) AS numberEmail
		FROM user
		WHERE email =?');

		$req->execute([$email]);

		while($email_verification = $req ->fetch()){
			if($email_verification['numberEmail'] !=1){
				header('location: index.php?error=1&message=Impossible de vous identifier correctement.');
			exit();
			}
		}

		///Connexion
		$req = $pdo->prepare('SELECT *
		FROM user 
		WHERE email = ?');
		$req ->execute([$email]);

		while($user =$req->fetch()){
			if($password == $user['password']){
				$_SESSION['connect'] =1;
				$_SESSION['email'] = $user['email'];
				console.log("heyyyy");
				header('location: index.php?success=1');
				exit();
			}else{
				header('location: index.php?error=1&message=Impossible de vous identifier correctement.');

				exit();
			}
		}
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Netflix</title>
	<link rel="stylesheet" type="text/css" href="default.css">
	<link rel="icon" type="image/pngn" href="img/favicon.png">
</head>
<body>

	<?php include('header.php'); ?>
	
	<section>
		<div id="login-body">

		<?php 
		 if(isset($_SESSION['connect'])){ ?>
		   <h1>Bienvenue</h1>
		   <p>Qu'allez vous regarder aujourd'hui</p>
		   <small><a href="logout.php">Déconnexion</a></small>
		<?php } else{  ?>
		
				<h1>S'identifier</h1>
				<?php if(isset($_GET['error'])){
				if(isset($_GET['message'])){
					echo'<div class="alert error">'.htmlspecialchars($_GET['message']).'</div>';
			} }else if(isset($_GET['success'])){
				echo '<div class="alert success"> Vous etes désormais connecté.</div>';
			} ?>
				<form method="post" action="index.php">
					<input type="email" name="email" placeholder="Votre adresse email" required />
					<input type="password" name="password" placeholder="Mot de passe" required />
					<button type="submit">S'identifier</button>
					<label id="option"><input type="checkbox" name="auto" checked />Se souvenir de moi</label>
				</form>
			

				<p class="grey">Première visite sur Netflix ? <a href="inscription.php">Inscrivez-vous</a>.</p>
				<?php } ?>
			</div>
	</section>

	<?php include('footer.php'); ?>
</body>
</html>