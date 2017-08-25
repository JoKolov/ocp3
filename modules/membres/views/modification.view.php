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


//------------------------------------------------------------
// Génération des valeurs à afficher
set_view_var();
$var = $_SESSION['view_var'];


//------------------------------------------------------------
// HTML
?>
<section>
	<div class="row">
		<div class="col-sm-2">
			<div style="width:100px; height:100px; background-image: url('<?= $membre->get_avatar(); ?>'); background-size: cover; border-radius:5%;" class="">
			</div>
		</div>

		<div class="col-sm-10">
			<h3 class="text-right">Modifier mon compte : <?php echo $_SESSION['pseudo']; ?></h3>

			<?php
			if ($var['success']['1'] <> '') {
			?>
				<div class="alert alert-success" role="alert">
				  <strong><?= $var['success']['1']; ?></strong>
				</div>
			<?php 
			}
			elseif (isset($var['error'])) {
				
				echo $var['error']['error'];

			}	
			?>
		</div>
	</div>	
	


	<form method="post" action="?module=membres&action=modification" enctype="multipart/form-data" class="form-horizontal">
		<div class="form-group">
			<label for="image" class="col-sm-2 control-label"><?= $var['label']['avatar']; ?></label>
			<div class="col-sm-10">
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
				<input type="file" class="form-control" placeholder="votre image" name="image" id="image">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['avatar']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="pseudo" class="col-sm-2 control-label"><?= $var['label']['pseudo']; ?></label>
			<div class="col-sm-10">
				<input type="text" class="form-control col-xs-12 col-sm-8" placeholder="pseudo" name="pseudo" id="pseudo" <?= $formValue['pseudo']; ?>>
			</div>
			<div class="col-sm-12">
				<?= $var['error']['pseudo']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="nom" class="col-sm-2 control-label"><?= $var['label']['nom']; ?></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="nom" name="nom" id="nom" <?= $formValue['nom']; ?>>
			</div>
			<div class="col-sm-12">
				<?= $var['error']['nom']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="prenom" class="col-sm-2 control-label"><?= $var['label']['prenom']; ?></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="prenom" name="prenom" id="prenom" <?= $formValue['prenom']; ?>>
			</div>
			<div class="col-sm-12">
				<?= $var['error']['prenom']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="date_birth" class="col-sm-2 control-label"><?= $var['label']['date_birth']; ?></label>
			<div class="col-sm-10">
				<input type="date" class="form-control" placeholder="" name="date_birth" id="date_birth" <?= $formValue['date_birth']; ?>>
			</div>
			<div class="col-sm-12">
				<?= $var['error']['date_birth']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="email" class="col-sm-2 control-label"><?= $var['label']['email']; ?></label>
			<div class="col-sm-10">
				<input type="email" class="form-control" placeholder="adresse email" name="email" id="email" <?= $formValue['email']; ?>>
			</div>
			<div class="col-sm-12">
				<?= $var['error']['email']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label"><?= $var['label']['password']; ?></label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['password']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="password-conf" class="col-sm-2 control-label"><?= $var['label']['password-conf']; ?></label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="mot de passe" name="password-conf" id="password-conf">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['password-conf']; ?>
			</div>
		</div>

		<div class="text-center">
			<button type="submit" class="btn btn-primary btn-block">Modifier</button>
		</div>
	</form>
</section>