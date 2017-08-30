<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la barre de navigation du copte utilisateur
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> La nav comprend :
 * -> accueil de l'espace membre
 * -> modification du profil
 * -> déconnexion
 * -> services et outils selon type de compte
 * -> Abonné : gestion ses commentaires
 * -> Admin :	- gestion des billets
 * ->			- gestion des commentaires
 * ->			- gestion des membres
 */

//------------------------------------------------------------
// préparation de la class active en fonction de la page
$active['compte'] = '';
$active['modification'] = '';
$active['billets'] = '';

if(isset($_GET['page']))
{
	$active[$_GET['page']] = 'active';
}
$membre = $_SESSION['membre'];


//------------------------------------------------------------
// HTML
?>
<ul class="nav nav-pills nav-stacked" id="admin-nav">
  <li role="presentation" class="<?php echo $active['compte']; ?>"><a href="?module=membres&page=compte" role="button" class="btn btn-default">Tableau de bord</a></li>
  <li role="presentation" class="<?php echo $active['modification']; ?>"><a href="?module=membres&page=modification" role="button" class="btn btn-default">Mon Profil</a></li>
  
  <!-- RESERVE AUX ADMINS -->
  <?php
  	if ($membre->get_type_id() == 1) // type_id = 1 correspond à un admin
  	{ 
  ?>
  		<li role="presentation" class="<?php echo $active['billets']; ?>"><a href="?module=billets&page=admin" role="button" class="btn btn-default">Mes Billets</a></li>
  <?php
  	} 
  ?>
  <!-- # ADMIN # -->
  
</ul>