<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * THEME : Default
 * FILE/ROLE : Header
 *
 * File Last Update : 2017 08 07
 *
 * File Description :
 * -> Header HTML
 */

/**
 * 
 */

// préparation de la class active en fonction de la page
$active['compte'] = '';
$active['home'] = '';
$active['deconnexion'] = '';
$active['connexion'] = '';
$active['inscription'] = '';

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
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jean Forteroche</title>
  <link rel="stylesheet" href="themes/default/style.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- ## -->
  <!-- Font Awesome -->
  <script src="https://use.fontawesome.com/bc9335f8a6.js"></script>
  <!-- ## -->
  <script src="script.js"></script>
</head>
<body>



  <header class="container">
    <!-- NAV MEMBRE -->
    <div id="nav-user">
      <div class="row">
        <div class="col-xs-8 col-sm-8">
          <p class="user-nav-text">Bonjour 
            <?php
               if (isset($_SESSION['pseudo'])) { echo $_SESSION['pseudo']; }
            ?>  
          </p>
        </div>
        <div class="col-xs-4 col-sm-4">
          <ul class="nav nav-pills pull-right">
            <?php
              if (!isset($_SESSION['pseudo'])) {
            ?>
            <li role="presentation" <?php echo $active['connexion']; ?>><a href="?module=membres&page=connexion" title="Se connecter"><i class="fa fa-user user-connexion-icon user-icon" aria-hidden="true"></i></a></li>
            <li role="presentation" <?php echo $active['inscription']; ?>><a href="?module=membres&page=inscription" title="S'inscrire"><i class="fa fa-user-plus user-inscription-icon user-icon" aria-hidden="true"></i></a></li>
            <?php
              } else {
            ?>
            <li role="presentation" <?php echo $active['compte']; ?>><a href="?module=membres&page=compte" title="Consulter son compte"><i class="fa fa-address-card user-compte-icon user-icon" aria-hidden="true"></i></a></li>
            <li role="presentation" <?php echo $active['deconnexion']; ?>><a href="?module=membres&action=deconnexion" title="Se déconnecter"><i class="fa fa-user-times user-deconnexion-icon" aria-hidden="true"></i></a></li>
            <?php
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- Logo -->
    <div class="row">
      <h1 class="logo-text col-xs-12 col-sm-8">Billet simple pour l'Alaska</h1>
      <h3 class="logo-text col-xs-12 col-sm-4 text-right">par Jean Forteroche</h3>
    </div>
  </header>