<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * THEME : Default
 * FILE/ROLE : Header
 *
 * File Last Update : 2017 08 29
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
  <title>Billet Simple pour l'Alaska - Jean Forteroche</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- ## -->
  <link rel="stylesheet" href="themes/default/style.css">
  <!-- Font Awesome -->
  <script src="https://use.fontawesome.com/bc9335f8a6.js"></script>
  <!-- ## -->
  <script src="script.js"></script>
  <!-- TinyMCE -->
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=9pda1elbtff18o1jlm56gldul3nlvb4kk8wq6zrbyvgei1ml"></script>
  <script> tinymce.init({ selector: '#contenu' });
  </script>
  <!-- ## -->
</head>
<body>



  <header class="container">
    <!-- NAV MEMBRE -->
    <div id="nav-user">
      <div class="row">
        <div class="col-xs-8 col-sm-8">
          <p class="user-nav-text"> 
            <?php
               if (isset($_SESSION['pseudo'])) { echo 'Bonjour ' . $_SESSION['pseudo']; }
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
            <li role="presentation" <?php echo $active['compte']; ?>><a href="?module=membres&page=compte" title="Consulter son compte"><i class="fa fa-address-card user-compte-icon user-icon" aria-hidden="true"></i> Mon compte</a></li>
            <li role="presentation" <?php echo $active['deconnexion']; ?>><a href="?module=membres&action=deconnexion" title="Se déconnecter"><i class="fa fa-user-times user-deconnexion-icon" aria-hidden="true"></i></a></li>
            <?php
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- Logo -->
    <div class="row header-logo-background">
      <h1 class="logo-text col-xs-12 col-sm-7">Billet simple pour l'Alaska</h1>
      <h4 class="logo-text col-xs-12 col-sm-5 text-right">par Jean Forteroche</h4>
    </div>
  </header>