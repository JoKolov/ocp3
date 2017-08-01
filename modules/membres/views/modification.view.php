<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page modification du compte utilisateur
 *
 * File Last Update : 2017 08 01
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
		<h3>Modifier mon compte : <?php echo $_SESSION['pseudo']; ?></h3>
		<h4><em><?php echo $formValue['type']; ?><em></h4>
		<p>
			<label>Avatar</label>
			<input type="url" class="form-control" placeholder="url de votre avatar" name="avatar_url" id="avatar_url" <?php echo $formValue['avatar']; ?>>
		</p>
		<p>
			<label>Pseudo *</label>
			<input type="text" class="form-control" placeholder="pseudo" name="pseudo" id="pseudo" <?php echo $formValue['pseudo']; ?>>
		</p>
		<p>
			<label>Nom</label>
			<input type="text" class="form-control" placeholder="nom" name="nom" id="nom" <?php echo $formValue['nom']; ?>>
		</p>
		<p>
			<label>Prénom</label>
			<input type="text" class="form-control" placeholder="prenom" name="prenom" id="prenom" <?php echo $formValue['prenom']; ?>>
		</p>
		<p>
			<label>Date de Naissance</label>
			<input type="date" class="form-control" placeholder="" name="date_birth" id="date_birth" <?php echo $formValue['date_birth']; ?>>
		</p>
		<p>
			<label>Email *</label>
			<input type="email" class="form-control" placeholder="adresse email" name="email" id="email" <?php echo $formValue['email']; ?>>
		</p>
		<p>
			<label>Mot de passe</label>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
		</p>
		<p>
			<label>Confirmation du mot de passe</label>
			<input type="password" class="form-control" placeholder="mot de passe" name="password-conf" id="password-conf">
		</p>
		<p>
			<button type="submit" class="btn btn-default">Modifier</button>
		</p>
	</form>
</section>