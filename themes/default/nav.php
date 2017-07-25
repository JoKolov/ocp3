<?php
/**
 * BLOG : Jean Forteroche
 * THEME : default
 * version : 2017 07 21
 * 
 * Navigation HTML
 */
?>
<nav class="container">
	<!-- NAVIGATION -->
	<div class="row">
		<ul class="nav nav-pills">
		  <li role="presentation" class="active"><a href="index.php">Home</a></li>
		  <?php
		  	if(isset($_SESSION['pseudo'])) // utilisateur connecté
		  	{
		  ?>
		  <li role="presentation"><a href="index..php?module=membres&page=deconnexion">Deconnexion</a></li>
		  <?php
		  	}
		  	else // utilisateur non connecté
		  	{
		  ?>
		  <li role="presentation"><a href="index.php?module=membres&page=connexion">Login</a></li>
		  <?php
		  	}
		  ?>
		</ul>
	</div>
</nav>