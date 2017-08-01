<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * THEME : Default
 * FILE/ROLE : Nav
 *
 * File Last Update : 2017 08 01
 *
 * File Description :
 * -> Navigation/Menu HTML
 */

//------------------------------------------------------------
// préparation de la class active en fonction de la page
$active['compte'] = '';
$active['home'] = '';
$active['deconnexion'] = '';
$active['connexion'] = '';

if(isset($_GET['page']))
{
	$active[$_GET['page']] = 'class="active"';
}
else
{
	$active['home'] = 'class="active"';
}


//------------------------------------------------------------
// HTML
?>
<nav class="container">
	<!-- NAVIGATION -->
	<div class="row">
		<ul class="nav nav-pills">
		  <li role="presentation" <?php echo $active['home']; ?>><a href="index.php">Home</a></li>
		  <?php
		  	if(isset($_SESSION['pseudo'])) // utilisateur connecté
		  	{
		  ?>
		  <li role="presentation" <?php echo $active['compte']; ?>><a href="?module=membres&page=compte">Mon Compte</a></li>
		  <li role="presentation" <?php echo $active['deconnexion']; ?>><a href="?module=membres&action=deconnexion">Deconnexion</a></li>
		  <?php
		  	}
		  	else // utilisateur non connecté
		  	{
		  ?>
		  <li role="presentation" <?php echo $active['connexion']; ?>><a href="index.php?module=membres&page=connexion">Login</a></li>
		  <?php
		  	}
		  ?>
		</ul>
	</div>
</nav>