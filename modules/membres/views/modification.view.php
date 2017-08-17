<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page modification du compte utilisateur
 *
 * File Last Update : 2017 08 17
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


//-----
// ERREURS
$erreur = array(
	'avatar'		=> error_format_form("l'image envoyé est non prise en charge"),
	'pseudo'		=> error_format_form("Pseudo obligatoire : 4 caractères minimum, lettres, chiffres et - _ autorisés"),
	'nom'			=> error_format_form("Nom invalide"),
	'prenom'		=> error_format_form("Prénom invalide"),
	'date_birth'	=> error_format_form("Date de naissance invalide"),
	'email'			=> error_format_form("Email obligatoire : adresse email valide du type nom@domaine.com"),
	'password'		=> error_format_form("Mot de passe incorrect"));

foreach ($erreur as $key => $value) {
	$pattern = '#' . $key . '#';
	if (!isset($_GET['error']) OR !preg_match($pattern, $_GET['error']))
	{
		$erreur[$key] = '';
	}
}

//------------------------------------------------------------
// HTML
?>
<section>
	<form method="post" action="?module=membres&action=modification" enctype="multipart/form-data">
		<h3>Modifier mon compte : <?php echo $_SESSION['pseudo']; ?></h3>

		<?php
		if (isset($_GET['success'])) {
		?>
			<div class="alert alert-success" role="alert">
			  <strong>Enregistré !</strong> Le compte a été mis à jour.
			</div>
		<?php 
		}
		elseif (isset($_GET['error'])) {
		?>
			<div class="alert alert-danger" role="alert">
			  <strong>Erreur !</strong> Vérifiez les champs du formulaire.
			</div>
		<?php 
		}
		
		?>

		<p>
			<label>Avatar</label>
			<div style="width:200px; height:200px; background-image: url('<?= $membre->get_avatar(); ?>'); background-size: cover;">
			</div>
			<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
			<input type="file" class="form-control" placeholder="votre image" name="image" id="image">
			<?= $erreur['avatar']; ?>
		</p>
		<p>
			<label>Pseudo *</label>
			<input type="text" class="form-control" placeholder="pseudo" name="pseudo" id="pseudo" <?= $formValue['pseudo']; ?>>
			<?= $erreur['pseudo']; ?>
		</p>
		<p>
			<label>Nom</label>
			<input type="text" class="form-control" placeholder="nom" name="nom" id="nom" <?= $formValue['nom']; ?>>
			<?= $erreur['nom']; ?>
		</p>
		<p>
			<label>Prénom</label>
			<input type="text" class="form-control" placeholder="prenom" name="prenom" id="prenom" <?= $formValue['prenom']; ?>>
			<?= $erreur['prenom']; ?>
		</p>
		<p>
			<label>Date de Naissance</label>
			<input type="date" class="form-control" placeholder="" name="date_birth" id="date_birth" <?= $formValue['date_birth']; ?>>
			<?= $erreur['date_birth']; ?>
		</p>
		<p>
			<label>Email *</label>
			<input type="email" class="form-control" placeholder="adresse email" name="email" id="email" <?= $formValue['email']; ?>>
			<?= $erreur['email']; ?>
		</p>
		<p>
			<label>Nouveau mot de passe</label>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
			<?= $erreur['password']; ?>
		</p>
		<p>
			<label>Confirmation du nouveau mot de passe</label>
			<input type="password" class="form-control" placeholder="mot de passe" name="password-conf" id="password-conf">
			<?= $erreur['password-conf']; ?>
		</p>
		<p>
			<button type="submit" class="btn btn-default">Modifier</button>
		</p>
	</form>
</section>