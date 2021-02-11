<?php
require_once('common.php');
$title = "Accueil";

if (!isset($_SESSION['user.id'])) { // PAS AUTHENTIFIE => CONNEXION
    http_redirection('login.php');
}

$main_html =<<<END
<div class="row cols-sm-12 cols-md-6">
</div>
END;

html_send_page($title,$main_html);
