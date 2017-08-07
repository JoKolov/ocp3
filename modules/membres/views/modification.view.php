<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page modification du compte utilisateur
 *
 * File Last Update : 2017 08 07
 *
 * File Description :
 * -> affiche le formulaire de tous les champs du membre
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

//------------------------------------------------------------
// Protocoles de sécurités
user_connected_only();



//------------------------------------------------------------
// code à mettre dans le contrôleur
$membre = $_SESSION['membre']; // on récupère l'objet membre contenu dans la variable $_SESSION
$formValue = $membre->getAttributs(); // on récupère tous les attibuts de l'objet dans un tableau
foreach ($formValue as $key => $value) {
	if($value <> '') { $formValue[$key] = ' value="' . $value . '"'; } // on formate en code HTML
}


//------------------------------------------------------------
// HTML
?>
<section>
	<form method="post" action="?module=membres&action=modification">
		<h3>Modifier mon compte : <?php echo $_SESSION['pseudo']; ?></h3>
		<p>
			<label>Avatar</label>
			<img src="<?php echo $membre->get_avatar(); ?>">
			<input type="url" class="form-control" placeholder="url de votre avatar" name="avatar" id="avatar" <?php echo $formValue['avatar']; ?>>
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
			<label>Nouveau mot de passe</label>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
		</p>
		<p>
			<label>Confirmation du nouveau mot de passe</label>
			<input type="password" class="form-control" placeholder="mot de passe" name="password-conf" id="password-conf">
		</p>
		<p>
			<button type="submit" class="btn btn-default">Modifier</button>
		</p>
	</form>
</section>