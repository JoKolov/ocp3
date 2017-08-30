<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de l'inscription
 *
 * File Last Update : 2017 08 24
 *
 * File Description :
 * -> affiche le formulaire d'inscription
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

//------------------------------------------------------------
// Génération des valeurs à afficher
set_view_var();
$var = $_SESSION['view_var'];




//------------------------------------------------------------
// Récupération des données valides du formulaire rempli la fois précédente
// Affichera ces données dans les champs correspondants
$ePOST = array('login' => '', 'email' => '');

function verifPOST($ePOST)
{
	foreach ($ePOST as $key => $value) {
		if(isset($_SESSION[$key])) { $ePOST[$key] = &$_SESSION[$key]; }
	}
	return $ePOST;
}

$ePOST = verifPOST($ePOST);


//------------------------------------------------------------
// HTML
?>


<section>

	<div class="row">
		<div class="col-sm-12">
			<h3>Inscription</h3>
			<?php
				/**
				 * Affichage des erreurs
				 */
				if (isset($var['error']))
				{
				 	echo $var['error']['error'];
				}
			?>
		</div>
	</div>

	<form method="post" action="?module=membres&action=inscription" class="form-horizontal">
	
		<div class="form-group">
			<label for="pseudo" class="col-sm-2 control-label"><?= $var['label']['pseudo']; ?></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="<?= $var['placeholder']['pseudo']; ?>" name="login" id="login" value="<?php echo $ePOST['login']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['login']; ?>
			</div>
		</div>
	
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label"><?= $var['label']['email']; ?></label>
			<div class="col-sm-10">
				<input type="email" class="form-control" placeholder="<?= $var['placeholder']['email']; ?>" name="email" id="email" value="<?php echo $ePOST['email']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['email']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label"><?= $var['label']['password']; ?></label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="<?= $var['placeholder']['password']; ?>" name="password" id="password">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['password']; ?>
			</div>
		</div>

		<div class="">
			<button type="submit" class="btn btn-primary btn-block">Inscription</button>
			<a href="index.php?module=membres&page=connexion" class="btn btn-default btn-block">Se connecter <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>
			
	</form>

</section>