<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page compte membre
 *
 * File Last Update : 2017 07 27
 *
 * File Description :
 * -> affiche le formulaire de tous les champs du membre
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

//------------------------------------------------------------
// HTML
/** Champs du compte membre à afficher
 * PSEUDO
 * NOM
 * PRENOM
 * EMAIL
 * PASSWORD
 * DATE_BIRTH
 * TYPE_ID (type de compte : ex : administrateur)
 * AVATAR_ID (afficher l'avatar et son url)
 */
$membre = $_SESSION['membre']; // on récupère l'objet membre contenu dans la variable $_SESSION
$formValue = $membre->getAttributs(); // on récupère tous les attibuts de l'objet dans un tableau
foreach ($formValue as $key => $value) {
	if($value <> '') { $formValue[$key] = ' value="' . $value . '"'; } // on formate en code HTML
}
?>
<section class="container">
	<form method="post" action="?module=membres&action=modification" class="row">
		<h3>Mon compte : <?php echo $_SESSION['pseudo']; ?></h3>
		<p>
			<input type="text" class="form-control" placeholder="pseudo" name="pseudo" id="pseudo" <?php echo $formValue['pseudo']; ?>>
		</p>
		<p>
			<input type="email" class="form-control" placeholder="adresse email" name="email" id="email" <?php echo $formValue['email']; ?>>
		</p>
		<p>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
		</p>
		<p>
			<button type="submit" class="btn btn-default">Modifier</button>
		</p>
	</form>
</section>