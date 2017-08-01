<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la barre de navigation du copte utilisateur
 *
 * File Last Update : 2017 08 01
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
$active['deconnexion'] = '';

if(isset($_GET['page']))
{
	$active[$_GET['page']] = 'active';
}


//------------------------------------------------------------
// HTML
?>
<ul class="nav nav-pills nav-stacked">
  <li role="presentation" class="<?php echo $active['compte']; ?>"><a href="?module=membres&page=compte" role="button" class="btn btn-default">Tableau de bord</a></li>
  <li role="presentation" class="<?php echo $active['modification']; ?>"><a href="?module=membres&page=modification" role="button" class="btn btn-default">Modifier Profil</a></li>
  <li role="presentation" class="<?php echo $active['deconnexion']; ?>"><a href="?module=membres&action=deconnexion" role="button" class="btn btn-default">Déconnexion</a></li>
</ul>