<?php

session_start();

require('core/config.sql.php');
require('core/classes/sqlmgr.class.php');
require('modules/membres/classes/membre.class.php');
require('modules/membres/classes/membremgr.class.php');
require('core/functions/mvc.php');



// HEADER
require('themes/default/header.php');

// NAVIGATION
require('themes/default/nav.php');


// CONTROLLER
get_controller();




// controleur principal
// appel le conctrolleur du module demandé
// charge la vue
// affiche la vue intégrée au header/nav/footer


// FOOTER
require('themes/default/footer.php');

?>